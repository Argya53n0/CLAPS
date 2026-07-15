<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->order_code }}</title>
    <style>
        @page {
            margin: 0;
            size: 80mm 297mm;
        }
        body {
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background: #fff;
            padding: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .border-top { border-top: 1px dashed #000; padding-top: 5px; margin-top: 5px; }
        .border-bottom { border-bottom: 1px dashed #000; padding-bottom: 5px; margin-bottom: 5px; }
        .flex { display: flex; justify-content: space-between; }
        .mb-2 { margin-bottom: 8px; }
        
        .receipt-header h1 {
            font-size: 16px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .receipt-header p {
            margin: 0 0 3px 0;
            font-size: 10px;
        }
        
        .item-row {
            margin-bottom: 5px;
        }
        .item-name {
            font-weight: bold;
        }
        .item-options {
            font-size: 10px;
            margin-left: 10px;
            line-height: 1.2;
        }
        .item-price {
            display: flex;
            justify-content: space-between;
        }
        
        @media print {
            body { margin: 0; padding: 0; }
            #print-button { display: none; }
        }
        
        #print-button {
            margin: 10px auto;
            display: block;
            padding: 10px 20px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: sans-serif;
            font-weight: bold;
        }
    </style>
</head>
<body onload="window.print()">
    
    <button id="print-button" onclick="window.print()">Print Sekarang</button>
    
    <div style="max-width: 80mm; margin: 0 auto; padding-right: 5mm;">
        <div class="receipt-header text-center border-bottom">
            <h1>CLAPS COFFEE</h1>
            <p>Delivery Order Ticket</p>
            <p>{{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
        
        <div class="border-bottom">
            <div class="flex">
                <span>No. Order:</span>
                <span class="font-bold">#{{ $order->order_code }}</span>
            </div>
            <div class="flex">
                <span>Customer:</span>
                <span class="font-bold">{{ substr($order->user->name ?? 'Guest', 0, 15) }}</span>
            </div>
            <div class="flex">
                <span>Payment:</span>
                <span>{{ strtoupper($order->payment_method) }} ({{ $order->payment_status === 'paid' ? 'PAID' : 'UNPAID' }})</span>
            </div>
        </div>
        
        <div class="items">
            @foreach($order->items as $item)
                <div class="item-row">
                    <div class="item-name">{{ $item->quantity }}x {{ $item->product->name ?? 'Item' }}</div>
                    @if($item->options && is_array($item->options) && count($item->options) > 0)
                        <div class="item-options">
                            @foreach($item->options as $key => $val)
                                - {{ $key }}: {{ $val }}<br>
                            @endforeach
                        </div>
                    @endif
                    <div class="item-price">
                        <span>@ {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="border-top border-bottom">
            <div class="flex">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
            </div>
            <div class="flex">
                <span>Ongkir:</span>
                <span>Rp {{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex font-bold" style="font-size: 14px; margin-top: 5px;">
                <span>TOTAL:</span>
                <span>{{ $order->formatted_grand_total }}</span>
            </div>
        </div>
        
        <div class="receipt-header" style="margin-top: 10px;">
            <span class="font-bold">Alamat Pengiriman:</span>
            <p style="font-size: 12px; margin-top: 2px;">{{ $order->delivery_address ?: '-' }}</p>
        </div>
        
        @if($order->notes)
            <div class="receipt-header border-top" style="margin-top: 10px;">
                <span class="font-bold">Catatan:</span>
                <p style="font-size: 12px; margin-top: 2px;">{{ $order->notes }}</p>
            </div>
        @endif
        
        <div class="text-center" style="margin-top: 20px; font-size: 10px;">
            -- Terima Kasih --<br>
            Tunggu kedatangan kurir kami!
        </div>
    </div>
</body>
</html>
