<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'cover',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'stok' => 'integer',
        ];
    }

    /**
     * Get the peminjamans (borrowings) for this book.
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Check if the book is available for borrowing.
     */
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}
