@extends('layout.dashboard')
@section('content')
<div class="second-nav py-8 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
                Laporan
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                <a href="{{ route('product.activity.download', ['productId' => $item->id]) }}" class="button text-base text-black p-3 rounded border border-black relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-to-line"><path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/></svg>
                </a>
                @if ($has_filter)
                    <a href="{{ route('product.activity.report', ['productId' => $item->id]) }}" class="button text-base text-black p-3 rounded border border-black relative">
                        Hapus Filter
                    </a>
                @endif
                <button class="button text-base text-black p-3 rounded border border-black relative" role="dropdown" data-id="89" data-name="action">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-filter"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
                </button>
                <div class="menu top-14 right-1 mt-2 hidden" id="cmenu" data-id="89" data-name="action" role="dropdown-content">
                    <form action="{{ route('product.activity.report', ['productId' => $item->id]) }}" method="GET">
                        <div class="flex gap-5 border-b p-4">
                            <fieldset>
                                <label for="start" class="text-black">Dari Tanggal</label>
                                <div class="flex gap-4 mt-2">
                                    <input type="date" name="start_date" id="" value="{{ request('start_date') }}">
                                    <input type="date" name="end_date" id="" value="{{ request('end_date') }}">
                                </div>
                            </fieldset>
                        </div>
                        <div class="mt-4 flex gap-5 p-4">
                            <button type="submit" class="w-full button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Filter</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab">
            <a href="{{ route('permission.index') }}" aria-selected="true" class="selected">Stok Produk</a>
            <a href="{{ route('roles.index') }}" aria-selected="true">Pembelian Stok</a>
            <a href="{{ route('user.index') }}" aria-selected="true">Akun</a>
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
        <table class="w-full retro">
            <caption class="text-2xl text-black [text-align:unset]">Aktifitas stok pada produk <b>{{ $item->name }}</b></caption>
            <thead>
                <tr>
                    <th class="w-[5%]"></th>
                    <th class="text-left">Deskripsi</th>
                    <th class="text-left">Referensi</th>
                    <th class="text-left">Waktu Kejadian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td></td>
                        <td>
                            @php
                                $description = 'Pembelian barang pada invoice dengan kode ' . $product->invoice_code . ' sebanyak ' . $product->qty;
                                if ($product->qty <= 0)
                                    $description = 'Penjualan pada transaksi dengna order id ' . $product->order_id . ' sebanyak ' . $product->qty * -1;
                                echo $description;
                            @endphp
                        </td>
                        <td>
                            @php
                                $target_route = '';
                                if (empty($product->transaction_id)) {
                                    $target_route = route('invoice.edit.form', ['invoiceId' => $product->purchase_invoice_id]);
                                } else {
                                    $target_route = route('transaction.edit.form', ['transactionId' => $product->transaction_id]);
                                }
                            @endphp
                            <a href="{{ $target_route }}">
                                {{ empty($product->transaction_id) ? $product->invoice_code : $product->order_id }}
                            </a>
                        </td>
                        <td>
                            {{ date('Y-m-d', empty($invoice_code) ? $product->transaction_date: $product->received_date) }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
                @if (count ($products) <= 0)
                    <tr>
                        <td colspan="5">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if ($products->total() > 0)
            {{ $products->appends(request()->except('page'))->links() }}
        @endif
    </section>
</main>
@endsection
@push('styles')
    <style type="text/css">
        #cmenu::after {	
            content: "";
            border-left: solid .5rem rgba(0, 0, 0, 0);
            border-right: solid .5rem rgba(0, 0, 0, 0);
            border-bottom: solid .5rem black;
            position: absolute;
            top: -9px;
            left: 96%;
            transform: translate(-50%, 0);
            z-index: 30;
        }
    </style>
@endpush