@extends('layout.dashboard')
@section('content')
<main x-data="activity">
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
					$form = Form::open(['route' => 'user.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']);
					if (empty($item)) $form = Form::open(['route' => 'user.create', 'method' => 'POST', 'enctype' => 'multipart/form-data']);	
				@endphp 
                {{ $form }}
                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Nama
                          </label>
						@if (!empty($item))
						  <input type="hidden" name="id" value="{{ $item->id }}">
						@endif
                        <input type="text" placeholder="Name" name="name"
                            value="{{ old('name', !empty($item->name) ? $item->name : '') }}"
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        @error('name')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Email
                          </label>
                        <input type="text" name="email"
                            value="{{ old('email', !empty($item->email) ? $item->email : '') }}"
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        @error('email')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (count($roles) > 0)
                        <div class="mb-5.5">
                            <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                Jenis Peran
                            </label>
                            <div class="relative z-20 bg-transparent dark:bg-form-input">
                                <select name="role_id" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                    <option value="0">Pilih Peran</option>
                                    @foreach ($roles as $role)
                                        @php
                                            $selected = FALSE;
                                            if (!empty($item) && $item->role_id == $role->id)
                                                $selected = TRUE;
                                        @endphp 
                                        <option {{ $selected ? 'selected' : '' }} value="{{ $role->id }}">{{  $role->name }}</option>
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
                            @error('role_id')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>  
                    @endif
                   
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