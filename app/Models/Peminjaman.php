<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $with = ['buku', 'user'];

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'catatan',
        'denda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
            'tanggal_dikembalikan' => 'date',
        ];
    }

    /**
     * Get the user (siswa) who made this borrowing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Check if this borrowing is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'dipinjam' && $this->tanggal_kembali->isPast();
    }

    /**
     * Get the current accrued fine or the finalized fine.
     */
    public function getDendaSekarangAttribute(): int
    {
        if ($this->status === 'dikembalikan' || $this->status === 'menunggu_pembayaran') {
            return $this->denda ?? 0;
        }

        if ($this->tanggal_kembali && $this->tanggal_kembali->isPast()) {
            $days = $this->tanggal_kembali->startOfDay()->diffInDays(now()->startOfDay());
            return $days * 5000;
        }

        return 0;
    }
}
