<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Peminjaman;
use Carbon\Carbon;

$p = new Peminjaman();
$p->status = 'dipinjam';
$p->tanggal_kembali = Carbon::parse('2026-04-22');
echo "Is Past? " . ($p->tanggal_kembali->isPast() ? 'Yes' : 'No') . "\n";
echo "Denda: " . $p->denda_sekarang . "\n";
