@extends('layout.dashboard')
@section('content')
<div class="second-nav py-[2.7rem] px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
              Pelanggan 
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                @if ($has_filter)
                    <a href="{{ route('customer.index') }}" class="button text-base text-black p-3 rounded border border-black relative">
                        Hapus Filter
                    </a>
                @endif
                <button class="button text-base text-black p-3 rounded border border-black relative" data-id="xyz" data-name="action" class="dropdown" role="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
                <div class="menu top-16 w-96 px-5 right-[150px] hidden" id="overide_menu" data-id="xyz" data-name="action" role="dropdown-content">
                    <form action="{{ route('customer.index') }}" method="get">
                        <svg class="absolute mt-3 ml-2" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input  value="{{ request('search') }}" type="text" name="search" placeholder="cari berdasarkan nama" class="focus:outline-none" style="padding-left: 2.5rem">
                    </form>
                </div>
                <a class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black" href="{{ route('account.create.form') }}">Buat Pelanggan Baru</a>
            </div>
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
        <table class="w-full retro">
            <caption class="text-2xl text-black [text-align:unset]">Pelanggan</caption>
            <thead>
                <tr>
                    <th class="text-left">Nama</th>
                    <th class="text-left">No.Telepon</th>
                    <th class="text-left">Jumlah Transaksi</th>
                    <th class="text-left">Jumlah Kasbon</th>
                    <th  class="w-[5%]"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td class="font-bold">
                           {{ $customer->name }}
                        </td>
                        <td>
                            {{ $customer->phone_number }}
                        </td>
                        <td>{{ $customer->total_transaction }}x</td>
                        <td>{{ $customer->total_debt }}x</td>
                        <td class="relative">
                            <a href="" data-id="{{ $customer->id }}" data-name="action" class="dropdown" role="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                            </a>
                            <div class="menu hidden w-[220px] left-[0px]" data-id="{{ $customer->id }}" data-name="action" role="dropdown-content">
                                <a href="{{ route('account.edit.form', ['accountId' => $customer->id]) }}" class="menu-item">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                    Ubah
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if (count($customers) <= 0)
                    <tr>
                        <td colspan="5">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if ($customers->total() > 0)
            {{ $customers->appends(request()->except('page'))->links() }}
        @endif
    </section>
</main>
@endsection
@push('styles')
    <style type="text/css">
        #overide_menu::after {
            content: "";
            border-left: solid .5rem rgba(0, 0, 0, 0);
            border-right: solid .5rem rgba(0, 0, 0, 0);
            border-bottom: solid .5rem black;
            position: absolute;
            top: -9px;
            left: 80%;
            transform: translate(-50%, 0);
            z-index: 30;
       } 
    </style>
@endpush