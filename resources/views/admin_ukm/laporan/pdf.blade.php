<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan UKM</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; font-size: 14px; color: #555; }
        .summary { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .summary td { padding: 10px; border: 1px solid #ddd; width: 33.33%; text-align: center; font-size: 14px; }
        .summary .amount { font-size: 18px; font-weight: bold; margin-top: 5px; }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .text-blue { color: #2563eb; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .table th { background-color: #f3f4f6; text-transform: uppercase; font-size: 11px; }
        .text-right { text-align: right !important; }
        .footer { margin-top: 50px; width: 100%; }
        .signature { float: right; text-align: center; width: 250px; }
        .signature-space { height: 80px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN KEUANGAN KAS</h1>
        <p>{{ $ukm->nama_ukm }}</p>
        <p style="font-size: 12px; margin-top: 5px;">Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    </div>

    <table class="summary">
        <tr>
            <td>
                Total Pemasukan
                <div class="amount text-green">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
            </td>
            <td>
                Total Pengeluaran
                <div class="amount text-red">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
            </td>
            <td>
                Saldo Akhir
                <div class="amount text-blue">Rp {{ number_format($saldoKas, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <h3 style="margin-bottom: 5px;">Rincian Transaksi:</h3>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="35%">Keterangan</th>
                <th width="20%" class="text-right">Pemasukan</th>
                <th width="20%" class="text-right">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="text-right text-green">
                    {{ $item->jenis == 'Pemasukan' ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                </td>
                <td class="text-right text-red">
                    {{ $item->jenis == 'Pengeluaran' ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada riwayat transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p style="margin-bottom: 0;">Pengurus {{ $ukm->nama_ukm }}</p>
            <div class="signature-space"></div>
            <p style="text-decoration: underline; font-weight: bold; margin-bottom: 0;">{{ Auth::user()->name }}</p>
            <p style="margin-top: 0;">Administrator</p>
        </div>
    </div>

</body>
</html>