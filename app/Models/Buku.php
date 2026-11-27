<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Get the author of the book.
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(Penulis::class);
    }

    /**
     * Get the borrowing records for the book.
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}