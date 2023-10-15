@extends('layout.dashboard')
@section('content')
<main
    x-data="activity"
    x-init="
        status = {{ (!empty($item) && $item->status == 'Active') ? 'true' : 'false' }};
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
						Menambahkan data
					@else
						Mengupdate data
					@endif
                </h3>
                </div> 
                <div class="p-7">
				@php
					$form = Form::open(['route' => 'roles.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']);
					if (empty($item)) $form = Form::open(['route' => 'roles.create', 'method' => 'POST', 'enctype' => 'multipart/form-data']);	
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
                            Hak Akses
                        </label>
                        @foreach ($list_permission as $each_permission)
                            @php
                                $checked = FALSE;

                                $selected_permission = empty($item) ? [] : explode(',', $item->permission);
                                if (!empty($item) && in_array($each_permission['id'], $selected_permission)) $checked = TRUE;
                            @endphp
                            <label for="{{ $each_permission['id'] }}" class="flex cursor-pointer select-none items-center">
                                <div class="relative">
                                <input name="permission[]" type="checkbox" id="{{ $each_permission['id'] }}" value="{{ $each_permission['id'] }}" {{ $checked ? 'checked' : '' }}>
                                </div>
                                <span class="ml-2">{{ $each_permission['name'] }}</span>
                            </label>
                        @endforeach
                        @error('permission')
                            <span class="text-sm text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-5.5">
                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                            Status
                        </label>
                        <div class="relative">
                          <input 
                            type="checkbox" 
                            name="status" 
                            id="toggle4" 
                            class="sr-only" 
                            @change="status = !status"
                            {{ (!empty($item) && $item->status) ? 'checked' : '' }}
                        >
                          <div :class="status && '!right-1 !translate-x-full' && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black" @click="changeStatus"></div>
                            <div :class="status && '!right-1 !translate-x-full'" @click="changeStatus" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                        </div>
                        @error('status')
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