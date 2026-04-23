<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

Route::get('/admin/laporan-peminjaman-pdf', function (\Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Akses ditolak.');
    }

    $tanggalAwal = $request->input('tanggal_awal');
    $tanggalAkhir = $request->input('tanggal_akhir');

    $query = \App\Models\Peminjaman::with(['user', 'buku']);

    if ($tanggalAwal) {
        $query->whereDate('tanggal_pinjam', '>=', $tanggalAwal);
    }
    if ($tanggalAkhir) {
        $query->whereDate('tanggal_pinjam', '<=', $tanggalAkhir);
    }

    $peminjamans = $query->orderBy('tanggal_pinjam', 'asc')->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan-peminjaman', [
        'peminjamans' => $peminjamans,
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
    ])->setPaper('a4', 'landscape');

    return $pdf->download('Laporan-Peminjaman-'.now()->format('Ymd').'.pdf');
})->name('admin.laporan-peminjaman.pdf')->middleware('web');
