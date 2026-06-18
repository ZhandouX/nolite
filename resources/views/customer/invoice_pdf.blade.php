<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            color: #7f1d1d;
        }

        .invoice-info {
            margin-bottom: 20px;
        }

        .invoice-info table {
            width: 100%;
        }

        .invoice-info td {
            padding: 4px 0;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.items th,
        table.items td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        table.items th {
            background: #f3f4f6;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .product-box {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .img-main {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .thumbs {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .thumb {
            width: 20px;
            height: 20px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .product-name {
            font-weight: bold;
        }

        .product-meta {
            font-size: 10px;
            color: #666;
        }

        .total-box {
            margin-top: 20px;
            width: 100%;
        }

        .total-box table {
            width: 300px;
            margin-left: auto;
        }

        .total-box td {
            padding: 5px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
            font-size: 11px;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 10px auto;
            display: block;
            border: 2px solid #7f1d1d;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('assets/images/logo/logonolite.png') }}" class="logo">
        <h1>Nolite Aspiciens</h1>
        <p>Invoice Pembelian</p>
    </div>

    {{-- INFO --}}
    <div class="invoice-info">
        <table>
            <tr>
                <td><strong>No. Invoice</strong></td>
                <td>: #{{ $order->midtrans_order_id ?? $order->id }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: {{ $order->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Nama Penerima</strong></td>
                <td>: {{ $order->nama_penerima }}</td>
            </tr>
            <tr>
                <td><strong>Metode Pembayaran</strong></td>
                <td>: {{ $order->metode_pembayaran }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>: <span class="status">{{ $order->status }}</span></td>
            </tr>
        </table>
    </div>

    {{-- ITEMS --}}
    <table class="items">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Produk</th>
                <th width="15%">Warna</th>
                <th width="15%">Ukuran</th>
                <th width="10%">Jumlah</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    {{-- PRODUCT --}}
                    <td>
                        <div class="product-box">

                            @php
                                $fotos = $item->produk?->fotos ?? collect();
                                $main = $fotos->first();
                            @endphp

                            {{-- MAIN IMAGE --}}
                            @if ($main)
                                <img src="{{ public_path('storage/' . $main->foto) }}" class="img-main">
                            @else
                                <img src="{{ public_path('assets/images/no-image.png') }}" class="img-main">
                            @endif

                            {{-- THUMBNAILS --}}
                            <div class="thumbs">
                                @foreach ($fotos->take(5) as $foto)
                                    <img src="{{ public_path('storage/' . $foto->foto) }}" class="thumb">
                                @endforeach
                            </div>

                            {{-- TEXT --}}
                            <div>
                                <div class="product-name">
                                    {{ $item->nama_produk }}
                                </div>

                                <div class="product-meta">
                                    Warna: {{ $item->warna }}<br>
                                    Ukuran: {{ $item->ukuran }}
                                </div>
                            </div>

                        </div>
                    </td>

                    <td>{{ $item->warna }}</td>
                    <td>{{ $item->ukuran }}</td>
                    <td>{{ $item->jumlah ?? $item->qty }}</td>

                    <td class="text-right">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="total-box">
        <table>
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="text-right">
                    Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>Terima kasih telah berbelanja di Nolite Aspiciens.</p>
        <p>Invoice ini dibuat secara otomatis oleh sistem.</p>
    </div>

</body>
</html>
