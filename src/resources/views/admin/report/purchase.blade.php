@extends('layout.dashboard')
@section('content')
<div class="second-nav py-8 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
                Laporan
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                
                <a href="{{ route('product.report.download') }}" class="button text-base text-black p-3 rounded border border-black relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-to-line"><path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/></svg>
                </a>
                @if ($has_filter)
                    <a href="{{ route('product.report') }}" class="button text-base text-black p-3 rounded border border-black relative">
                        Hapus Filter
                    </a>
                @endif
                <button class="button text-base text-black p-3 rounded border border-black relative" role="dropdown" data-id="89" data-name="action">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-filter"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
                </button>
                <div class="menu top-14 right-1 mt-2 hidden" id="cmenu" data-id="89" data-name="action" role="dropdown-content">
                    <form action="{{ route('product.report') }}" method="GET">
                        <div class="flex gap-5 border-b p-4">
                            <fieldset>
                                <label for="start" class="text-black">Dari Tanggal</label>
                                <div class="flex gap-4 mt-2">
                                    <input type="date" name="transaction_start" id="" value="{{ request('transaction_start') }}">
                                    <input type="date" name="transaction_end" id="" value="{{ request('transaction_end') }}">
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
            <caption class="text-2xl text-black [text-align:unset]">Aktifitas </caption>
            <thead>
                <tr>
                    <th class="w-[5%]"></th>
                    <th class="text-left">Nama Produk</th>
                    <th class="text-left">Stok Masuk</th>
                    <th class="text-left">Stok Keluar</th>
                    <th class="text-left">Stok Saat Ini</th>
                    <th  class="w-[5%]"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock_in }}</td>
                        <td>{{ $product->stock_out * -1 }}</td>
                        <td>{{ $product->stock_in - $product->stock_out * -1 }}</td>
                        <td>
                            <div class="relative">
                                <a href="" data-id="{{ $product->product_id }}" data-name="action"  class="dropdown" role="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                </a>
                                <div class="menu hidden w-[250px] left-[-12px]" data-id="{{ $product->product_id }}" data-name="action" role="dropdown-content">
                                    <a href="" class="menu-item">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-view"><path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z"/><path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/><path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2"/><path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2"/></svg>
                                        Lihat Keluar Masuk Barang
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if (count ($products) <= 0)
                    <tr>
                        <td colspan="6">Tidak ada data</td>
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