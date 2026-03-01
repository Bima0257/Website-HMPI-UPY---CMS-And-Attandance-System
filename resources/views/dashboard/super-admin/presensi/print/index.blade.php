<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Presensi - {{ $tanggal }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
        }

        .container {
            width: 100%;
            padding: 15px;
        }

        .no-print {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4 text-center">Laporan Presensi HMPI Tanggal {{ $tanggal }}</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Jam Presensi</th>
                    <th>Waktu Mulai</th>
                    <th>Batas Telat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr>
                        <td>{{ $item->qrCode->nama ?? '-' }}</td>
                        <td>{{ $item->qrCode->jabatan ?? '-' }}</td>
                        <td>{{ $item->waktu_mulai ?? '-' }}</td>
                        <td>{{ $item->batas_telat ?? '-' }}</td>
                        <td>{{ $item->jam_presensi }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
