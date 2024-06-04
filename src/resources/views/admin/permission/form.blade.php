@extends('layout.dashboard')
@section('content')
<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mx-auto max-w-180">
        @include('partials.alert')
        <!-- ====== Settings Section Start -->
            <div
                class="w-full rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
					@if (empty($item))
						Menambahkan hak akses baru
					@else
						Mengupdate hak akses
					@endif
                </h3>
                </div> 
                <div class="p-7">
                    @php
                        $form = Form::open(['route' => 'permission.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']);
                        if (empty($item)) $form = Form::open(['route' => 'permission.create', 'method' => 'POST', 'enctype' => 'multipart/form-data']);	
                    @endphp 
                    {{ $form }}
                    @if (count($permissions) > 0)
                        <div class="mb-5.5">
                            <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                Pusah Hak Akses
                            </label>
                            <div class="relative z-20 bg-transparent dark:bg-form-input">
                                <select name="id_parent" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent px-5 py-3 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white">
                                    <option value="0" selected class="text-body dark:text-bodydark">Pilih Pusat Hak Akses</option>
                                    @foreach($permissions as $permission)
                                        <option 
                                            value="{{ $permission->id }}"
                                            class="text-body dark:text-bodydark"
                                            @if ($permission->id == old('id_parent', empty($item) ? NULL : $item->id))
                                                selected="selected"
                                            @endif
                                        >
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.8"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path></g></svg>
                                </span>
                            </div>
                            @error('id_parent')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="mb-5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                Nama
                            </label>
                            @if (!empty($item))
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            @endif
                                <input type="text" placeholder="" name="name"
                                    value="{{ old('name', empty($item) ? '' : $item->name) }}"
                                    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" 
                                />
                            @error('name')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full xl:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white"> Metode </label>
                            <div class="relative z-20 bg-transparent dark:bg-form-input">
                                <select name="method" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent px-5 py-3 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white">
                                    <option value="" disabled="" class="text-body dark:text-bodydark">Pilih Metode</option>
                                    @foreach($methods as $method_name)
                                        <option 
                                            value="{{ $method_name }}" 
                                            class="text-body dark:text-bodydark"
                                            @if ($method_name == old('method', empty($item) ? '' : $item->id))
                                                selected="selected"
                                            @endif
                                        >
                                            {{ $method_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.8"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path></g></svg>
                                </span>
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