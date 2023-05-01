@extends('layout.dashboard')
@section('content')
<main x-data="heroes"
	  x-init="
	 	image_url = '@php echo empty($item) ? '' : $item->banner @endphp' 
	  "
	>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mx-auto max-w-270">
        @include('partials.alert')
        <!-- ====== Settings Section Start -->
            <div
                class="w-full rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
					@if (empty($item))
						Menambahkan tulisan baru 
					@else
						Mengupdate tulisan 
					@endif
                </h3>
                </div> 
                <div class="p-7">
				@php
					$form = Form::open(['route' => 'post.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']);
					if (empty($item))
						$form = Form::open(['route' => 'post.create', 'method' => 'POST', 'enctype' => 'multipart/form-data']);	
				@endphp 
                {{ $form }}
                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Judul
                          </label>
						@if (!empty($item))
						  <input type="hidden" name="id" value="{{ $item->id }}">
						@endif
                        <input type="text" placeholder="Isi judul kamu di sini" name="title"
                            value="{{ old('title', !empty($item->title) ? $item->title : '') }}"
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        @error('title')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Kategori
                          </label>
                        <div class="relative z-20 bg-transparent dark:bg-form-input">
                        <select name="category" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                            <option value="0">Pilih kategori tulisan</option>
                            @foreach ($categories as $key => $value)
								@php
									$selected = FALSE;
									if (!empty($item) && $item->category == $value)
										$selected = TRUE;
								@endphp 
                                <option {{ $selected ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.8">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                            </g>
                            </svg>
                        </span>
                        </div>
                        @error('category')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>
               
                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Konten
                          </label>
                        <textarea rows="6" placeholder="Isi konten kamu" name="content"
                          class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{!! old('content', !empty($item) ? $item->content : '') !!}</textarea>
                        @error('content')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5.5  lg:flex lg:gap-4.5">
                        <div class="flex-1">
                            <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                Banner
                            </label>
                            <div id="FileUpload"
                                class="relative mb-5.5 block w-full cursor-pointer appearance-none rounded border-2 border-dashed border-primary bg-gray py-4 px-4 dark:bg-meta-4 sm:py-7.5">
                                <input type="file" accept="image/*"
                                    name="image"
                                    @change.debounce="handleChangeImage"
                                    class="absolute inset-0 z-50 m-0 h-full w-full cursor-pointer p-0 opacity-0 outline-none" />
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.99967 9.33337C2.36786 9.33337 2.66634 9.63185 2.66634 10V12.6667C2.66634 12.8435 2.73658 13.0131 2.8616 13.1381C2.98663 13.2631 3.1562 13.3334 3.33301 13.3334H12.6663C12.8431 13.3334 13.0127 13.2631 13.1377 13.1381C13.2628 13.0131 13.333 12.8435 13.333 12.6667V10C13.333 9.63185 13.6315 9.33337 13.9997 9.33337C14.3679 9.33337 14.6663 9.63185 14.6663 10V12.6667C14.6663 13.1971 14.4556 13.7058 14.0806 14.0809C13.7055 14.456 13.1968 14.6667 12.6663 14.6667H3.33301C2.80257 14.6667 2.29387 14.456 1.91879 14.0809C1.54372 13.7058 1.33301 13.1971 1.33301 12.6667V10C1.33301 9.63185 1.63148 9.33337 1.99967 9.33337Z"
                                        fill="#3C50E0" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.5286 1.52864C7.78894 1.26829 8.21106 1.26829 8.4714 1.52864L11.8047 4.86197C12.0651 5.12232 12.0651 5.54443 11.8047 5.80478C11.5444 6.06513 11.1223 6.06513 10.8619 5.80478L8 2.94285L5.13807 5.80478C4.87772 6.06513 4.45561 6.06513 4.19526 5.80478C3.93491 5.54443 3.93491 5.12232 4.19526 4.86197L7.5286 1.52864Z"
                                        fill="#3C50E0" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.99967 1.33337C8.36786 1.33337 8.66634 1.63185 8.66634 2.00004V10C8.66634 10.3682 8.36786 10.6667 7.99967 10.6667C7.63148 10.6667 7.33301 10.3682 7.33301 10V2.00004C7.33301 1.63185 7.63148 1.33337 7.99967 1.33337Z"
                                        fill="#3C50E0" />
                                    </svg>
                                    </span>
                                    <p class="font-medium text-sm">
                                    <span class="text-primary">Click to upload</span>
                                    or drag and drop
                                    </p>
                                    <p class="mt-1.5 font-medium text-sm">SVG, PNG, JPG or GIF</p>
                                    <p class="font-medium text-sm">(max, 800 X 800px)</p>
                                </div>
                            </div>
                            @error('banner')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
							<div class="flex-1" x-show="image_url != ''">
								<label class="mb-3 block font-medium text-sm text-black dark:text-white">
									Preview Gambar
								</label>
								<div class="h-24 w-24">
									<img src="/img/user/user-01.png" :src="image_url" alt="User" />
								</div>
							</div>
                    </div>

                    <div class="flex justify-end gap-4.5">
                    <button
                        class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                        type="submit">
                        Simpan
                    </button>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
    
        <!-- ====== Settings Section End -->
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('tinymce/tinymce.js') }}"></script>
    <script>
        tinymce.init({
            selector:'textarea',
            height: 700
        });
    </script>
@endpush