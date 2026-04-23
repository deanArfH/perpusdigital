<?php

namespace App\Filament\Pages;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class AdminDashboard extends Page
{
    protected static ?string $slug = '';

    protected static ?int $navigationSort = -2;

    protected static ?string $navigationLabel = 'Dashboard Utama';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard Admin';

    protected string $view = 'filament.pages.admin-dashboard';

    public string $search = '';
    public string $statusFilter = 'semua';

    public function getStats(): array
    {
        return [
            'total_buku' => Buku::count(),
            'total_anggota' => User::where('role', 'siswa')->count(),
            'sedang_dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'transaksi_hari_ini' => Peminjaman::whereDate('created_at', today())->count(),
        ];
    }

    public function getPeminjamans(): Collection
    {
        $query = Peminjaman::with(['buku', 'user'])
            ->latest();

        if (filled($this->search)) {
            $query->whereHas('buku', function ($q) {
                $q->where('judul', 'like', "%{$this->search}%");
            })->orWhereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter !== 'semua') {
            $query->where('status', $this->statusFilter);
        }

        return $query->limit(5)->get();
    }

    public function getChartData(): array
    {
        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $dikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
        $menunggu = Peminjaman::where('status', 'menunggu_pembayaran')->count();
        
        $total = $dipinjam + $dikembalikan + $menunggu;
        
        if ($total === 0) {
            return [
                'dipinjam_pct' => 0, 'dikembalikan_pct' => 0, 'menunggu_pct' => 0,
                'dipinjam' => 0, 'dikembalikan' => 0, 'menunggu' => 0, 'total' => 0
            ];
        }

        return [
            'dipinjam_pct' => round(($dipinjam / $total) * 100),
            'dikembalikan_pct' => round(($dikembalikan / $total) * 100),
            'menunggu_pct' => round(($menunggu / $total) * 100),
            'dipinjam' => $dipinjam,
            'dikembalikan' => $dikembalikan,
            'menunggu' => $menunggu,
            'total' => $total,
        ];
    }

    public function getTopBooks(): Collection
    {
        return Buku::withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->limit(5)
            ->get();
    }

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
    }
}
