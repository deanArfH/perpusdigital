<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman Buku</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f5; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { font-weight: bold; }
        .dipinjam { color: #d97706; }
        .dikembalikan { color: #16a34a; }
        .menunggu_pembayaran { color: #dc2626; }
        .footer { text-align: right; margin-top: 30px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Peminjaman Buku Perpustakaan</h2>
        <p>
            Periode: 
            {{ $tanggalAwal ? \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') : 'Awal' }} 
            s/d 
            {{ $tanggalAkhir ? \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') : 'Akhir' }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Siswa</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Status</th>
                <th class="text-right">Denda (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDenda = 0; @endphp
            @forelse ($peminjamans as $index => $p)
                @php 
                    $denda = $p->denda_sekarang; 
                    $totalDenda += $denda;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                    <td>
                        @if($p->status === 'dipinjam')
                            @if($p->tanggal_kembali->isPast())
                                <span class="badge menunggu_pembayaran">Terlambat</span>
                            @else
                                <span class="badge dipinjam">Dipinjam</span>
                            @endif
                        @elseif($p->status === 'menunggu_pembayaran')
                            <span class="badge menunggu_pembayaran">Menunggu Pelunasan</span>
                        @else
                            <span class="badge dikembalikan">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data peminjaman pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">TOTAL DENDA KESELURUHAN:</th>
                <th class="text-right">Rp {{ number_format($totalDenda, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Admin Perpustakaan</strong></p>
    </div>

</body>
</html>
