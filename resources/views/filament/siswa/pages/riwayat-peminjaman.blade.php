<x-filament-panels::page>
    <div x-data="{ showConfirm: false, confirmId: null }">
    <style>
        .rp-header { margin-bottom: 24px; }
        .rp-header h2 { font-size: 22px; font-weight: 800; color: #1C1917; margin-bottom: 4px; }
        .rp-header p { font-size: 14px; color: #78716C; text-transform: uppercase; letter-spacing: 0.5px; }

        .rp-filters {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
        }
        .rp-filter-btn {
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid #E7E5E4;
            background: #FFFFFF;
            color: #78716C;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .rp-filter-btn:hover { border-color: #F59E0B; color: #D97706; }
        .rp-filter-btn.active {
            background: #F59E0B;
            color: #FFFFFF;
            border-color: #F59E0B;
        }

        .rp-list { display: flex; flex-direction: column; gap: 16px; }

        .rp-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #F5F5F4;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            transition: box-shadow 0.2s;
        }
        .rp-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }

        .rp-cover {
            width: 80px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, #FDE68A 0%, #F59E0B 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .rp-cover img { width: 100%; height: 100%; object-fit: cover; }
        .rp-cover svg { width: 32px; height: 32px; color: rgba(255,255,255,0.6); }

        .rp-content { flex: 1; min-width: 0; }
        .rp-book-title {
            font-size: 16px;
            font-weight: 700;
            color: #1C1917;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .rp-book-author {
            font-size: 13px;
            color: #78716C;
            margin-bottom: 12px;
        }

        .rp-meta {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }
        .rp-meta-item { }
        .rp-meta-label {
            font-size: 11px;
            font-weight: 600;
            color: #A8A29E;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .rp-meta-value {
            font-size: 13px;
            font-weight: 600;
            color: #1C1917;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .rp-meta-value svg { width: 14px; height: 14px; }
        .rp-meta-value.overdue { color: #DC2626; }

        .rp-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }

        .rp-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }
        .rp-badge.dipinjam { background: #FEF3C7; color: #D97706; }
        .rp-badge.dikembalikan { background: #DCFCE7; color: #16A34A; }
        .rp-badge.menunggu_pembayaran { background: #FEE2E2; color: #DC2626; }
        .rp-badge.terlambat { background: #FEE2E2; color: #DC2626; }

        .rp-return-btn {
            padding: 8px 20px;
            border-radius: 10px;
            border: none;
            background: #16A34A;
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .rp-return-btn:hover { background: #15803D; }

        .rp-empty {
            text-align: center;
            padding: 64px 24px;
            color: #78716C;
        }
        .rp-empty svg { width: 64px; height: 64px; margin: 0 auto 16px; color: #D6D3D1; }

        @media (max-width: 640px) {
            .rp-card { flex-direction: column; }
            .rp-right { flex-direction: row; width: 100%; justify-content: space-between; }
            .rp-meta { gap: 16px; }
        }

        .dark .rp-header h2 { color: #FAFAF9; }
        .dark .rp-card { background: #1C1917; border-color: #292524; }
        .dark .rp-book-title { color: #FAFAF9; }
        .dark .rp-meta-value { color: #FAFAF9; }
        .dark .rp-filter-btn { background: #1C1917; border-color: #292524; color: #A8A29E; }
        .dark .rp-filter-btn:hover { border-color: #F59E0B; color: #F59E0B; }
        .dark .rp-filter-btn.active { background: #F59E0B; color: #FFFFFF; border-color: #F59E0B; }

        /* Confirm Modal */
        .rp-modal-overlay {
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
        .rp-modal {
            background: #FFFFFF;
            border-radius: 16px;
            width: 100%;
            max-width: 400px;
            padding: 32px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            text-align: center;
        }
        .rp-modal-icon {
            width: 64px;
            height: 64px;
            background: #FEF3C7;
            color: #D97706;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .rp-modal-icon svg { width: 32px; height: 32px; }
        .rp-modal-title { font-size: 20px; font-weight: 800; color: #1C1917; margin-bottom: 8px; }
        .rp-modal-desc { font-size: 14px; color: #78716C; margin-bottom: 24px; line-height: 1.5; }
        .rp-modal-actions { display: flex; gap: 12px; }
        .rp-modal-actions button { flex: 1; padding: 12px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; border: none; transition: background 0.2s; }
        .rp-btn-cancel { background: #F5F5F4; color: #44403C; }
        .rp-btn-cancel:hover { background: #E7E5E4; }
        .rp-btn-confirm { background: #16A34A; color: #FFFFFF; }
        .rp-btn-confirm:hover { background: #15803D; }
        
        .dark .rp-modal { background: #1C1917; border: 1px solid #292524; }
        .dark .rp-modal-title { color: #FAFAF9; }
        .dark .rp-modal-desc { color: #A8A29E; }
        .dark .rp-btn-cancel { background: #292524; color: #D6D3D1; }
        .dark .rp-btn-cancel:hover { background: #44403C; }
    </style>

    {{-- Header --}}
    <div class="rp-header">
        <h2>Rak Buku Virtual Anda</h2>
        <p>Lacak setiap perjalanan membacamu</p>
    </div>

    {{-- Filters --}}
    <div class="rp-filters">
        <button class="rp-filter-btn {{ $filter === 'semua' ? 'active' : '' }}" wire:click="setFilter('semua')">Semua</button>
        <button class="rp-filter-btn {{ $filter === 'dipinjam' ? 'active' : '' }}" wire:click="setFilter('dipinjam')">Dipinjam</button>
        <button class="rp-filter-btn {{ $filter === 'dikembalikan' ? 'active' : '' }}" wire:click="setFilter('dikembalikan')">Dikembalikan</button>
    </div>

    {{-- Peminjaman List --}}
    @php $peminjamans = $this->getPeminjamans(); @endphp
    <div class="rp-list">
        @forelse($peminjamans as $p)
            <div class="rp-card">
                <div class="rp-cover">
                    @if($p->buku && $p->buku->cover)
                        <img src="{{ asset('storage/' . $p->buku->cover) }}" alt="{{ $p->buku->judul ?? '' }}">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                    @endif
                </div>
                <div class="rp-content">
                    <div class="rp-book-title">{{ $p->buku->judul ?? 'Buku tidak ditemukan' }}</div>
                    <div class="rp-book-author">{{ $p->buku->pengarang ?? '-' }}</div>
                    <div class="rp-meta">
                        <div class="rp-meta-item">
                            <div class="rp-meta-label">Dipinjam</div>
                            <div class="rp-meta-value">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                                {{ $p->tanggal_pinjam->format('d M Y') }}
                            </div>
                        </div>
                        <div class="rp-meta-item">
                            <div class="rp-meta-label">Target Kembali</div>
                            <div class="rp-meta-value {{ $p->status === 'dipinjam' && $p->tanggal_kembali->isPast() ? 'overdue' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                {{ $p->tanggal_kembali->format('d M Y') }}
                            </div>
                        </div>
                        <div class="rp-meta-item">
                            <div class="rp-meta-label">Dikembalikan</div>
                            <div class="rp-meta-value">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                {{ $p->tanggal_dikembalikan ? $p->tanggal_dikembalikan->format('d M Y') : '-' }}
                            </div>
                        </div>
                        <div class="rp-meta-item">
                            <div class="rp-meta-label">Total Denda</div>
                            <div class="rp-meta-value {{ $p->denda_sekarang > 0 ? 'overdue' : '' }}">Rp {{ number_format($p->denda_sekarang, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="rp-right">
                    @if($p->status === 'dipinjam')
                        @if($p->tanggal_kembali->isPast())
                            <span class="rp-badge terlambat">Terlambat</span>
                        @else
                            <span class="rp-badge dipinjam">Dipinjam</span>
                        @endif
                        <button class="rp-return-btn" @click="showConfirm = true; confirmId = {{ $p->id }}">Kembalikan</button>
                    @elseif($p->status === 'menunggu_pembayaran')
                        <span class="rp-badge menunggu_pembayaran">Menunggu Pelunasan</span>
                    @else
                        <span class="rp-badge dikembalikan">Selesai</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="rp-empty">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
                <p style="font-size: 16px; font-weight: 600; color: #44403C;">Belum ada riwayat peminjaman</p>
                <p style="font-size: 14px;">Kunjungi halaman <a href="{{ \App\Filament\Siswa\Pages\KoleksiBuku::getUrl() }}" style="color: #F59E0B; font-weight: 600; text-decoration: none;">Koleksi Buku</a> untuk meminjam buku pertamamu!</p>
            </div>
        @endforelse
    </div>

    <!-- Confirm Modal -->
    <div class="rp-modal-overlay" x-show="showConfirm" style="display: none;" x-transition.opacity>
        <div class="rp-modal" @click.away="showConfirm = false" x-show="showConfirm" x-transition.scale.origin.bottom>
            <div class="rp-modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="rp-modal-title">Konfirmasi Pengembalian</h3>
            <p class="rp-modal-desc">Apakah Anda yakin ingin mengembalikan buku ini? Jika Anda memiliki denda, tagihan akan otomatis tercatat dan harus segera dibayarkan.</p>
            <div class="rp-modal-actions">
                <button class="rp-btn-cancel" @click="showConfirm = false">Batal</button>
                <button class="rp-btn-confirm" wire:click="kembalikan(confirmId)" @click="showConfirm = false">Ya, Kembalikan</button>
            </div>
        </div>
    </div>
    </div>
</x-filament-panels::page>
