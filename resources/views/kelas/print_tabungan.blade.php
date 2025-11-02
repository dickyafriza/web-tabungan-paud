<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Kelas {{ $kelas->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h3 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: left; }
        .no-print { margin-bottom: 15px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Cetak</button>
    </div>

    <h3>Daftar Siswa Kelas: {{ $kelas->nama }}</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Total Saldo Tabungan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($siswa as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>Rp {{ number_format($s->saldo, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada siswa</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
