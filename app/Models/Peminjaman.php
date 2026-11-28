<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_dikembalikan',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali_rencana' => 'date',
            'tanggal_dikembalikan' => 'date',
        ];
    }

    /**
     * Relasi peminjaman dengan anggota.
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    /**
     * Relasi peminjaman dengan buku.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Memeriksa apakah masa peminjaman sudah berakhir.
     */
    public function isExpired(): bool
    {
        return $this->tanggal_kembali_rencana
            ->lt(now()->startOfDay());
    }
}