<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$books = App\Models\Buku::select('id', 'judul', 'cover')->limit(5)->get();
foreach($books as $book) {
    echo "ID: {$book->id} - Judul: {$book->judul}\n";
    echo "Cover DB: " . json_encode($book->cover) . "\n";
    echo "Storage::url: " . \Illuminate\Support\Facades\Storage::url($book->cover) . "\n";
    echo "asset: " . asset('storage/' . $book->cover) . "\n";
    echo "Exists on disk: " . (\Illuminate\Support\Facades\Storage::disk('public')->exists($book->cover ?? '') ? 'Yes' : 'No') . "\n";
    echo "--------------------------\n";
}
