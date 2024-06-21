@extends('layout.dashboard')
@section('content')
<div class="second-nav py-8 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
              Penerimaan Stok 
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
                @if(in_array(\App\Constant\Permission::CREATE_PURCHASE_INVOICE, $user['permission']))
                    <a href="{{ route('invoice.create.form') }}" class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Buat Penerimaan Stok</a>
                @endif
            </div>
        </div>
        <div class="tab">
            @if(in_array(\App\Constant\Permission::VIEW_SUPPLIER, $user['permission']))
                <a href="{{ route('supplier.index') }}" aria-selected="true">Pemasok</a>
            @endif
            @if(in_array(\App\Constant\Permission::VIEW_ORDER_INVOICE, $user['permission']))
                <a href="{{ route('purchase.index') }}" aria-selected="true">Pemesanan Stok</a>
            @endif
            @if(in_array(\App\Constant\Permission::VIEW_PURCHASE_INVOICE, $user['permission']))
                <a href="{{ route('category.index') }}" aria-selected="true" class="selected">Penerimaan Stok</a>
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
                    <th class="text-left">No. Pemenesanan stok</th>
                    <th class="text-left">No. Penerimaan stok</th>
                    <th class="text-left">Tanggal penerimaan</th>
                    <th class="text-left">Akun yang digunakan</th>
                    <th class="text-left">Total Pembayaran</th>
                    <th  class="w-[5%]"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>
                        </td>
                        <td>
                            <span class="font-bold">{{ $invoice->purchase_number }}</span>
                        </td>
                        <td>
                            <span class="font-bold">
                                {{ $invoice->invoice_code }}
                            </span>
                        </td>
                        <td>
                            <span>{{ $invoice->received_date }}</span>
                        </td>
                      
                        <td>
                            {{ $invoice->account_name }}
                        </td>
                        <td>
                            <span>{{ \App\Util\Common::formatAmount('Rp', $invoice->payment_total) }}</span>
                        </td>
                        <td class="relative">
                            @if(in_array(\App\Constant\Permission::UPDATE_ORDER_INVOICE, $user['permission']) || in_array(\App\Constant\Permission::DELETE_ORDER_INVOICE, $user['permission']))
                                <a href="" data-id="{{ $invoice->id }}" data-name="action" class="dropdown" role="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                </a>
                                <div class="menu hidden w-[200px] ml-[-10px]" data-id="{{ $invoice->id }}" data-name="action" role="dropdown-content">
                                    @if(in_array(\App\Constant\Permission::UPDATE_ORDER_INVOICE, $user['permission']))
                                        <a href="{{ route('invoice.edit.form', ['invoiceId' => $invoice->id]) }}" class="menu-item">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @if (count($invoices) <= 0)
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