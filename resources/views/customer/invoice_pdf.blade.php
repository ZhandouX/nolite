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
        }

        table.items th {
            background: #f3f4f6;
            text-align: left;
        }

        .text-right {
            text-align: right;
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

        .grand-total {
            font-size: 14px;
            font-weight: bold;
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
    </style>
</head>

<body>

    <div class="header">
        <h1>Nolite Aspiciens</h1>
        <p>Invoice Pembelian</p>
    </div>

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

    <table class="items">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Produk</th>
                <th width="15%">Warna</th>
                <th width="15%">Ukuran</th>
                <th width="10%">Qty</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->warna }}</td>
                    <td>{{ $item->ukuran }}</td>
                    <td>{{ $item->qty }}</td>
                    <td class="text-right">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <table>
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="text-right">
                    Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                </td>
            </tr>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Nolite Aspiciens.</p>
        <p>Invoice ini dibuat secara otomatis oleh sistem.</p>
    </div>

</body>

</html>