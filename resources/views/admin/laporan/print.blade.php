<html>
<head>
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Penjualan DeliGo 🍔</h2>
    <p>Periode: {{ $start }} → {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>Rp {{ number_format($item->total) }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total Omset: <b>Rp {{ number_format($total) }}</b></h4>
    <p style="margin-top: 50px;">📅 Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
</body>
</html>
