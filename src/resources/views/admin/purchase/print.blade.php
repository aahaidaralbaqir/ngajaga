<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    Pemesanan Stok
  </title>
  <style type="text/css">
    .bg-white {
        background-color: #ffffff;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .shadow-lg {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .px-8 {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .py-10 {
        padding-top: 2.5rem;
        padding-bottom: 2.5rem;
    }

    .max-w-xl {
        max-width: 36rem;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .flex {
        display: flex;
    }

    .items-center {
        align-items: center;
    }

    .justify-between {
        justify-content: space-between;
    }

    .mb-8 {
        margin-bottom: 2rem;
    }

    .text-gray-700 {
        color: #4a5568;
    }

    .font-semibold {
        font-weight: 600;
    }

    .text-lg {
        font-size: 1.125rem;
    }

    .font-bold {
        font-weight: 700;
    }

    .text-xl {
        font-size: 1.25rem;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .border-b-2 {
        border-bottom-width: 2px;
    }

    .border-gray-300 {
        border-color: #e2e8f0;
    }

    .pb-8 {
        padding-bottom: 2rem;
    }

    .border-t-2 {
        border-top-width: 2px;
    }

    .py-2 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .w-full {
        width: 100%;
    }

    .text-left {
        text-align: left;
    }

    .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .text-2xl {
        font-size: 1.5rem;
    }

    .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .flex {
        display: flex;
    }

    .justify-end {
        justify-content: flex-end;
    }

    .mr-2 {
        margin-right: 0.5rem;
    }

    .font-bold {
        font-weight: 700;
    }

    .text-xl {
        font-size: 1.25rem;
    }

    .pt-8 {
        padding-top: 2rem;
    }

    .text-gray-700 {
        color: #4a5568;
    }
</style>
</head>
<body class="bg-[#f4f4f0]">
<div class="bg-white rounded-lg shadow-lg px-8 py-10 max-w-xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <div class="text-gray-700 font-semibold text-lg">Toko Mimin Suminar</div>
        </div>
        <div class="text-gray-700">
            <div class="font-bold text-xl mb-2">Faktur Pembelian</div>
            <div class="text-sm">Tanggal: {{ $item->purchase_date }}</div>
            <div class="text-sm">No.Pembelian #: {{ $item->purchase_number }}</div>
        </div>
    </div>
    <div class="border-b-2 border-gray-300 pb-8 mb-8">
        <h2 class="text-2xl font-bold mb-4">Penyuplai:</h2>
        <div class="text-gray-700 mb-2">{{ $item->supplier->name }}</div>
        <div class="text-gray-700 mb-2">{{ $item->supplier->phone_number }}</div>
        <div class="text-gray-700 mb-2">{{ $item->supplier->address }}</div>
        <div class="text-gray-700">{{ $item->supplier->email }}</div>
    </div>
    <table class="w-full text-left mb-8">
        <thead>
            <tr>
                <th class="text-gray-700 font-bold uppercase py-2">Nama Produk</th>
                <th class="text-gray-700 font-bold uppercase py-2">Kuantitas</th>
                <th class="text-gray-700 font-bold uppercase py-2">Harga Satuan</th>
                <th class="text-gray-700 font-bold uppercase py-2">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grand_total = 0;
            @endphp
            @foreach ($item->order_items as $order_item)
                @php
                    $grand_total += $order_item->price * $order_item->qty;
                @endphp
            <tr>
                <td class="py-4 text-gray-700">{{ $order_item->product_name }}</td>
                <td class="py-4 text-gray-700">{{ $order_item->qty }} {{ \App\Util\Common::getUnitNameById($order_item->unit) }}</td>
                <td class="py-4 text-gray-700">{{ \App\Util\Common::formatAmount('Rp', $order_item->price) }}</td>
                <td class="py-4 text-gray-700">{{ \App\Util\Common::formatAmount('Rp', $order_item->price * $order_item->qty) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end mb-8">
        <div class="text-gray-700 mr-2">Total Kesuluruhan:</div>
        <div class="text-gray-700 font-bold text-xl">{{ \App\Util\Common::formatAmount('Rp', $grand_total) }}</div>
    </div>
</div>
</body>
</html>