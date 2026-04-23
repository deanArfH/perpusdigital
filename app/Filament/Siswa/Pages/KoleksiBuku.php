<?php

namespace App\Filament\Siswa\Pages;

use App\Models\Buku;
use App\Models\Peminjaman;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class KoleksiBuku extends Page
{
    protected static ?string $navigationLabel = 'Koleksi Buku';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $title = 'Koleksi Buku';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.siswa.pages.koleksi-buku';

    public string $search = '';
    public ?int $selectedBookId = null;
    public bool $showModal = false;

    public function getBooks(): LengthAwarePaginator
    {
        $query = Buku::query();

        if (filled($this->search)) {
            $query->where(function ($q) {
                $q->where('judul', 'like', "%{$this->search}%")
                  ->orWhere('pengarang', 'like', "%{$this->search}%")
                  ->orWhere('penerbit', 'like', "%{$this->search}%");
            });
        }

        return $query->latest()->paginate(12);
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
                ->body('Anda tidak dapat meminjam buku baru karena memiliki tanggungan denda sebesar Rp ' . number_format($unpaidFines, 0, ',', '.') . '.')
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
            ->body("Buku \"{$buku->judul}\" berhasil dipinjam.")
            ->success()
            ->send();
    }
}
