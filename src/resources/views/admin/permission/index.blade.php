@extends('layout.dashboard')
@section('content')
<div class="second-nav py-8 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
                Akses Kontrol
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                @if (in_array(\App\Constant\Permission::CREATE_PERMISSION, $user['permission']))
                    <a class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black" href="{{ route('permission.create') }}">Buat Hak Akses</a>
                @endif
            </div>
        </div>
        <div class="tab">
            @if (in_array(\App\Constant\Permission::VIEW_PERMISSION, $user['permission']))
                <a href="{{ route('permission.index') }}" aria-selected="true" class="selected">Hak Akses</a>
            @endif
            @if (in_array(\App\Constant\Permission::VIEW_ROLE, $user['permission']))
                <a href="{{ route('roles.index') }}" aria-selected="true">Peran</a>
            @endif
            @if (in_array(\App\Constant\Permission::VIEW_USER, $user['permission']))
                <a href="{{ route('user.index') }}" aria-selected="true">Pengguna</a>
            @endif
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
        <table class="w-full retro">
            <caption class="text-2xl text-black [text-align:unset]">Hak Akses</caption>
            <thead>
                <tr>
                    <th class="w-[5%]"></th>
                    <th class="text-left">Nama</th>
                    <th  class="w-[5%]"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td class="font-bold">
                            @if (count($permission->childs) > 0)
                                <a href="" class="font-extrabold" data-id="{{ $permission->id }}" data-name="table" role="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                            @endif
                        </td>
                        <td>
                            <span class="font-bold">{{ $permission->name }}</span>
                            <br>
                            @if (count($permission->childs) > 0)
                                <span class="text-xs">
                                    {{ count($permission->childs) }} Hak Akses
                                </span>
                            @endif
                        </td>
                        <td class="relative">
                            @if (in_array(\App\Constant\Permission::UPDATE_PERMISSION, $user['permission'])) 
                                <a href="" data-id="{{ $permission->id }}" data-name="action" class="dropdown" role="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                </a>
                                <div class="menu hidden" data-id="{{ $permission->id }}" data-name="action" role="dropdown-content">
                                    @if (in_array(\App\Constant\Permission::UPDATE_PERMISSION, $user['permission']))
                                        <a href="{{ route('permission.edit.form', ['permissionId' => $permission->id ]) }}" class="menu-item">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                    @foreach($permission->childs as $child)
                        <tr class="hidden" data-id="{{ $child->id_parent }}" data-name="table" role="dropdown-content">
                            <td class="font-bold">
                            </td>
                            <td>{{ $child->name }}</td>
                            <td class="relative">
                                <a href="" data-id="{{ $child->id }}" data-name="action" class="dropdown" role="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                </a>
                                <div class="menu hidden" data-id="{{ $child->id }}" data-name="action" role="dropdown-content">
                                    <a href="{{ route('permission.edit.form', ['permissionId' => $child->id ]) }}" class="menu-item">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                        Ubah
                                    </a>
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="font-bold">Total {{ $total_row }}</td>
                </tr>
            </tfoot>
        </table>
    </section>
</main>
@endsection