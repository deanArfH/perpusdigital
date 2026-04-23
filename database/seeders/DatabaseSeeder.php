<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin user
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@perpustakaan.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Siswa users
        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@siswa.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Rahayu',
            'username' => 'siti',
            'email' => 'siti@siswa.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
        ]);

        $siswa3 = User::create([
            'name' => 'Ahmad Hidayat',
            'username' => 'ahmad',
            'email' => 'ahmad@siswa.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
        ]);

        // Create sample books
        $buku1 = Buku::create([
            'judul' => 'Laskar Pelangi',
            'pengarang' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun_terbit' => 2005,
            'isbn' => '978-979-1227-00-2',
            'stok' => 5,
            'deskripsi' => 'Novel yang menceritakan kisah 10 anak dari keluarga miskin yang bersekolah di Belitung.',
        ]);

        $buku2 = Buku::create([
            'judul' => 'Bumi Manusia',
            'pengarang' => 'Pramoedya Ananta Toer',
            'penerbit' => 'Hasta Mitra',
            'tahun_terbit' => 1980,
            'isbn' => '978-979-9731-28-0',
            'stok' => 3,
            'deskripsi' => 'Novel pertama dari Tetralogi Buru yang bercerita tentang kehidupan di era kolonial.',
        ]);

        $buku3 = Buku::create([
            'judul' => 'Filosofi Teras',
            'pengarang' => 'Henry Manampiring',
            'penerbit' => 'Penerbit Buku Kompas',
            'tahun_terbit' => 2018,
            'isbn' => '978-602-412-485-3',
            'stok' => 7,
            'deskripsi' => 'Buku tentang filsafat Stoa yang dikemas dengan gaya bahasa modern dan relevan.',
        ]);

        $buku4 = Buku::create([
            'judul' => 'Atomic Habits',
            'pengarang' => 'James Clear',
            'penerbit' => 'Gramedia Pustaka Utama',
            'tahun_terbit' => 2019,
            'isbn' => '978-602-06-1614-7',
            'stok' => 4,
            'deskripsi' => 'Panduan praktis untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk.',
        ]);

        $buku5 = Buku::create([
            'judul' => 'Sang Pemimpi',
            'pengarang' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun_terbit' => 2006,
            'isbn' => '978-979-1227-06-4',
            'stok' => 6,
            'deskripsi' => 'Sekuel dari Laskar Pelangi yang mengisahkan perjuangan Ikal dan Arai meraih mimpi.',
        ]);

        Buku::create([
            'judul' => 'Negeri 5 Menara',
            'pengarang' => 'Ahmad Fuadi',
            'penerbit' => 'Gramedia Pustaka Utama',
            'tahun_terbit' => 2009,
            'isbn' => '978-979-22-5135-5',
            'stok' => 4,
            'deskripsi' => 'Novel inspiratif tentang kehidupan di pondok pesantren dan semangat mengejar ilmu.',
        ]);

        Buku::create([
            'judul' => 'Sapiens: Riwayat Singkat Umat Manusia',
            'pengarang' => 'Yuval Noah Harari',
            'penerbit' => 'Kepustakaan Populer Gramedia',
            'tahun_terbit' => 2017,
            'isbn' => '978-602-424-171-0',
            'stok' => 2,
            'deskripsi' => 'Buku yang membahas perjalanan evolusi dan sejarah umat manusia.',
        ]);

        Buku::create([
            'judul' => 'Pulang',
            'pengarang' => 'Tere Liye',
            'penerbit' => 'Republika Penerbit',
            'tahun_terbit' => 2015,
            'isbn' => '978-602-0851-44-7',
            'stok' => 5,
            'deskripsi' => 'Novel tentang pencarian jati diri dan makna pulang ke kampung halaman.',
        ]);

        // Create sample peminjaman (borrowing transactions)
        Peminjaman::create([
            'user_id' => $siswa1->id,
            'buku_id' => $buku1->id,
            'tanggal_pinjam' => now()->subDays(5),
            'tanggal_kembali' => now()->addDays(9),
            'status' => 'dipinjam',
        ]);

        Peminjaman::create([
            'user_id' => $siswa1->id,
            'buku_id' => $buku3->id,
            'tanggal_pinjam' => now()->subDays(10),
            'tanggal_kembali' => now()->subDays(3),
            'tanggal_dikembalikan' => now()->subDays(4),
            'status' => 'dikembalikan',
        ]);

        Peminjaman::create([
            'user_id' => $siswa2->id,
            'buku_id' => $buku2->id,
            'tanggal_pinjam' => now()->subDays(3),
            'tanggal_kembali' => now()->addDays(11),
            'status' => 'dipinjam',
        ]);

        Peminjaman::create([
            'user_id' => $siswa3->id,
            'buku_id' => $buku4->id,
            'tanggal_pinjam' => now()->subDays(7),
            'tanggal_kembali' => now()->addDays(7),
            'status' => 'dipinjam',
        ]);

        Peminjaman::create([
            'user_id' => $siswa2->id,
            'buku_id' => $buku5->id,
            'tanggal_pinjam' => now()->subDays(14),
            'tanggal_kembali' => now()->subDays(7),
            'tanggal_dikembalikan' => now()->subDays(8),
            'status' => 'dikembalikan',
        ]);
    }
}
