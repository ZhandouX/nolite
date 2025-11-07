<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan {{ ucfirst($jenis) }}</title>
    <style>
        @page { margin: 50px 30px; size: A4; }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        /* Header */
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 10px;
        }
        header h2 {
            margin: 0;
            font-size: 18px;
        }
        header small {
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 120px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }

        /* Footer / signature di kanan bawah */
        footer {
            position: fixed;
            bottom: 30px;
            right: 30px;
            text-align: center;
        }
        .signature {
            margin-top: 60px;
        }
    </style>
</head>
<body>

@php
    $logoPath = public_path('assets/images/logo/logonolite.png');
    $logoBase64 = '';
    if(file_exists($logoPath)){
        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
        $logoContent = file_get_contents($logoPath);
        $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoContent);
    }
@endphp

<!-- Header -->
<header>
    @if($logoBase64)
        <img src="{{ $logoBase64 }}" alt="Logo">
    @endif
    <h2>
        Laporan {{ ucfirst($jenis) }}<br>
        <small>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</small>
    </h2>
</header>

<!-- Table -->
<table>
    <thead>
        <tr>
            @foreach(array_keys((array)($data[0] ?? [])) as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Footer / Signature -->
<footer>
    <div class="signature">
        <p>{{ config('app.name') }}</p>
        <p>Pemilik / Admin</p>
        <br><br>
        <p>_________________________</p>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
</footer>

</body>
</html>
