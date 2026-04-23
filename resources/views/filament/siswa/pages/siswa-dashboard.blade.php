<x-filament-panels::page>
    <style>
        .sd-hero {
            background: linear-gradient(135deg, #4F46E5 0%, #3730A3 100%);
            border-radius: 16px;
            padding: 48px 32px;
            text-align: center;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px -5px rgba(79, 70, 229, 0.3);
        }
        .sd-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 50%, rgba(255,255,255,0.06) 0%, transparent 50%);
            pointer-events: none;
        }
        .sd-hero-title {
            font-size: 32px;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 8px;
            position: relative;
        }
        .sd-hero-title span {
            color: #F59E0B;
        }
        .sd-hero-sub {
            color: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            margin-bottom: 28px;
            position: relative;
        }
        .sd-search-wrap {
            max-width: 560px;
            margin: 0 auto;
            position: relative;
        }
        .sd-search-input {
            width: 100%;
            padding: 14px 120px 14px 48px;
            border-radius: 50px;
            border: none;
            font-size: 15px;
            background: #FFFFFF;
            color: #1C1917;
            outline: none;
            box-shadow: 0 4px 24px rgba(0,0,0,0.15);
        }
        .sd-search-input::placeholder { color: #A8A29E; }
        .sd-search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #A8A29E;
            width: 20px;
            height: 20px;
        }
        .sd-search-btn {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: #F59E0B;
            color: #FFFFFF;
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .sd-search-btn:hover { background: #D97706; }

        .sd-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }
        .sd-stat-card {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.025);
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .sd-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.02);
        }
        .sd-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sd-stat-icon.dipinjam { background: #FEF3C7; color: #D97706; }
        .sd-stat-icon.riwayat { background: #E0E7FF; color: #4F46E5; }
        .sd-stat-icon.denda { background: #FEE2E2; color: #DC2626; }
        .sd-stat-icon svg { width: 24px; height: 24px; }
        .sd-stat-label { font-size: 12px; color: #78716C; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
        .sd-stat-value { font-size: 24px; font-weight: 800; color: #1C1917; }
        .sd-stat-unit { font-size: 14px; color: #A8A29E; font-weight: 400; margin-left: 4px; }

        .sd-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .sd-section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1C1917;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sd-section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: #F59E0B;
            border-radius: 2px;
        }
        .sd-section-link {
            color: #F59E0B;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .sd-section-link:hover { color: #D97706; }

        .sd-books-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 1024px) { .sd-books-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) {
            .sd-books-grid { grid-template-columns: repeat(2, 1fr); }
            .sd-stats { grid-template-columns: 1fr; }
            .sd-hero-title { font-size: 24px; }
        }

        .sd-book-card {
            background: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.025);
            border: 1px solid rgba(0,0,0,0.02);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .sd-book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .sd-book-cover {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, #FDE68A 0%, #F59E0B 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sd-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .sd-book-cover-placeholder {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #FDE68A 0%, #F59E0B 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sd-book-cover-placeholder svg {
            width: 48px;
            height: 48px;
            color: rgba(255,255,255,0.6);
        }
        .sd-book-info {
            padding: 16px;
        }
        .sd-book-title {
            font-size: 14px;
            font-weight: 700;
            color: #1C1917;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sd-book-author {
            font-size: 13px;
            color: #78716C;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sd-book-stock {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
        }
        .sd-book-stock.available { background: #DCFCE7; color: #16A34A; }
        .sd-book-stock.low { background: #FEF3C7; color: #D97706; }
        .sd-book-stock.empty { background: #FEE2E2; color: #DC2626; }

        /* Modal */
        .sd-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }
        .sd-modal {
            background: #FFFFFF;
            border-radius: 16px;
            max-width: 640px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            position: relative;
        }
        .sd-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F5F5F4;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #78716C;
            transition: background 0.2s;
            z-index: 1;
        }
        .sd-modal-close:hover { background: #E7E5E4; }
        .sd-modal-body {
            padding: 32px;
        }
        .sd-modal-header {
            font-size: 18px;
            font-weight: 700;
            color: #1C1917;
            margin-bottom: 24px;
        }
        .sd-modal-content {
            display: flex;
            gap: 24px;
        }
        .sd-modal-cover {
            width: 180px;
            height: 240px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, #FDE68A 0%, #F59E0B 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sd-modal-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .sd-modal-cover svg {
            width: 48px;
            height: 48px;
            color: rgba(255,255,255,0.6);
        }
        .sd-modal-details {
            flex: 1;
        }
        .sd-modal-book-title {
            font-size: 22px;
            font-weight: 800;
            color: #1C1917;
            margin-bottom: 8px;
        }
        .sd-modal-author {
            font-size: 14px;
            color: #78716C;
            margin-bottom: 16px;
        }
        .sd-modal-desc-label {
            font-size: 12px;
            font-weight: 600;
            color: #78716C;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .sd-modal-desc {
            font-size: 14px;
            color: #44403C;
            font-style: italic;
            margin-bottom: 16px;
            line-height: 1.5;
        }
        .sd-modal-meta {
            display: flex;
            gap: 32px;
            margin-bottom: 8px;
        }
        .sd-modal-meta-item label {
            font-size: 12px;
            font-weight: 600;
            color: #78716C;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }
        .sd-modal-meta-item span {
            font-size: 16px;
            font-weight: 700;
            color: #1C1917;
        }
        .sd-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 20px 32px;
            border-top: 1px solid #F5F5F4;
        }
        .sd-btn {
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .sd-btn-secondary {
            background: #F5F5F4;
            color: #44403C;
        }
        .sd-btn-secondary:hover { background: #E7E5E4; }
        .sd-btn-primary {
            background: #F59E0B;
            color: #FFFFFF;
        }
        .sd-btn-primary:hover { background: #D97706; }
        .sd-btn-disabled {
            background: #E7E5E4;
            color: #A8A29E;
            cursor: not-allowed;
        }
        @media (max-width: 640px) {
            .sd-modal-content { flex-direction: column; }
            .sd-modal-cover { width: 100%; height: 200px; }
        }

        .dark .sd-hero { background: linear-gradient(135deg, #1C1917 0%, #292524 50%, #1C1917 100%); box-shadow: none; }
        .dark .sd-hero::before { background: radial-gradient(circle at 30% 50%, rgba(245,158,11,0.08) 0%, transparent 50%), radial-gradient(circle at 70% 50%, rgba(234,88,12,0.06) 0%, transparent 50%); }
        .dark .sd-hero-sub { color: #A8A29E; }
        .dark .sd-stat-card { background: #1C1917; border-color: #292524; box-shadow: none; }
        .dark .sd-stat-card:hover { transform: none; box-shadow: none; }
        .dark .sd-stat-label { color: #A8A29E; }
        .dark .sd-stat-value { color: #FAFAF9; }
        .dark .sd-book-card { background: #1C1917; border-color: #292524; box-shadow: none; }
        .dark .sd-book-title { color: #FAFAF9; }
        .dark .sd-section-title { color: #FAFAF9; }
        .dark .sd-modal { background: #1C1917; }
        .dark .sd-modal-header { color: #FAFAF9; }
        .dark .sd-modal-book-title { color: #FAFAF9; }
        .dark .sd-modal-desc { color: #D6D3D1; }
        .dark .sd-modal-meta-item span { color: #FAFAF9; }
        .dark .sd-modal-footer { border-color: #292524; }
        .dark .sd-btn-secondary { background: #292524; color: #D6D3D1; }
        .dark .sd-modal-close { background: #292524; color: #A8A29E; }
    </style>

    {{-- Hero Section --}}
    <div class="sd-hero">
        <h1 class="sd-hero-title">Mau Baca <span>Apa Hari Ini?</span></h1>
        <p class="sd-hero-sub">Hai {{ auth()->user()->name }}, temukan koleksi buku berkualitas untuk menemanimu belajar dan berpetualang.</p>
        <div class="sd-search-wrap">
            <svg class="sd-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
            <input type="text" class="sd-search-input" wire:model.live.debounce.300ms="search" placeholder="Cari judul, pengarang, atau penerbit...">
            <button class="sd-search-btn" wire:click="searchBooks">Cari</button>
        </div>
    </div>

    {{-- Stats --}}
    @php $stats = $this->getStats(); @endphp
    <div class="sd-stats">
        <div class="sd-stat-card">
            <div class="sd-stat-icon dipinjam">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <div>
                <div class="sd-stat-label">Sedang Dipinjam</div>
                <div class="sd-stat-value">{{ $stats['dipinjam'] }}<span class="sd-stat-unit">Buku</span></div>
            </div>
        </div>
        <div class="sd-stat-card">
            <div class="sd-stat-icon riwayat">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <div>
                <div class="sd-stat-label">Total Riwayat</div>
                <div class="sd-stat-value">{{ $stats['riwayat'] }}<span class="sd-stat-unit">Kali</span></div>
            </div>
        </div>
        <div class="sd-stat-card">
            <div class="sd-stat-icon denda">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
            </div>
            <div>
                <div class="sd-stat-label">Total Denda</div>
                <div class="sd-stat-value">Rp {{ number_format($stats['denda'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Book Collection --}}
    <div class="sd-section-header">
        <div class="sd-section-title">Koleksi Terbaru</div>
        <a href="{{ \App\Filament\Siswa\Pages\KoleksiBuku::getUrl() }}" class="sd-section-link">Lihat Semua →</a>
    </div>

    @php $books = $this->getBooks(); @endphp
    <div class="sd-books-grid">
        @forelse($books as $buku)
            <div class="sd-book-card" wire:click="openDetail({{ $buku->id }})">
                @if($buku->cover)
                    <div class="sd-book-cover">
                        <img src="/storage/{{ $buku->cover }}" alt="{{ $buku->judul }}" onerror="this.onerror=null; this.parentElement.style.display='none'; this.parentElement.nextElementSibling.style.display='flex';">
                    </div>
                    <div class="sd-book-cover-placeholder" style="display:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                @else
                    <div class="sd-book-cover-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                @endif
                <div class="sd-book-info">
                    <div class="sd-book-title">{{ $buku->judul }}</div>
                    <div class="sd-book-author">{{ $buku->pengarang }}</div>
                    <span class="sd-book-stock {{ $buku->stok === 0 ? 'empty' : ($buku->stok <= 2 ? 'low' : 'available') }}">
                        {{ $buku->stok === 0 ? 'Habis' : $buku->stok . ' Tersedia' }}
                    </span>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 48px; color: #78716C;">
                <p>{{ filled($search) ? 'Tidak ditemukan buku dengan kata kunci "' . $search . '"' : 'Belum ada buku tersedia.' }}</p>
            </div>
        @endforelse
    </div>

    {{-- Book Detail Modal --}}
    @if($showModal && $this->getSelectedBook())
        @php $book = $this->getSelectedBook(); @endphp
        <div class="sd-modal-overlay" wire:click.self="closeModal">
            <div class="sd-modal">
                <button class="sd-modal-close" wire:click="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
                <div class="sd-modal-body">
                    <div class="sd-modal-header">Detail Buku</div>
                    <div class="sd-modal-content">
                        <div class="sd-modal-cover">
                            @if($book->cover)
                                <img src="/storage/{{ $book->cover }}" alt="{{ $book->judul }}" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <svg style="display:none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                            @endif
                        </div>
                        <div class="sd-modal-details">
                            <div class="sd-modal-book-title">{{ $book->judul }}</div>
                            <div class="sd-modal-author">{{ $book->pengarang }} • {{ $book->penerbit }}</div>
                            <div class="sd-modal-desc-label">Sinopsis / Deskripsi</div>
                            <div class="sd-modal-desc">{{ $book->deskripsi ?: 'Tidak ada deskripsi untuk buku ini.' }}</div>
                            <div class="sd-modal-meta">
                                <div class="sd-modal-meta-item">
                                    <label>Stok</label>
                                    <span>{{ $book->stok }} Tersedia</span>
                                </div>
                                <div class="sd-modal-meta-item">
                                    <label>Tahun</label>
                                    <span>{{ $book->tahun_terbit ?: '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sd-modal-footer">
                    <button class="sd-btn sd-btn-secondary" wire:click="closeModal">Tutup</button>
                    @if($book->stok > 0)
                        <button class="sd-btn sd-btn-primary" wire:click="pinjamBuku({{ $book->id }})">Pinjam Sekarang</button>
                    @else
                        <button class="sd-btn sd-btn-disabled" disabled>Stok Habis</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
