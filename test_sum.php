<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Peminjaman;
use Carbon\Carbon;

$p1 = new Peminjaman();
$p1->status = 'dipinjam';
$p1->tanggal_kembali = Carbon::parse('2026-04-10');

$p2 = new Peminjaman();
$p2->status = 'dikembalikan';
$p2->denda = 15000;

$collection = collect([$p1, $p2]);

echo "P1 Denda: " . $p1->denda_sekarang . "\n";
echo "P2 Denda: " . $p2->denda_sekarang . "\n";
echo "Sum: " . $collection->sum('denda_sekarang') . "\n";
