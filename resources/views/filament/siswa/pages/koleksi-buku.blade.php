<x-filament-panels::page>
    <style>
        .kb-search-wrap {
            max-width: 480px;
            position: relative;
            margin-bottom: 24px;
        }
        .kb-search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border-radius: 12px;
            border: 1px solid #E7E5E4;
            font-size: 14px;
            background: #FFFFFF;
            color: #1C1917;
            outline: none;
            transition: border-color 0.2s;
        }
        .kb-search-input:focus { border-color: #F59E0B; box-shadow: 0 0 0 3px rgba(245,158,11,0.1); }
        .kb-search-input::placeholder { color: #A8A29E; }
        .kb-search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #A8A29E;
            width: 18px;
            height: 18px;
        }
        .kb-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 1024px) { .kb-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .kb-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .kb-grid { grid-template-columns: 1fr; } }
        .kb-card {
            background: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.025);
            border: 1px solid rgba(0,0,0,0.02);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .kb-card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.02); }
        .kb-cover {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #FDE68A 0%, #F59E0B 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .kb-cover img { width: 100%; height: 100%; object-fit: cover; }
        .kb-cover svg { width: 48px; height: 48px; color: rgba(255,255,255,0.6); }
        .kb-info { padding: 16px; }
        .kb-title { font-size: 15px; font-weight: 700; color: #1C1917; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .kb-author { font-size: 13px; color: #78716C; margin-bottom: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .kb-footer { display: flex; align-items: center; justify-content: space-between; }
        .kb-stock { font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 50px; }
        .kb-stock.available { background: #DCFCE7; color: #16A34A; }
        .kb-stock.low { background: #FEF3C7; color: #D97706; }
        .kb-stock.empty { background: #FEE2E2; color: #DC2626; }
        .kb-year { font-size: 12px; color: #A8A29E; }
        .kb-empty { text-align: center; padding: 64px 24px; color: #78716C; grid-column: 1/-1; }
        .kb-empty svg { width: 64px; height: 64px; margin: 0 auto 16px; color: #D6D3D1; }
        .kb-pagination { margin-top: 8px; }

        /* Modal (reuse dashboard styles) */
        .kb-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px; }
        .kb-modal { background: #FFFFFF; border-radius: 16px; max-width: 640px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.2); position: relative; }
        .kb-modal-close { position: absolute; top: 16px; right: 16px; width: 32px; height: 32px; border-radius: 50%; background: #F5F5F4; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #78716C; z-index: 1; }
        .kb-modal-close:hover { background: #E7E5E4; }
        .kb-modal-body { padding: 32px; }
        .kb-modal-header { font-size: 18px; font-weight: 700; color: #1C1917; margin-bottom: 24px; }
        .kb-modal-content { display: flex; gap: 24px; }
        .kb-modal-cover { width: 180px; height: 240px; border-radius: 12px; overflow: hidden; flex-shrink: 0; background: linear-gradient(135deg, #FDE68A 0%, #F59E0B 100%); display: flex; align-items: center; justify-content: center; }
        .kb-modal-cover img { width: 100%; height: 100%; object-fit: cover; }
        .kb-modal-cover svg { width: 48px; height: 48px; color: rgba(255,255,255,0.6); }
        .kb-modal-details { flex: 1; }
        .kb-modal-title { font-size: 22px; font-weight: 800; color: #1C1917; margin-bottom: 8px; }
        .kb-modal-author { font-size: 14px; color: #78716C; margin-bottom: 16px; }
        .kb-modal-label { font-size: 12px; font-weight: 600; color: #78716C; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .kb-modal-desc { font-size: 14px; color: #44403C; font-style: italic; margin-bottom: 16px; line-height: 1.5; }
        .kb-modal-meta { display: flex; gap: 32px; }
        .kb-modal-meta-item label { font-size: 12px; font-weight: 600; color: #78716C; text-transform: uppercase; letter-spacing: 0.5px; display: block; }
        .kb-modal-meta-item span { font-size: 16px; font-weight: 700; color: #1C1917; }
        .kb-modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 20px 32px; border-top: 1px solid #F5F5F4; }
        .kb-btn { padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; }
        .kb-btn-secondary { background: #F5F5F4; color: #44403C; }
        .kb-btn-secondary:hover { background: #E7E5E4; }
        .kb-btn-primary { background: #F59E0B; color: #FFFFFF; }
        .kb-btn-primary:hover { background: #D97706; }
        .kb-btn-disabled { background: #E7E5E4; color: #A8A29E; cursor: not-allowed; }
        @media (max-width: 640px) { .kb-modal-content { flex-direction: column; } .kb-modal-cover { width: 100%; height: 200px; } }

        .dark .kb-search-input { background: #1C1917; border-color: #292524; color: #FAFAF9; }
        .dark .kb-card { background: #1C1917; border-color: #292524; box-shadow: none; }
        .dark .kb-card:hover { transform: none; box-shadow: none; }
        .dark .kb-title { color: #FAFAF9; }
        .dark .kb-modal { background: #1C1917; }
        .dark .kb-modal-header, .dark .kb-modal-title { color: #FAFAF9; }
        .dark .kb-modal-desc { color: #D6D3D1; }
        .dark .kb-modal-meta-item span { color: #FAFAF9; }
        .dark .kb-modal-footer { border-color: #292524; }
        .dark .kb-btn-secondary { background: #292524; color: #D6D3D1; }
        .dark .kb-modal-close { background: #292524; color: #A8A29E; }
    </style>

    {{-- Search --}}
    <div class="kb-search-wrap">
        <svg class="kb-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
        <input type="text" class="kb-search-input" wire:model.live.debounce.300ms="search" placeholder="Cari buku berdasarkan judul, pengarang, atau penerbit...">
    </div>

    {{-- Book Grid --}}
    @php $books = $this->getBooks(); @endphp
    <div class="kb-grid">
        @forelse($books as $buku)
            <div class="kb-card" wire:click="openDetail({{ $buku->id }})">
                @if($buku->cover)
                    <div class="kb-cover">
                        <img src="/storage/{{ $buku->cover }}" alt="{{ $buku->judul }}" onerror="this.onerror=null; this.parentElement.style.display='none'; this.parentElement.nextElementSibling.style.display='flex';">
                    </div>
                    <div class="kb-cover" style="display:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                @else
                    <div class="kb-cover">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                @endif
                <div class="kb-info">
                    <div class="kb-title">{{ $buku->judul }}</div>
                    <div class="kb-author">{{ $buku->pengarang }}</div>
                    <div class="kb-footer">
                        <span class="kb-stock {{ $buku->stok === 0 ? 'empty' : ($buku->stok <= 2 ? 'low' : 'available') }}">
                            {{ $buku->stok === 0 ? 'Habis' : $buku->stok . ' Tersedia' }}
                        </span>
                        <span class="kb-year">{{ $buku->tahun_terbit ?: '' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="kb-empty">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                <p style="font-size: 16px; font-weight: 600;">Tidak ada buku ditemukan</p>
                <p style="font-size: 14px;">Coba ubah kata kunci pencarian Anda</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="kb-pagination">
        {{ $books->links() }}
    </div>

    {{-- Detail Modal --}}
    @if($showModal && $this->getSelectedBook())
        @php $book = $this->getSelectedBook(); @endphp
        <div class="kb-modal-overlay" wire:click.self="closeModal">
            <div class="kb-modal">
                <button class="kb-modal-close" wire:click="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
                <div class="kb-modal-body">
                    <div class="kb-modal-header">Detail Buku</div>
                    <div class="kb-modal-content">
                        <div class="kb-modal-cover">
                            @if($book->cover)
                                <img src="/storage/{{ $book->cover }}" alt="{{ $book->judul }}" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <svg style="display:none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                            @endif
                        </div>
                        <div class="kb-modal-details">
                            <div class="kb-modal-title">{{ $book->judul }}</div>
                            <div class="kb-modal-author">{{ $book->pengarang }} • {{ $book->penerbit }}</div>
                            <div class="kb-modal-label">Sinopsis / Deskripsi</div>
                            <div class="kb-modal-desc">{{ $book->deskripsi ?: 'Tidak ada deskripsi untuk buku ini.' }}</div>
                            <div class="kb-modal-meta">
                                <div class="kb-modal-meta-item">
                                    <label>Stok</label>
                                    <span>{{ $book->stok }} Tersedia</span>
                                </div>
                                <div class="kb-modal-meta-item">
                                    <label>Tahun</label>
                                    <span>{{ $book->tahun_terbit ?: '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kb-modal-footer">
                    <button class="kb-btn kb-btn-secondary" wire:click="closeModal">Tutup</button>
                    @if($book->stok > 0)
                        <button class="kb-btn kb-btn-primary" wire:click="pinjamBuku({{ $book->id }})">Pinjam Sekarang</button>
                    @else
                        <button class="kb-btn kb-btn-disabled" disabled>Stok Habis</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
