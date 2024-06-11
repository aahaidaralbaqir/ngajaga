@extends('layout.dashboard')
@section('content')
{{ Form::open(['route' => $target_route, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    <div class="second-nav  {{ empty($item) ? 'py-[2.7rem]' : 'py-8' }}  px-14 w-full">
        <div class="w-4/5">
            <div class="flex justify-between items-center">
                <h1>
                    
                   {{ empty($item) ? $page_title : $item->name }}
                </h1>
                <div class="flex items-center justify-between gap-5 relative">
                    <a href="{{ route('product.index') }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        Kembali
                    </a>
                    <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Lanjut</button>
                </div>
            </div>
            <div class="tab">
                <a href="{{ route('product.edit.form', ['productId' => $item->id]) }}" aria-selected="true" class="selected">Informasi Produk</a>
                <a href="{{ route('roles.index') }}" aria-selected="true" >Konfigurasi Harga</a>
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14">
        <section class="w-4/5">
                <section class="flex gap-2 justify-between border-b pb-20">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Informasi Dasar</h1>
                        <p>
                            Tingkatkan pendapatanmu dengan menjual produk
                        </p>
                        <br>
                        Silahkan isi beberapa info mendasar terkait dengan detail produk yang akan dibuat
                    </header>
                    <fieldset class="w-3/5">
                        <div>
                            <legend class="mb-2">
                                <label for="name" class="text-[#000000] font-light">Nama <span class="text-danger">*</span></label>
                            </legend>
                            @if (!empty($item))
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            @endif
                            <input type="text" name="name" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ old('name', empty($item) ? '' : $item->name) }}" />
                            @error('name')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <legend class="mb-2">
                                <label for="image" class="text-[#000000] font-light">Gambar <span class="text-danger">*</span></label>
                            </legend>
                            <div class="flex gap-5">
                                <div class="uploader bg-white rounded-md border border-dashed w-40 h-40 border-black flex justify-center items-center relative">
                                    <button type="button" id="btn-upload" class="button text-base hover:text-black bg-black hover:bg-[#ff91e7] text-white px-4 py-2 rounded border border-black flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                        Upload
                                    </button> 
                                    <img src="{{ empty($item) ? '' : $item->image }}" id="preview" class="absolute rounded-md w-full h-full object-contain {{ empty($item) ? 'hidden' : '' }}" />
                                    <svg class="close cursor-pointer {{ empty($item) ? 'hidden' : '' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="red" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                                </div>
                                <input type="file" name="image" class="hidden">
                                <span class="text-sm text-black">Masuk gambar dari produk yang akan kamu buat</span>
                            </div>
                            @error('image')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <legend class="mb-2">
                                <label for="selling_price" class="text-[#000000] font-light">Harga Jual <span class="text-danger">*</span></label>
                            </legend>
                            <input type="number" name="selling_price" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ old('selling_price', empty($item) ? '' : $item->selling_price) }}" />
                            @error('selling_price')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <legend class="mb-2">
                                <label for="category_id" class="text-[#000000] font-light">Kategori <span class="text-danger">*</span></label>
                            </legend>
                            <select name="category_id" class="mb-2 input border rounded-sm px-4 py-2 w-full">
                                <option disabled>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option 
                                        value="{{ $category->id }}"
                                        @if (old('category_id', empty($item) ? '' : $item->category_id)  == $category->id)
                                            selected="selected"
                                        @endif
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <legend class="mb-2">
                                <label for="shelf_id" class="text-[#000000] font-light">Rak <span class="text-danger">*</span></label>
                            </legend>
                            <select name="shelf_id" class="mb-2 input border rounded-sm px-4 py-2 w-full">
                                <option disabled>Pilih Penyimpanan Rak </option>
                                @foreach ($shelfs as $shelf)
                                    <option 
                                        value="{{ $shelf->id }}"
                                        @if (old('shelf_id', empty($item) ? '' : $item->shelf_id)  == $shelf->id)
                                            selected="selected"
                                        @endif
                                    >
                                        {{ $shelf->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shelf_id')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <legend class="mb-2">
                                <label for="description" class="text-[#000000] font-light">Deskripsi</label>
                            </legend>
                            <textarea name="description" rows="10">{{ old('description', empty($item) ? '' : $item->description) }}</textarea>
                            @error('description')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>
                </section>

                <section class="flex gap-2 justify-between pt-10 pb-20">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Notifikasi</h1>
                    </header>
                    <fieldset class="w-3/5">
                        <div>
                            <legend class="mb-2">
                                <label class="text-[#000000] font-light">Notifikasi</label>
                            </legend>
                            <label class="switch">
                                <input 
                                    type="checkbox"
                                    name="notify_when_low_quota"
                                    id="permission"
                                    value="{{ \App\Constant\Constant::OPTION_ENABLE }}"
                                    @if (old('notify_when_low_quota', empty($item) ? '' : ($item->notify_when_low_quota == 1 || $item->notify_when_low_quota == 'on' ? 1 : '')) == \App\Constant\Constant::OPTION_ENABLE)
                                        checked
                                    @endif
                                />
                                <span class="slider round"></span>
                            </label>
                            <label for="notify_when_low_quota" class="text-[#000] font-light ml-1">Nyalakan notifikasi ketika stok produk sudah menipis</label>
                            <div class="notification-box box mt-3 relative {{ old('notify_when_low_quota', empty($item) ? '' : ($item->notify_when_low_quota == 1 || $item->notify_when_low_quota == 'on' ? 1 : '')) == \App\Constant\Constant::OPTION_ENABLE ? '' : 'hidden' }}">
                                <legend class="mb-2">
                                    <label for="min_qty" class="text-[#000000] font-light">Minimal Kuantitas</label>
                                </legend>
                                <input type="number" name="min_qty" id="min_qty" value="{{ old('min_qty', empty($item) ? NULL : $item->min_qty ) }}">
                            </div>
                            @error('min_qty')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </fieldset>
                </section>

                @if(!empty($item))
                    <section class="flex gap-2 justify-between pt-10">
                        <header class="text-[#000000] font-light flex-1">
                            <h1 class="text-2xl mb-2 font-normal">Harga</h1>
                            
                        </header>
                        <fieldset class="w-3/5">
                            <legend class="mb-2">
                                <label class="text-[#000000] font-light">Konfigurasi Harga</label>
                            </legend>
                            <label class="switch">
                                <input 
                                    type="checkbox"
                                    name="use_price_mapping"
                                    value="{{ \App\Constant\Constant::OPTION_ENABLE }}"
                                />
                                <span class="slider round"></span>
                            </label>
                            <label for="notify_when_low_quota" class="text-[#000] font-light ml-1">Jika ini dinyalakan maka harga jual akan mengikuti konfigurasi di bawah ini</label>
                            <div class="price-mapping-box box mt-4 relative ">
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
                                    <tr class="hidden sample-row">
                                            <td>
                                                <select class="w-40" name="unit[]">
                                                    @foreach ($units as $unit_id => $unit_name)
                                                        <option value="{{ $unit_id }}">{{ $unit_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity[]"/>
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
                                    <tr class="nodata-row">
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
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function () {
        const toggleNotification = document.querySelector('input[name="notify_when_low_quota"]')
        const notificationBox = document.querySelector('.notification-box')
        toggleNotification.addEventListener('change', function (event) {
            notificationBox.classList.toggle('hidden')
        })

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
                priceMapping.insertAdjacentElement('afterbegin', row)
                resyncEventHandler()
            })

            function resyncEventHandler() {
                const deleteRowsBtn = document.querySelectorAll('.delete-row')
                deleteRowsBtn.forEach(function (item) {
                    item.addEventListener('click', function (event) {
                        event.preventDefault();
                        const sd = item.parentElement.parentElement
                        sd.remove()
                    })
                })
            }
        }
       
        const btnUpload = document.getElementById('btn-upload')
        const uploader = document.querySelector('input[name="image"]')
        btnUpload.addEventListener('click', function (event) {
            event.preventDefault()
            uploader.click()
        })

        const closeIcon = document.querySelector('.close')
        const previewImage = document.getElementById('preview');
        uploader.addEventListener('change', function () {
            const fileInput = this;

            if (fileInput.files.length > 0) {

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.classList.remove('hidden')
                    closeIcon.classList.remove('hidden')
                    previewImage.setAttribute('src', e.target.result)
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
              
            }
        })

        closeIcon.addEventListener('click', function () {
            previewImage.setAttribute('src', '')
            previewImage.classList.add('hidden')
            closeIcon.classList.add('hidden')
        })
    })
</script>
@endpush