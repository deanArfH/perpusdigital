<x-filament-panels::page>
    <style>
        .adm-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }
        @media (max-width: 1024px) { .adm-stats { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .adm-stats { grid-template-columns: 1fr; } }
        
        .adm-stat-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .adm-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
        
        .adm-stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .adm-stat-icon svg { width: 28px; height: 28px; }
        
        /* Different colors for different stats */
        .adm-icon-blue { background: #EFF6FF; color: #3B82F6; }
        .adm-icon-green { background: #F0FDF4; color: #10B981; }
        .adm-icon-amber { background: #FFFBEB; color: #F59E0B; }
        .adm-icon-purple { background: #F5F3FF; color: #8B5CF6; }

        .adm-stat-content { flex: 1; }
        .adm-stat-label { font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .adm-stat-value { font-size: 28px; font-weight: 800; color: #111827; line-height: 1; }

        /* Main Section */
        .adm-section {
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            border: 1px solid rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .adm-section-header {
            padding: 24px;
            border-bottom: 1px solid #F3F4F6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .adm-section-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }
        
        /* Controls (Search & Filter) */
        .adm-controls {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .adm-search-wrap {
            position: relative;
            min-width: 280px;
        }
        .adm-search-input {
            width: 100%;
            padding: 10px 16px 10px 44px;
            border-radius: 10px;
            border: 1px solid #E5E7EB;
            font-size: 14px;
            background: #F9FAFB;
            color: #111827;
            outline: none;
            transition: all 0.2s;
        }
        .adm-search-input:focus {
            background: #FFFFFF;
            border-color: #6366F1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .adm-search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            width: 18px;
            height: 18px;
        }

        .adm-filters {
            display: flex;
            background: #F3F4F6;
            padding: 4px;
            border-radius: 10px;
        }
        .adm-filter-btn {
            padding: 6px 16px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: #6B7280;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .adm-filter-btn:hover { color: #374151; }
        .adm-filter-btn.active {
            background: #FFFFFF;
            color: #111827;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Table */
        .adm-table-wrap { overflow-x: auto; }
        .adm-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .adm-table th {
            padding: 16px 24px;
            font-size: 12px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #F9FAFB;
            border-bottom: 1px solid #E5E7EB;
        }
        .adm-table td {
            padding: 16px 24px;
            border-bottom: 1px solid #F3F4F6;
            font-size: 14px;
            color: #374151;
            vertical-align: middle;
        }
        .adm-table tr:last-child td { border-bottom: none; }
        .adm-table tr:hover { background: #F9FAFB; }
        
        .adm-user-cell { display: flex; align-items: center; gap: 12px; }
        .adm-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #E0E7FF;
            color: #4F46E5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }
        .adm-user-info { display: flex; flex-direction: column; }
        .adm-user-name { font-weight: 600; color: #111827; }
        
        .adm-book-title { font-weight: 600; color: #111827; margin-bottom: 2px; }
        .adm-book-date { font-size: 12px; color: #6B7280; display: flex; align-items: center; gap: 4px; }
        .adm-book-date svg { width: 14px; height: 14px; }
        
        .adm-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .adm-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .adm-badge.dipinjam { background: #FEF3C7; color: #D97706; }
        .adm-badge.dipinjam::before { background: #D97706; }
        .adm-badge.dikembalikan { background: #DCFCE7; color: #16A34A; }
        .adm-badge.dikembalikan::before { background: #16A34A; }
        
        .adm-empty {
            padding: 64px 24px;
            text-align: center;
            color: #6B7280;
        }
        .adm-empty svg { width: 48px; height: 48px; margin: 0 auto 16px; color: #D1D5DB; }

        /* Dark mode overrides */
        .dark .adm-stat-card { background: #1E293B; border-color: #334155; box-shadow: none; }
        .dark .adm-stat-card:hover { transform: none; box-shadow: none; }
        .dark .adm-stat-label { color: #94A3B8; }
        .dark .adm-stat-value { color: #F8FAFC; }
        
        .dark .adm-icon-blue { background: rgba(59, 130, 246, 0.2); color: #60A5FA; }
        .dark .adm-icon-green { background: rgba(16, 185, 129, 0.2); color: #34D399; }
        .dark .adm-icon-amber { background: rgba(245, 158, 11, 0.2); color: #FBBF24; }
        .dark .adm-icon-purple { background: rgba(139, 92, 246, 0.2); color: #A78BFA; }

        .dark .adm-section { background: #1E293B; border-color: #334155; box-shadow: none; }
        .dark .adm-section-header { border-color: #334155; }
        .dark .adm-section-title { color: #F8FAFC; }
        
        .dark .adm-search-input { background: #0F172A; border-color: #334155; color: #F8FAFC; }
        .dark .adm-search-input:focus { border-color: #818CF8; background: #0F172A; }
        
        .dark .adm-filters { background: #0F172A; }
        .dark .adm-filter-btn { color: #94A3B8; }
        .dark .adm-filter-btn.active { background: #334155; color: #F8FAFC; }
        
        .dark .adm-table th { background: #0F172A; border-color: #334155; color: #94A3B8; }
        .dark .adm-table td { border-color: #334155; color: #CBD5E1; }
        .dark .adm-table tr:hover { background: #0F172A; }
        .dark .adm-user-name { color: #F8FAFC; }
        .dark .adm-book-title { color: #F8FAFC; }
        .dark .adm-book-date { color: #94A3B8; }
        .adm-main-grid {
            display: grid;
            grid-template-columns: 28% 28% 44%;
            gap: 20px;
        }
        @media (max-width: 1200px) { .adm-main-grid { grid-template-columns: 1fr 1fr; } .adm-col-recent { grid-column: span 2; } }
        @media (max-width: 768px) { .adm-main-grid { grid-template-columns: 1fr; } .adm-col-recent { grid-column: span 1; } }

        /* Chart Styles */
        .adm-chart-container { padding: 24px; display: flex; flex-direction: column; align-items: center; }
        .adm-donut {
            width: 180px; height: 180px; border-radius: 50%; position: relative; margin-bottom: 32px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .adm-donut-inner {
            position: absolute; inset: 25px; background: #FFFFFF; border-radius: 50%;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .dark .adm-donut-inner { background: #1E293B; }
        .adm-donut-total { font-size: 28px; font-weight: 800; color: #111827; line-height: 1; }
        .dark .adm-donut-total { color: #F8FAFC; }
        .adm-donut-label { font-size: 11px; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 4px; }
        
        .adm-chart-legend { width: 100%; display: flex; flex-direction: column; gap: 12px; }
        .adm-legend-item { display: flex; justify-content: space-between; align-items: center; font-size: 13px; }
        .adm-legend-label { display: flex; align-items: center; gap: 8px; color: #4B5563; font-weight: 500; }
        .dark .adm-legend-label { color: #94A3B8; }
        .adm-legend-dot { width: 12px; height: 12px; border-radius: 4px; }
        .adm-legend-val { font-weight: 700; color: #111827; }
        .dark .adm-legend-val { color: #F8FAFC; }

        /* Top Books Styles */
        .adm-top-list { padding: 0 24px 24px; display: flex; flex-direction: column; gap: 16px; }
        .adm-top-item { display: flex; align-items: center; gap: 12px; padding: 8px 0; border-bottom: 1px solid #F3F4F6; }
        .dark .adm-top-item { border-color: #334155; }
        .adm-top-item:last-child { border-bottom: none; padding-bottom: 0; }
        .adm-top-rank { font-size: 18px; font-weight: 800; color: #D1D5DB; width: 24px; text-align: center; }
        .adm-top-item:nth-child(1) .adm-top-rank { color: #F59E0B; }
        .adm-top-item:nth-child(2) .adm-top-rank { color: #9CA3AF; }
        .adm-top-item:nth-child(3) .adm-top-rank { color: #B45309; }
        .adm-top-cover { width: 44px; height: 60px; border-radius: 6px; object-fit: cover; background: #E5E7EB; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .dark .adm-top-cover { background: #334155; }
        .adm-top-info { flex: 1; min-width: 0; }
        .adm-top-title { font-size: 14px; font-weight: 700; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; }
        .dark .adm-top-title { color: #F8FAFC; }
        .adm-top-author { font-size: 12px; color: #6B7280; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .adm-top-count { font-size: 11px; font-weight: 700; color: #6366F1; display: inline-flex; align-items: center; gap: 4px; background: #EEF2FF; padding: 2px 8px; border-radius: 50px; }
        .dark .adm-top-count { background: rgba(99,102,241,0.2); color: #818CF8; }

        /* Compact Table Overrides */
        .adm-col-recent .adm-table th, .adm-col-recent .adm-table td { padding: 12px 16px; }
        .adm-col-recent .adm-section-header { padding: 16px 20px; flex-direction: column; align-items: flex-start; gap: 12px; }
        .adm-col-recent .adm-controls { width: 100%; justify-content: space-between; }
        .adm-col-recent .adm-search-wrap { min-width: 0; flex: 1; }
        .adm-col-recent .adm-user-name { font-size: 13px; }
        .adm-col-recent .adm-book-title { font-size: 13px; }
    </style>

    @php 
        $stats = $this->getStats(); 
        $chart = $this->getChartData();
        $topBooks = $this->getTopBooks();
    @endphp
    
    {{-- Stats Cards --}}
    <div class="adm-stats">
        <div class="adm-stat-card">
            <div class="adm-stat-icon adm-icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <div class="adm-stat-content">
                <div class="adm-stat-label">Total Buku</div>
                <div class="adm-stat-value">{{ number_format($stats['total_buku']) }}</div>
            </div>
        </div>
        <div class="adm-stat-card">
            <div class="adm-stat-icon adm-icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
            </div>
            <div class="adm-stat-content">
                <div class="adm-stat-label">Total Anggota</div>
                <div class="adm-stat-value">{{ number_format($stats['total_anggota']) }}</div>
            </div>
        </div>
        <div class="adm-stat-card">
            <div class="adm-stat-icon adm-icon-amber">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <div class="adm-stat-content">
                <div class="adm-stat-label">Buku Dipinjam</div>
                <div class="adm-stat-value">{{ number_format($stats['sedang_dipinjam']) }}</div>
            </div>
        </div>
        <div class="adm-stat-card">
            <div class="adm-stat-icon adm-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <div class="adm-stat-content">
                <div class="adm-stat-label">Transaksi Hari Ini</div>
                <div class="adm-stat-value">{{ number_format($stats['transaksi_hari_ini']) }}</div>
            </div>
        </div>
    </div>

    {{-- Main Grid Layout --}}
    <div class="adm-main-grid">
        
        {{-- Column 1: Chart --}}
        <div class="adm-section">
            <div class="adm-section-header">
                <div class="adm-section-title">Status Peminjaman</div>
            </div>
            <div class="adm-chart-container">
                @php
                    $deg1 = ($chart['dipinjam_pct'] / 100) * 360;
                    $deg2 = $deg1 + (($chart['dikembalikan_pct'] / 100) * 360);
                @endphp
                <div class="adm-donut" style="background: conic-gradient(#F59E0B 0deg {{ $deg1 }}deg, #10B981 {{ $deg1 }}deg {{ $deg2 }}deg, #EF4444 {{ $deg2 }}deg 360deg);">
                    <div class="adm-donut-inner">
                        <div class="adm-donut-total">{{ $chart['total'] }}</div>
                        <div class="adm-donut-label">Total Data</div>
                    </div>
                </div>
                <div class="adm-chart-legend">
                    <div class="adm-legend-item">
                        <div class="adm-legend-label"><div class="adm-legend-dot" style="background: #F59E0B;"></div> Dipinjam</div>
                        <div class="adm-legend-val">{{ $chart['dipinjam'] }} ({{ $chart['dipinjam_pct'] }}%)</div>
                    </div>
                    <div class="adm-legend-item">
                        <div class="adm-legend-label"><div class="adm-legend-dot" style="background: #10B981;"></div> Dikembalikan</div>
                        <div class="adm-legend-val">{{ $chart['dikembalikan'] }} ({{ $chart['dikembalikan_pct'] }}%)</div>
                    </div>
                    <div class="adm-legend-item">
                        <div class="adm-legend-label"><div class="adm-legend-dot" style="background: #EF4444;"></div> Belum Lunas</div>
                        <div class="adm-legend-val">{{ $chart['menunggu'] }} ({{ $chart['menunggu_pct'] }}%)</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Column 2: Top Books --}}
        <div class="adm-section">
            <div class="adm-section-header">
                <div class="adm-section-title">Top 5 Populer</div>
            </div>
            <div class="adm-top-list">
                @forelse($topBooks as $index => $buku)
                    <div class="adm-top-item">
                        <div class="adm-top-rank">{{ $index + 1 }}</div>
                        @if($buku->cover)
                            <img class="adm-top-cover" src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}">
                        @else
                            <div class="adm-top-cover" style="display:flex;align-items:center;justify-content:center;color:#9CA3AF;">
                                <svg style="width:24px;height:24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </div>
                        @endif
                        <div class="adm-top-info">
                            <div class="adm-top-title">{{ $buku->judul }}</div>
                            <div class="adm-top-author">{{ $buku->pengarang }}</div>
                            <div class="adm-top-count">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                {{ $buku->peminjamans_count }} Dipinjam
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 32px; text-align: center; color: #6B7280;">Belum ada data peminjaman.</div>
                @endforelse
            </div>
        </div>

        {{-- Column 3: Recent Activity (Compact) --}}
        <div class="adm-section adm-col-recent">
            <div class="adm-section-header">
                <div class="adm-section-title">Aktivitas Terkini</div>
                <div class="adm-controls">
                    <div class="adm-search-wrap">
                        <svg class="adm-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                        <input type="text" class="adm-search-input" wire:model.live.debounce.300ms="search" placeholder="Cari...">
                    </div>
                    <div class="adm-filters">
                        <button class="adm-filter-btn {{ $statusFilter === 'semua' ? 'active' : '' }}" wire:click="setFilter('semua')">Semua</button>
                        <button class="adm-filter-btn {{ $statusFilter === 'dipinjam' ? 'active' : '' }}" wire:click="setFilter('dipinjam')">Dipinjam</button>
                    </div>
                </div>
            </div>
            
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Siswa & Buku</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $peminjamans = $this->getPeminjamans(); @endphp
                        @forelse($peminjamans as $p)
                            <tr>
                                <td>
                                    <div class="adm-user-cell">
                                        <div class="adm-avatar" style="width:32px;height:32px;font-size:12px;">{{ substr($p->user->name ?? '?', 0, 1) }}</div>
                                        <div class="adm-user-info">
                                            <div class="adm-user-name">{{ $p->user->name ?? 'User Tidak Diketahui' }}</div>
                                            <div class="adm-book-title" style="margin-top:2px; color:#6B7280; font-weight:500;">{{ $p->buku->judul ?? '-' }}</div>
                                            <div class="adm-book-date" style="margin-top:2px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                                {{ $p->tanggal_kembali->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($p->status === 'menunggu_pembayaran')
                                        <span class="adm-badge" style="background:#FEE2E2; color:#DC2626;">Denda</span>
                                    @else
                                        <span class="adm-badge {{ $p->status }}">{{ ucfirst($p->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    <div class="adm-empty" style="padding:32px 16px;">
                                        <p style="font-size: 14px; font-weight: 600; color: #111827;" class="dark:text-slate-200">Tidak ada data</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="padding: 12px; text-align: center; border-top: 1px solid #F3F4F6;" class="dark:border-slate-700">
                    <a href="{{ \App\Filament\Resources\PeminjamanResource::getUrl() }}" style="font-size: 13px; font-weight: 600; color: #6366F1; text-decoration: none;">Lihat Semua Transaksi &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
