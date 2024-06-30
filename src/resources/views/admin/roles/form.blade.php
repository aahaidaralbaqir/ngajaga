@extends('layout.dashboard')
@section('content')
{{ Form::open(['route' => $target_route, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    <div class="second-nav py-[2.7rem] px-14 w-full">
        <div class="w-4/5">
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
    <main class="w-full py-14 px-14">
        <section class="w-4/5">
                <section class="flex gap-2 justify-between border-b py-5">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Informasi Dasar</h1>
                        <p>
                            Kategorikan wewenang setiap pengguna aplikasi dengan menggunakan peran 
                            <br>
                            Pembuatan peran disesuaikan dengan wewenang yang dimiliki oleh setiap individu
                        </p>
                        <br>
                    </header>
                    <fieldset class="w-3/5">
                        <div>
                            <legend class="mb-2">
                                <label for="name" class="text-[#000000] font-light">Nama <span class="text-danger">*</span></label>
                            </legend>
                            @if (!empty($item))
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            @endif
                            <input type="text" name="name" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ empty($item) ? ''  : $item->name }}" />
                            @error('name')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <legend class="mb-2">
                                <label for="name" class="text-[#000000] font-light">Status <span class="text-danger">*</span></label>
                            </legend>
                            <select name="status">
                                <option disabled>Pilih status</option>
                                @foreach ($status as $id => $status_name)
                                    <option 
                                        value="{{ $id }}"
                                        @if (!empty($item) && $id == $item->status)
                                            selected="selected"
                                        @endif
                                    >
                                        {{ $status_name }}
                                    </option>
                                @endforeach
                            </select> 
                            @error('status')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>
                </section>
                <section class="flex gap-2 justify-between py-20">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Hak Akses</h1>
                        <p>
                           Pilih hak akses dari peran yang akan kamu buat
                        </p>
                        <br>
                    </header>
                    <fieldset class="w-3/5">
                        <div>
                            <table class="w-full retro">
                                <thead>
                                    <tr>
                                        <th class="w-[5%]"></th>
                                        <th class="text-left">Nama Hak Akses</th>
                                        <th  class="w-[5%]"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                    <tr>
                                        <td>
                                            @if (count($permission->childs) > 0)
                                                <a href="" class="font-extrabold" data-id="{{ $permission->id }}" data-name="table" role="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $permission->name }}
                                        </td>
                                        <td>
                                            @if (count($permission->childs) == 0)
                                                <label class="switch">
                                                    <input
                                                        type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $permission->id }}"
                                                        id="permission"
                                                        data-id-parent="{{ $permission->id_parent }}"
                                                        @if (!empty($item) && in_array($permission->id, $item->permission))
                                                            checked
                                                        @endif
                                                    />
                                                    <span class="slider round"></span>
                                                </label>
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach($permission->childs as $child)
                                        <tr class="{{ empty($item) ? 'hidden' : '' }}" data-id="{{ $child->id_parent }}" data-name="table" role="dropdown-content">
                                            <td></td>
                                            <td>{{ $child->name }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input 
                                                        type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $child->id }}"
                                                        id="permission"
                                                        data-id-parent="{{ $child->id_parent }}"
                                                        @if (!empty($item) && in_array($child->id, $item->permission))
                                                            checked
                                                        @endif
                                                    />
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                   @endforeach
                                </tbody>
                            </table>
                            @error('permission')
                                <span class="text-sm text-danger mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>
                </section>
        </section>
    </main>
{{ Form::close() }}
@endsection