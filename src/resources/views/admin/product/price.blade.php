@extends('layout.dashboard')
@section('content')
{{ Form::open(['route' => $target_route, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    <div class="second-nav  {{ empty($item) ? 'py-[2.7rem]' : 'py-8' }}  px-14 w-full">
        <div class="w-5/6">
            <div class="flex justify-between items-center">
                <h1>
                    
                   {{ empty($item) ? $page_title : $item->name }}
                </h1>
                <div class="flex items-center justify-between gap-5 relative">
                    <a href="{{ route('product.edit.form', ['productId' => $item->id]) }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        Kembali
                    </a>
                    <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Simpan Perubahan</button>
                </div>
            </div>
            <div class="tab">
                <a href="{{ route('product.edit.form', ['productId' => $item->id]) }}" aria-selected="true">Informasi Produk</a>
                <a href="{{ route('product.price.form', ['productId' => $item->id]) }}" aria-selected="true"  class="selected">Konfigurasi Harga</a>
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14" id="price">
        <section class="w-5/6">
                @if(!empty($item))
                    <section class="flex gap-2 justify-between pt-10">
                        <header class="text-[#000000] font-light flex-1">
                            <h1 class="text-2xl mb-2 font-normal">Harga</h1>
                            <p class="text-black">
                                Sesuaikan harga dari setiap produk dengan 
                                <br>
                                kebutuhan kamu

                                <br>
                                <br>

                                Konfigurasi ini membantu kamu ketika bertransaksi dengan kuantitas pembelian yang dinamis,  harga dan satuan diurutkan berdasarkan satuan terkecil
                            </p>
                        </header>
                        <fieldset class="w-3/5">
                            <legend class="mb-2">
                                <label class="text-[#000000] font-light">Konfigurasi Harga</label>
                            </legend>
                            <label class="switch">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <input 
                                    type="checkbox"
                                    name="use_price_mapping"
                                    @if ($item->use_price_mapping == \App\Constant\Constant::OPTION_ENABLE)
                                        checked
                                    @endif
                                />
                                <span class="slider round"></span>
                            </label>
                            <label for="use_price_mapping" class="text-[#000] font-light ml-1">Jika ini dinyalakan maka harga jual akan mengikuti konfigurasi di bawah ini</label>
                            <div class="price-mapping-box box mt-4 relative {{ $item->use_price_mapping == \App\Constant\Constant::OPTION_ENABLE ? '' : 'hidden' }}">
                                <table class="w-full retro">
                                    <thead>
                                        <tr>
                                            <th class="w-[2%] text-left">Satuan</th>
                                            <th class="w-[3%]">Kuantitas</th>
                                            <th class="text-left w-[3%]">Konversi</th>
                                            <th class="text-left w-[30%]">Harga</th>
                                            <th class="w-[5%]"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-mapping">
                                        @if (is_array(old('qty')))
                                            @foreach(old('qty') as $index => $value)
                                                @if ($index == count(old('unit')) - 1)
                                                    @continue
                                                @endif
                                                @php
                                                    $custom_quantity_style = '';
                                                    $custom_conversion_style = '';
                                                    $custom_price_style = '';
                                                    if ($errors->has($index.'.qty')) {
                                                        $custom_quantity_style = 'border: 1px solid red;';
                                                    }

                                                    if ($errors->has($index.'.conversion')) {
                                                        $custom_conversion_style = 'border: 1px solid red;';
                                                    }

                                                    if ($errors->has($index.'.price')) {
                                                        $custom_price_style = 'border: 1px solid red;';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <select class="w-40" name="unit[]">
                                                            @foreach ($units as $unit_id => $unit_name)
                                                                <option 
                                                                    value="{{ $unit_id }}"
                                                                    @if ($value == $unit_id)
                                                                        checked
                                                                    @endif
                                                                >
                                                                    {{ $unit_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" style="<?php echo $custom_quantity_style; ?>" name="qty[]" value="{{ old('qty')[$index] }}" />
                                                    </td>
                                                    <td>
                                                        <input type="number" name="conversion[]" value="{{ old('conversion')[$index] }}" style="<?php echo $custom_conversion_style; ?>"  />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="price[]" value="{{ old('price')[$index] }}" style="<?php echo $custom_price_style; ?>">
                                                    </td>
                                                    <td>
                                                        <a href="" class="text-base text-black p-3 rounded border border-black relative flex gap-2 delete-row">Hapus</a>
                                                    </td>
                                                </tr> 
                                            @endforeach
                                        @else
                                            @foreach ($price_mapping as $item)
                                            <tr>
                                                    <td>
                                                        <select class="w-40" name="unit[]">
                                                            @foreach ($units as $unit_id => $unit_name)
                                                                <option 
                                                                    value="{{ $unit_id }}"
                                                                    @if ($item->unit == $unit_id)
                                                                        checked
                                                                    @endif
                                                                >
                                                                    {{ $unit_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="qty[]" value="{{ old('qty', $item->qty) }}" />
                                                    </td>
                                                    <td>
                                                        <input type="number" name="conversion[]" value="{{ old('conversion', $item->conversion) }}" />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="price[]" value="{{ old('price', $item->price) }}" />
                                                    </td>
                                                    <td>
                                                        <a href="" class="text-base text-black p-3 rounded border border-black relative flex gap-2 delete-row">Hapus</a>
                                                    </td>
                                                </tr>    
                                            @endforeach
                                        @endif
                                        <tr class="hidden sample-row">
                                            <td>
                                                <select class="w-40" name="unit[]">
                                                    @foreach ($units as $unit_id => $unit_name)
                                                        <option value="{{ $unit_id }}">{{ $unit_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]"/>
                                            </td>
                                            <td>
                                                <input type="number" name="conversion[]" />
                                            </td>
                                            <td>
                                                <input type="text" name="price[]">
                                            </td>
                                            <td>
                                                <a href="" class="text-base text-black p-3 rounded border border-black relative flex gap-2 delete-row">Hapus</a>
                                            </td>
                                        </tr>
                                        <tr class="nodata-row {{ empty(old('qty')) && empty($price_mapping) ? '' : 'hidden' }}">
                                                <td colspan="5">
                                                    Tidak ada konfigurasi
                                                </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a id="add-row" class="mt-2 text-base text-black p-3 rounded border border-black relative flex gap-2 justify-center items-center">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-plus"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                    Tambah
                                </a>
                            </div>
                        </fieldset>
                    </section>
                @endif
        </section>
    </main>
{{ Form::close() }}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.7.16"></script>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function () {
        const togglePriceMapping = document.querySelector('input[name="use_price_mapping"]')
        if (togglePriceMapping) {
            const priceMappingBox = document.querySelector('.price-mapping-box')
            togglePriceMapping.addEventListener('change', function (event) {
                priceMappingBox.classList.toggle('hidden')
            })
        }
        

        const addRowBtn = document.getElementById('add-row')
        const noData = document.querySelector('.nodata-row')
        const sampleRow = document.querySelector('.sample-row')
        const priceMapping = document.getElementById('price-mapping')

        if (addRowBtn) {
            addRowBtn.addEventListener('click', function (event) {
                noData.classList.add('hidden')
                const row = sampleRow.cloneNode(true)
                row.classList.remove('hidden')
                row.classList.remove('sample-row')
                row.classList.add('pr-item')
                priceMapping.appendChild(row)
                resyncEventHandler()
            })

            function resyncEventHandler() {
                const deleteRowsBtn = document.querySelectorAll('.delete-row')
                deleteRowsBtn.forEach(function (item) {
                    item.addEventListener('click', function (event) {
                        event.preventDefault();
                        const sd = item.parentElement.parentElement
                        sd.remove()
                        const priceMapping = document.getElementById('price-mapping')
                        const tr = priceMapping.childNodes
                        let trLength = 0;
                        for (let i = 0; i < tr.length; i++) {
                            if (tr[i].nodeName == 'TR') {
                                trLength++
                            }
                        }
                        if (trLength <= 2) {
                            noData.classList.remove('hidden')
                        }
                    })
                })
            }
        }
  
        resyncEventHandler();

    })
</script>
@endpush