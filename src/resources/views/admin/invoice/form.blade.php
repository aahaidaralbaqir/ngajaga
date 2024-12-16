@extends('layout.dashboard')
@section('content')
{{ Form::open(['route' => $target_route, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="second-nav py-[2.7rem] px-14 w-full">
    <div class="w-11/12">
        <div class="flex justify-between items-center">
            <h1>
                {{ $page_title }}
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                <a href="{{ route('invoice.index') }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    Kembali
                </a>
                <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black" :disabled="is_loading" @click.prevent="handleSubmit">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-11/12">
            <section class="flex gap-2 justify-between pb-15">
                <header class="text-[#000000] font-light flex-1">
                    <h1 class="text-2xl mb-2 font-lighter">Informasi Penerimaan Stok</h1>
                    <p>Detailkan penerimaan produk yang akan kamu terima, pilih tanggal penerimaan dan akun yang akan digunakan dalam pembayaran.</p>
                    <br>
                    <p>Pastikan saldo dari akunmu sesuai dengan jumlah pembelian produk yang dilakukan</p>
                </header>
                <fieldset class="w-3/5">
                    @if (!empty($purchase_order))
                        <input type="hidden" name="purchase_order_id" value="{{ $purchase_order->id }}">
                    @endif
                    @if (!empty($item))
                        <input type="hidden" name="id" value="{{ $item->id }}">
                    @endif
                    @if (empty($item))
                    <div class="mb-4">
                        <legend class="mb-2">
                            <label for="supplier_id" class="text-[#000000] font-light">No.Faktur Pembelian <span class="text-danger">*</span></label>
                        </legend>
                        <select name="purchase_number" id="purchase_number" class="mb-2">
                            <option  value="0">Pilih No.Faktur Pembelian</option>
                            @foreach ($purchase_orders as $order)
                                <option 
                                    value="{{ $order->purchase_number }}"
                                    @if (!empty($purchase_order) && $order->id == $purchase_order->id)
                                        selected="selected"
                                    @endif
                                >
                                    {{ $order->purchase_number }}
                                </option>
                            @endforeach
                        </select>

                        @error('purchase_number')
                        <span class="text-sm text-danger" >
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    @else
                        <div class="mb-4">
                            <legend class="mb-2">
                                <label for="purchase_number" class="text-[#000000] font-light">No.Faktur Pembelian<span class="text-danger">*</span></label>
                            </legend>
                            <input type="text" name="purchase_number" class="mb-2 input border rounded-sm px-4 py-2 w-full" readonly value="{{ empty($item) ? $invoice_code : $item->purchase_number }}" />
                            @error('purchase_number')
                                <span 
                                    class="text-sm text-danger"
                                    v-for="(error) in getErrors('purchase_number')"
                                >
                                    {{ $message }}
                                </span>
                            @enderror
                        </div> 
                    @endif
                    <div class="mb-4">
                        <legend class="mb-2">
                            <label for="invoice_code" class="text-[#000000] font-light">No.Invoice <span class="text-danger">*</span></label>
                        </legend>
                        <input type="text" name="invoice_code" class="mb-2 input border rounded-sm px-4 py-2 w-full" readonly value="{{ empty($item) ? $invoice_code : $item->invoice_code }}" />
                        @error('invoice_code')
                            <span 
                                class="text-sm text-danger"
                                v-for="(error) in getErrors('purchase_number')"
                            >
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <legend class="mb-2">
                            <label for="supplier_id" class="text-[#000000] font-light">Sumber Akun <span class="text-danger">*</span></label>
                        </legend>
                        <select name="account_id" id="account_id" class="mb-2">
                            <option  value="0">Pilih akun</option>
                            @foreach ($accounts as $account)
                                <option 
                                    value="{{ $account->id }}"
                                    @if (old('account_id', empty($item) ? 0 : $item->account_id) == $account->id)
                                        selected="selected"
                                    @endif
                                >
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('account_id')
                        <span class="text-sm text-danger" >
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <legend class="mb-2">
                            <label for="received_date" class="text-[#000000] font-light">Tanggal Penerimaan Stok <span class="text-danger">*</span></label>
                        </legend>
                        <input type="date" name="received_date" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ empty($item) ? '' : $item->received_date }}" />
                        @error('received_date')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="description" class="text-[#000000] font-normal">Deskripsi</label>
                        <textarea name="description" id="description">{{ empty($item) ? '' : $item->description }}</textarea> 
                    </div>
                </fieldset>
            </section>

            @if ($purchase_order)
                <section class="flex gap-2 justify-between pt-15 items-start border-t">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-lighter">Stok dan Produk</h1>
                        <p>Detailkan produk yang kamu terima mulai dari jumlah produk sampai dengan harga beli yang diberikan oleh pemasok</p>
                    </header>
                    <fieldset class="w-3/5 flex flex-col">
                            <div class="box-w">
                                @foreach($purchase_order->items as $order_item)
                                
                                <div class="box border-[#000000] boxitem" role="listitem">
                                    <input type="hidden" name="purchase_order_item_id[]" value="{{ $order_item->id }}">
                                    <input type="hidden" name="product_id[]" value="{{ $order_item->product_id }}">
                                    <input type="hidden" name="unit[]" value="{{ $order_item->unit }}">
                                    <div class="flex justify-between">
                                        <div class="flex items-center gap-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                            <div class="text-black">
                                                <h4 class="text-base font-normal capitalize">{{ $order_item->product_name }}</h4>
                                                <ul class="inline p-0 list-none text-base font-normal">
                                                    <li>{{ $order_item->qty }}</li>
                                                    <li>{{ $order_item->unit_name }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="actions flex gap-2">
                                            
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-4 box-b mt-4">
                                        <fieldset class="w-full">
                                            <label for="qty" class="text-[#000000] font-normal">Kuantitas</label>
                                            <input type="number" name="qty" class="mb-2" value="{{ $order_item->qty }}" disabled>
                                        </fieldset>

                                        <fieldset class="w-full">
                                            <label for="price" class="text-[#000000] font-normal">Harga beli satuan</label>
                                            <input type="number" name="price" class="mb-2" value="{{ $order_item->price }}" disabled> 
                                        </fieldset>

                                        <fieldset class="w-full">
                                            <label for="qty" class="text-[#000000] font-normal">Kuantitas yang diterima</label>
                                            <input type="number" name="received_qty[]" class="mb-2" value="{{ $order_item->received_qty }}">
                                        </fieldset>

                                        <fieldset class="w-full">
                                            <label for="price" class="text-[#000000] font-normal">Harga beli satuan yang diterima</label>
                                            <input type="number" name="received_price[]" class="mb-2" value="{{ $order_item->received_price }}"> 
                                        </fieldset> 

                                        <fieldset class="w-full">
                                            <label for="notes" class="text-[#000000] font-normal">Catatan</label>
                                            <textarea name="notes" id="notes">{{ $order_item->notes }}</textarea> 
                                        </fieldset>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                    </fieldset>
                </section>
            @endif
    </section>
</main>
{{ Form::close() }}
@endsection
@push('scripts')
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function () {
        const purchaseNumber = document.getElementById('purchase_number')
        if (purchaseNumber) {
            purchaseNumber.addEventListener('change', function (event) {
                const value = event.target.value
                window.location = '{{ route("invoice.create.form") }}?purchaseNumber=' + value
            })
        }
    })
</script>
@endpush