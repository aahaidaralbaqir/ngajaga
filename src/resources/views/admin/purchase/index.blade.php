@extends('layout.dashboard')
@section('content')
<div class="second-nav py-8 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
              Pemesanan Stok 
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                <button class="button text-base text-black p-3 rounded border border-black relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <div class="menu top-14 left-[-1px] hidden">
                        <div class="search flex justify-between items-center border border-black rounded-sm px-2 gap-2 m-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <input type="text" placeholder="cari produk" class="p-2 focus:outline-none">
                        </div>
                    </div>
                </button>
                @if(in_array(\App\Constant\Permission::CREATE_ORDER_INVOICE, $user['permission']))
                    <a href="{{ route('purchase.create.form') }}" class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Buat Pemesanan Stok</a>
                @endif
            </div>
        </div>
        <div class="tab">
            @if(in_array(\App\Constant\Permission::VIEW_SUPPLIER, $user['permission']))
                <a href="{{ route('supplier.index') }}" aria-selected="true">Pemasok</a>
            @endif
            @if(in_array(\App\Constant\Permission::VIEW_ORDER_INVOICE, $user['permission']))
                <a href="{{ route('purchase.index') }}" aria-selected="true" class="selected">Pemesanan Stok</a>
            @endif
            @if(in_array(\App\Constant\Permission::VIEW_PURCHASE_INVOICE, $user['permission']))
                <a href="{{ route('category.index') }}" aria-selected="true">Penerimaan Stok</a>
            @endif
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
        <table class="w-full retro">
            <caption class="text-2xl text-black [text-align:unset]">Pemesanan Stok</caption>
            <thead>
                <tr>
                    <th class="w-[5%]"></th>
                    <th class="text-left">No. Pemesanan Stok</th>
                    <th class="text-left">Tanggal</th>
                    <th class="text-left">Pemasok</th>
                    <th class="text-left">Dibuat Oleh</th>
                    <th class="text-left">Status</th>
                    <th  class="w-[5%]"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase_orders as $purchase)
                    <tr>
                        <td>
                        </td>
                        <td>
                            <span>{{ $purchase->purchase_number }}</span>
                        </td>
                        <td>
                            <span>{{ $purchase->purchase_date }}</span>
                        </td>
                        <td>
                            <span>{{ $purchase->supplier_name }}</span>
                        </td> 
                        <td>
                            {{ $purchase->create_by_name }}
                        </td>
                        <td>
                            {{ $purchase->status_name }}
                        </td>
                        <td class="relative">
                            @if(in_array(\App\Constant\Permission::UPDATE_ORDER_INVOICE, $user['permission']) || in_array(\App\Constant\Permission::DELETE_ORDER_INVOICE, $user['permission']))
                                <a href="" data-id="{{ $purchase->id }}" data-name="action" class="dropdown" role="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                </a>
                                <div class="menu hidden" data-id="{{ $purchase->id }}" data-name="action" role="dropdown-content">
                                    @if(in_array(\App\Constant\Permission::UPDATE_ORDER_INVOICE, $user['permission']))
                                        <a href="" class="menu-item">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                    @endif
                                    @if(in_array(\App\Constant\Permission::DELETE_ORDER_INVOICE, $user['permission'])) 
                                        <a href="" class="menu-item">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Hapus
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @if (count($purchase_orders) <= 0)
                    <tr>
                        <td colspan="7">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="font-bold">Total {{ $total_row }}</td>
                </tr>
            </tfoot>
        </table>
    </section>
</main>
@endsection