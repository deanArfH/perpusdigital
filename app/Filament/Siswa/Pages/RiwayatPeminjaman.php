<?php

namespace App\Filament\Siswa\Pages;

use App\Models\Peminjaman;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class RiwayatPeminjaman extends Page
{
    protected static ?string $navigationLabel = 'Peminjaman Saya';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $title = 'Riwayat Peminjaman';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.siswa.pages.riwayat-peminjaman';

    public string $filter = 'semua';

    public function getPeminjamans(): Collection
    {
        $query = Peminjaman::with('buku')
            ->where('user_id', auth()->id());

        if ($this->filter === 'dipinjam') {
            $query->where('status', 'dipinjam');
        } elseif ($this->filter === 'dikembalikan') {
            $query->where('status', 'dikembalikan');
        }

        return $query->latest()->get();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function kembalikan(int $id): void
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'dipinjam')
            ->firstOrFail();

        $denda = $peminjaman->denda_sekarang;

        $peminjaman->update([
            'status' => $denda > 0 ? 'menunggu_pembayaran' : 'dikembalikan',
            'tanggal_dikembalikan' => now(),
            'denda' => $denda,
        ]);

        $peminjaman->buku->increment('stok');

        if ($denda > 0) {
            Notification::make()
                ->title('Buku Dikembalikan dengan Denda!')
                ->body("Buku \"{$peminjaman->buku->judul}\" dikembalikan. Anda memiliki tagihan denda Rp " . number_format($denda, 0, ',', '.') . ". Harap segera bayar ke petugas perpustakaan.")
                ->warning()
                ->send();
        } else {
            Notification::make()
                ->title('Berhasil!')
                ->body("Buku \"{$peminjaman->buku->judul}\" berhasil dikembalikan. Terima kasih!")
                ->success()
                ->send();
        }
    }
}
