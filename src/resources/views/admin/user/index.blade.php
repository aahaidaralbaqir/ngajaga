@extends('layout.dashboard')
@section('content')
<div class="second-nav py-8 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
                Akses Kontrol
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                @if (in_array(\App\Constant\Permission::CREATE_USER, $user['permission']))
                    <a href="{{ route('user.create.form') }}" class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Buat Pengguna</a>
                @endif
            </div>
        </div>
        <div class="tab">
            @if (in_array(\App\Constant\Permission::VIEW_PERMISSION, $user['permission']))
                <a href="{{ route('permission.index') }}" aria-selected="true">Hak Akses</a>
            @endif
            @if (in_array(\App\Constant\Permission::VIEW_ROLE, $user['permission']))
                <a href="{{ route('roles.index') }}" aria-selected="true">Peran</a>
            @endif
            @if (in_array(\App\Constant\Permission::VIEW_USER, $user['permission']))
                <a href="{{ route('user.index') }}" aria-selected="true" class="selected">Pengguna</a>
            @endif
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
        <table class="w-full retro">
            <caption class="text-2xl text-black [text-align:unset]">Pengguna</caption>
            <thead>
                <tr>
                    <th class="w-[5%]"></th>
                    <th class="text-left">Nama</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Peran</th>
                    <th  class="w-[5%]"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $item)
                    <tr>
                        <td class="font-bold">
                        </td>
                        <td>
                            <span class="font-bold">{{ $item->name }}</span>
                        </td>
                        <td>
                            {{ $item->email }}
                        </td>
                        <td>
                            <span class="text-sm">{{ $item->roles->name }}</span>
                        </td>
                        <td>
                            @if (in_array(\App\Constant\Permission::UPDATE_USER, $user['permission']))
                                <div class="relative">
                                    <a href="" data-id="{{ $item->id }}" data-name="action"  class="dropdown" role="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    </a>
                                    <div class="menu hidden" data-id="{{ $item->id }}" data-name="action" role="dropdown-content">
                                        <a href="{{ route('user.update.form', ['userId' => $item->id]) }}" class="menu-item">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="font-bold">Total {{ $total_row }}</td>
                </tr>
            </tfoot>
        </table>
    </section>
</main>
@endsection