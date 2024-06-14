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
                    <a href="{{ route('account.index') }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        Kembali
                    </a>
                    <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14" id="purchase">
        <section class="w-11/12">
                <section class="flex gap-2 justify-between border-b pb-15">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-lighter">Informasi Pembelian Stok</h1>
                    </header>
                    <fieldset class="w-3/5">
                        <div class="mb-4">
                            <legend class="mb-2">
                                <label for="purchase_number" class="text-[#000000] font-light">Nomor Pemesanan Stok <span class="text-danger">*</span></label>
                            </legend>
                            <input type="text" name="purchase_number" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ empty($item) ? ''  : $item->purchase_number }}" />
                            @error('purchase_number')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <legend class="mb-2">
                                <label for="supplier_id" class="text-[#000000] font-light">Pemasok <span class="text-danger">*</span></label>
                            </legend>
                            <select name="supplier_id" id="supplier_id" class="mb-2">
                                <option  selected readonly>Pilih Pemasok</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" data-address="{{ $supplier->address }}" data-telephone="{{ $supplier->phone_number }}" data-email="{{ $supplier->email }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mb-4 hidden w-3/4" id="supplier-information">
                            <table class="w-full">
                                <tr>
                                    <td>
                                        <p class="text-[#000000] font-light text-md">Alamat</p> 
                                    </td>
                                    <td>
                                        <p class="text-[#000000] font-light text-md" id="supplier-address"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-[#000000] font-light text-md">No.Ponsel</p> 
                                    </td>
                                    <td>
                                        <p class="text-[#000000] font-light text-md" id="supplier-telephone"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-[#000000] font-light text-md">Email</p> 
                                    </td>
                                    <td>
                                        <p class="text-[#000000] font-light text-md" id="supplier-email"></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <legend class="mb-2">
                                <label for="purchase_date" class="text-[#000000] font-light">Tanggal Pemesanan Stok <span class="text-danger">*</span></label>
                            </legend>
                            <input type="date" name="purchase_date" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ empty($item) ? ''  : $item->name }}" />
                            @error('purchase_date')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>
                </section>

                <section class="flex gap-2 justify-between pt-15 items-start">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-lighter">Stok dan Produk</h1>
                    </header>
                    <fieldset class="w-3/5 flex flex-col">
                        <div class="box-w">
                            
                        </div>
                        <div class="box border-[#000000] boxitem hidden sample-product" role="listitem">
                            <div class="flex justify-between">
                                <div class="flex items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                    <div class="text-black">
                                        <h4 class="text-base font-normal">Tidak Ada Nama Produk</h4>
                                        <ul class="inline p-0 list-none text-base font-normal">
                                            <li>Kuantitas</li>
                                            <li>Satuan</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="actions flex gap-2">
                                    <button class="button text-base text-black p-3 rounded border border-black relative flex gap-2" role="delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                    <button class="hidden button text-base text-black p-3 rounded border border-black relative flex gap-2" role="collapse" aria-state="up">
                                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-4 box-b mt-4">
                                <fieldset class="w-full">
                                    <label for="product_id" class="text-[#000000] font-normal">Produk</label>
                                    <select name="product_id" id="product_id">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>

                                <fieldset class="w-full">
                                    <label for="unit_id" class="text-[#000000] font-normal">Satuan</label>
                                    <select name="unit_id" id="unit_id">
                                    <option disabled selected>Pilih Satuan</option> 
                                    </select>
                                </fieldset>

                                <fieldset class="w-full">
                                    <label for="qty" class="text-[#000000] font-normal">Kuantitas</label>
                                    <input type="number" name="qty">  
                                </fieldset>

                                <fieldset class="w-full">
                                    <label for="price" class="text-[#000000] font-normal">Harga Beli</label>
                                    <input type="number" name="price"> 
                                </fieldset>

                                <fieldset class="w-full">
                                    <label for="notes" class="text-[#000000] font-normal">Catatan</label>
                                    <textarea name="notes" id="notes"></textarea> 
                                </fieldset>
                            </div>
                        </div>
                        <div class="{{ empty($item) ? 'border border-dashed bg-[#ffffff] p-8 mt-8' : '' }}">
                            <button id="btn-add-product" class="w-full mx-auto flex gap-2 items-center justify-center button text-base bg-black hover:bg-[#ff91e7] text-white hover:text-black p-3 rounded border border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                Tambah Produk
                            </button>
                        </div>
                    </fieldset>
                </section>
        </section>
    </main>
{{ Form::close() }}
@endsection
@push('scripts')
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function () {

        function getOrderItemTotal() {
            const s = document.querySelectorAll('[role="listitem"]')
            return s.length
        }
        const btnaddproduct = document.getElementById('btn-add-product')
        const wrapper = document.querySelector('.box-w')
        btnaddproduct.addEventListener('click', function(event) {
            event.preventDefault()
            const classes = ['border', 'border-dashed', 'bg-[#ffffff]', 'p-8']
            classes.forEach(function (className) {
                btnaddproduct.parentNode.classList.remove(className)
            })
            const samplepurchaseorderitem = document.querySelector('.sample-product')
            const newpurchaseorder = samplepurchaseorderitem.cloneNode(true)
            newpurchaseorder.classList.remove('sample-product')
            newpurchaseorder.classList.remove('hidden')
            wrapper.append(newpurchaseorder)

            const deleterowbtn = document.querySelectorAll('[role="delete"]')
            deleterowbtn.forEach(function (row) {
                row.addEventListener('click', function (event) {
                    event.preventDefault();
                    const parentpurchaseorder = row.parentNode.parentElement.parentElement
                    parentpurchaseorder.remove()
                    if (getOrderItemTotal() <= 1) {
                        const classes = ['border', 'border-dashed', 'bg-[#ffffff]', 'p-8']
                        classes.forEach(function (className) {
                            btnaddproduct.parentNode.classList.add(className)
                        }) 
                    }
                })
            })
        })

    })
</script>
@endpush