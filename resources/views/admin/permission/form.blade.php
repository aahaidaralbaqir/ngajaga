@extends('layout.dashboard')
@section('content')
<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mx-auto max-w-270">
        @include('partials.alert')
        <!-- ====== Settings Section Start -->
            <div
                class="w-full rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
					@if (empty($item))
						Menambahkan data
					@else
						Mengupdate data
					@endif
                </h3>
                </div> 
                <div class="p-7">
				@php
					$form = Form::open(['route' => 'permission.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']);
					if (empty($item)) $form = Form::open(['route' => 'permission.create', 'method' => 'POST', 'enctype' => 'multipart/form-data']);	
				@endphp 
                {{ $form }}
                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Nama
                          </label>
						@if (!empty($item))
						  <input type="hidden" name="id" value="{{ $item->id }}">
						@endif
                        <input type="text" placeholder="" name="name"
                            value="{{ old('name', !empty($item->name) ? $item->name : '') }}"
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        @error('name')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Alias
                          </label>
                        <input type="text" name="alias"
                            value="{{ old('alias', !empty($item->alias) ? $item->alias : '') }}"
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        @error('alias')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Path
                          </label>
                        <input type="text" name="url"
                            value="{{ old('url', !empty($item->alias) ? $item->alias : '') }}"
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        @error('url')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Icon
                          </label>
                        <textarea rows="6" placeholder="" name="icon" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('icon', !empty($item) ? $item->icon : '') }}</textarea>
                        @error('icon')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
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