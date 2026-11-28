<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'penulis_id',
        'judul',
        'isbn',
        'tahun_terbit',
        'stok',
        'deskripsi',
        'cover_path',
        'ebook_path',
    ];

    /**
     * Relasi ke entitas Penulis (Many-to-One)
     */
    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'penulis_id');
    }

    /**
     * Relasi ke entitas Peminjaman (One-to-Many)
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}