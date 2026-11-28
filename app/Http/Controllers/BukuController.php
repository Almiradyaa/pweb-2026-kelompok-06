<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penulis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * 1. Tampilkan Daftar / Katalog Buku (Search, Filter, & Pagination)
     */
    public function index(Request $request)
    {
        $query = Buku::with('penulis');

        // Pencarian berdasarkan Judul atau ISBN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Penulis (Opsional)
        if ($request->filled('penulis_id')) {
            $query->where('penulis_id', $request->penulis_id);
        }

        // Pagination 10 data per halaman (Menjaga Query String saat navigasi)
        $bukuList = $query->latest()->paginate(10)->withQueryString();

        return view('buku.index', compact('bukuList'));
    }

    /**
     * 2. Form Tambah Data Buku
     */
    public function create()
    {
        $penulisList = Penulis::all(); // Untuk dropdown Pilihan Penulis
        return view('buku.create', compact('penulisList'));
    }

    /**
     * 3. Simpan Data Buku Baru (Store)
     */
    public function store(Request $request)
    {
        // Validasi Server-Side
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis_id'   => 'required|exists:penulis,id',
            'isbn'         => 'required|string|max:20|unique:buku,isbn',
            'tahun_terbit' => 'required|integer|digits:4|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
            'ebook_file'   => 'nullable|mimes:pdf|max:10240',               // Maks 10MB
        ], [
            'judul.required'        => 'Judul buku wajib diisi.',
            'penulis_id.required'   => 'Silakan pilih penulis buku.',
            'penulis_id.exists'     => 'Data penulis tidak valid.',
            'isbn.required'         => 'Nomor ISBN wajib diisi.',
            'isbn.unique'           => 'Nomor ISBN ini sudah terdaftar pada buku lain.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits'   => 'Tahun terbit harus berupa 4 digit angka.',
            'stok.required'         => 'Jumlah stok wajib diisi.',
            'stok.min'              => 'Jumlah stok tidak boleh bernilai negatif.',
            'cover_image.image'     => 'Sampul buku harus berupa berkas gambar.',
            'cover_image.max'       => 'Ukuran gambar sampul maksimal 2 MB.',
            'ebook_file.mimes'      => 'Berkas e-Book harus berformat PDF.',
        ]);

        // Simpan File Gambar Sampul ke Storage
        if ($request->hasFile('cover_image')) {
            $validated['cover_path'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Simpan File PDF e-Book ke Storage
        if ($request->hasFile('ebook_file')) {
            $validated['ebook_path'] = $request->file('ebook_file')->store('ebooks', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }

    /**
     * 4. Detail Data Buku
     */
    public function show($id)
    {
        $buku = Buku::with('penulis')->findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    /**
     * 5. Form Edit Data Buku
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $penulisList = Penulis::all();
        return view('buku.edit', compact('buku', 'penulisList'));
    }

    /**
     * 6. Perbarui Data Buku (Update)
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis_id'   => 'required|exists:penulis,id',
            'isbn'         => ['required', 'string', 'max:20', Rule::unique('buku', 'isbn')->ignore($buku->id)],
            'tahun_terbit' => 'required|integer|digits:4|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ebook_file'   => 'nullable|mimes:pdf|max:10240',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'isbn.unique'    => 'Nomor ISBN ini sudah terdaftar pada buku lain.',
            'stok.min'       => 'Jumlah stok tidak boleh bernilai negatif.',
        ]);

        // Perbarui Gambar Sampul (Hapus file lama jika ada)
        if ($request->hasFile('cover_image')) {
            if ($buku->cover_path && Storage::disk('public')->exists($buku->cover_path)) {
                Storage::disk('public')->delete($buku->cover_path);
            }
            $validated['cover_path'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Perbarui File e-Book PDF (Hapus file lama jika ada)
        if ($request->hasFile('ebook_file')) {
            if ($buku->ebook_path && Storage::disk('public')->exists($buku->ebook_path)) {
                Storage::disk('public')->delete($buku->ebook_path);
            }
            $validated['ebook_path'] = $request->file('ebook_file')->store('ebooks', 'public');
        }

        $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Perubahan data buku berhasil disimpan.');
    }

    /**
     * 7. Hapus Data Buku (Destroy)
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus file fisik dari Storage sebelum data dihapus
        if ($buku->cover_path && Storage::disk('public')->exists($buku->cover_path)) {
            Storage::disk('public')->delete($buku->cover_path);
        }
        if ($buku->ebook_path && Storage::disk('public')->exists($buku->ebook_path)) {
            Storage::disk('public')->delete($buku->ebook_path);
        }

        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus.');
    }
}