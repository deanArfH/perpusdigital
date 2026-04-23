<?php

namespace App\Filament\Siswa\Pages;

use App\Models\Buku;
use App\Models\Peminjaman;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class SiswaDashboard extends Page
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -2;

    protected static ?string $navigationLabel = 'Dashboard';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard';

    protected string $view = 'filament.siswa.pages.siswa-dashboard';

    public string $search = '';
    public ?int $selectedBookId = null;
    public bool $showModal = false;

    public function getStats(): array
    {
        $userId = auth()->id();
        $peminjamans = Peminjaman::where('user_id', $userId)->get();

        return [
            'dipinjam' => $peminjamans->where('status', 'dipinjam')->count(),
            'riwayat' => $peminjamans->count(),
            'denda' => $peminjamans->whereIn('status', ['dipinjam', 'menunggu_pembayaran'])->sum('denda_sekarang'),
        ];
    }

    public function getBooks(): Collection
    {
        $query = Buku::query();

        if (filled($this->search)) {
            $query->where(function ($q) {
                $q->where('judul', 'like', "%{$this->search}%")
                  ->orWhere('pengarang', 'like', "%{$this->search}%")
                  ->orWhere('penerbit', 'like', "%{$this->search}%");
            });
        }

        return $query->latest()->limit(8)->get();
    }

    public function getSelectedBook(): ?Buku
    {
        if ($this->selectedBookId) {
            return Buku::find($this->selectedBookId);
        }
        return null;
    }

    public function openDetail(int $bookId): void
    {
        $this->selectedBookId = $bookId;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedBookId = null;
    }

    public function pinjamBuku(int $bookId): void
    {
        $user = auth()->user();
        $buku = Buku::findOrFail($bookId);

        if ($buku->stok <= 0) {
            Notification::make()->title('Gagal')->body('Stok buku habis.')->danger()->send();
            return;
        }

        $existing = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $bookId)
            ->whereIn('status', ['dipinjam', 'menunggu_pembayaran'])
            ->exists();

        if ($existing) {
            Notification::make()->title('Gagal')->body('Anda sudah meminjam buku ini dan belum mengembalikannya.')->danger()->send();
            return;
        }

        $unpaidFines = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['dipinjam', 'menunggu_pembayaran'])
            ->get()
            ->sum('denda_sekarang');

        if ($unpaidFines > 0) {
            Notification::make()
                ->title('Akses Ditolak')
                ->body('Anda tidak dapat meminjam buku baru karena memiliki denda yang belum dilunasi sebesar Rp ' . number_format($unpaidFines, 0, ',', '.') . '.')
                ->danger()
                ->send();
            return;
        }

        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $bookId,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(7),
            'status' => 'dipinjam',
        ]);

        $buku->decrement('stok');

        $this->showModal = false;
        $this->selectedBookId = null;

        Notification::make()
            ->title('Berhasil!')
            ->body("Buku \"{$buku->judul}\" berhasil dipinjam. Kembalikan sebelum " . now()->addDays(7)->format('d M Y') . ".")
            ->success()
            ->send();
    }

    public function searchBooks(): void
    {
        // Livewire will re-render with the search term
    }
}
