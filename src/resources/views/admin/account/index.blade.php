@extends('layout.dashboard')
@section('content')
<div class="second-nav py-[2.7rem] px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
               Buku Kas
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                <button class="button text-base text-black p-3 rounded border border-black relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <div class="menu top-14 left-[-1px] hidden">
                        <div class="search flex justify-between items-center border border-black rounded-sm px-2 gap-2 m-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <input type="text" placeholder="cari produk" class="p-2 focus:outline-none">
                        </div>
                    </div>
                </button>
                <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Buat Kas Baru</button>
            </div>
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
        <table class="w-full retro">
            <caption class="text-2xl text-black [text-align:unset]">Buku Kas</caption>
            <thead>
                <tr>
                    <th class="text-left">Nama</th>
                    <th class="text-left">Saldo Sekarang</th>
                    <th  class="w-[5%]"></th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $total_balance = 0;
                @endphp
                @foreach($accounts as $account)
                    @php
                        $total_balance += $account->current_balance;
                    @endphp
                    <tr>
                        <td class="font-bold">
                           {{ $account->name }}
                        </td>
                        <td>
                            {{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $account->current_balance) }}
                        </td>
                        <td class="relative">
                            <a href="" data-id="{{ $account->id }}" data-name="action" class="dropdown" role="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                            </a>
                            <div class="menu hidden w-[220px] left-[0px]" data-id="{{ $account->id }}" data-name="action" role="dropdown-content">
                                <a href="" class="menu-item">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                    Ubah
                                </a>
                                <a href="" class="menu-item">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
                                    Lihat Arus Keuangan
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <span class="font-bold">
                            Total Saldo {{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $total_balance) }}
                        </span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </section>
</main>
@endsection