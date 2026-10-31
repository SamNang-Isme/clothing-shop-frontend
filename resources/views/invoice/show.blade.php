<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Invoice {{ $order->invoice_no }}</title>
<style>
    * { box-sizing: border-box; }
    body { font-family: Arial, Helvetica, sans-serif; color: #222; background: #f4f4f4; margin: 0; padding: 24px; }
    .invoice { max-width: 800px; margin: 0 auto; background: #fff; padding: 40px; border: 1px solid #ddd; }
    .head { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; border-bottom: 2px solid #222; padding-bottom: 16px; }
    h1 { margin: 0; font-size: 28px; letter-spacing: 2px; }
    .meta { text-align: right; font-size: 14px; line-height: 1.6; }
    .bill { margin: 24px 0; font-size: 14px; line-height: 1.6; }
    .bill strong { display: block; margin-bottom: 4px; text-transform: uppercase; font-size: 12px; color: #777; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { padding: 10px 8px; border-bottom: 1px solid #e5e5e5; text-align: left; }
    th { background: #f7f7f7; text-transform: uppercase; font-size: 12px; }
    .r { text-align: right; }
    .total td { font-weight: bold; font-size: 16px; border-top: 2px solid #222; border-bottom: none; }
    .foot { margin-top: 32px; font-size: 13px; color: #666; text-align: center; }
    .actions { max-width: 800px; margin: 0 auto 16px; display: flex; gap: 8px; }
    .actions a, .actions button { background: #222; color: #fff; border: 0; padding: 10px 16px; text-decoration: none; font-size: 14px; cursor: pointer; }
    .actions a.alt { background: #777; }
    @media print { body { background: #fff; padding: 0; } .invoice { border: 0; } .actions { display: none; } }
</style>
</head>
<body>
@unless ($download)
    <div class="actions">
        <button onclick="window.print()">Print</button>
        <a href="{{ route('invoice.download', $order->invoice_no) }}">Download .html</a>
        <a class="alt" href="{{ route('home') }}">Back to shop</a>
    </div>
@endunless

<div class="invoice">
    <div class="head">
        <div>
            <h1>INVOICE</h1>
            <div>{{ config('app.name') }}</div>
        </div>
        <div class="meta">
            <div><strong>Invoice #:</strong> {{ $order->invoice_no }}</div>
            <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</div>
            <div><strong>Status:</strong> {{ $order->status }}</div>
        </div>
    </div>

    <div class="bill">
        <strong>Billed to</strong>
        {{ $order->customer_name }}<br>
        {{ $order->phone }}@if ($order->email) &middot; {{ $order->email }}@endif<br>
        {!! nl2br(e($order->address)) !!}
        @if ($order->note)
            <br><em>Note: {{ $order->note }}</em>
        @endif
    </div>

    <table>
        <thead>
            <tr><th>#</th><th>Product</th><th class="r">Price</th><th class="r">Qty</th><th class="r">Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach ($items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->proname }}</td>
                    <td class="r">${{ number_format($item->price, 2) }}</td>
                    <td class="r">{{ $item->qty }}</td>
                    <td class="r">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="4" class="r">Total</td>
                <td class="r">${{ number_format($order->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="foot">Payment: cash on delivery. Thank you for shopping with us!</div>
</div>
</body>
</html>
