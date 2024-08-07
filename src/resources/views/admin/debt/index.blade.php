@extends('layout.dashboard')
@section('content')
    <div class="second-nav py-8 px-14 w-full">
        <div class="w-4/5">
            <div class="flex justify-between items-center">
                <h1>
                   Kasbon 
                </h1>
                <div class="flex items-center justify-between gap-5 relative">
                    @if (in_array(\App\Constant\Permission::SEARCH_DEBT, $user['permission']))
                        @if ($has_filter)
                            <a href="{{ route('debt.index') }}" class="button text-base text-black p-3 rounded border border-black relative">
                                Hapus Filter
                            </a>
                        @endif
                        <button class="button text-base text-black p-3 rounded border border-black relative" data-id="xyz" data-name="action" class="dropdown" role="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </button>
                        <div class="menu top-16 w-96 px-5 right-[120px] hidden" id="overide_menu" data-id="xyz" data-name="action" role="dropdown-content">
                            <form action="{{ route('debt.index') }}" method="get">
                                <svg class="absolute mt-3 ml-2" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                <input  value="{{ request('search') }}" type="text" name="search" placeholder="cari berdasarkan No.Transaksi" class="focus:outline-none" style="padding-left: 2.5rem">
                            </form>
                        </div>
                    @endif
                    @if (in_array(\App\Constant\Permission::CREATE_DEBT, $user['permission']))
                        <a href="{{ route('debt.create.form') }}" class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Buat Kasbon Baru</a>
                    @endif
                </div>
            </div>
            <div class="tab">
                @if (in_array(\App\Constant\Permission::VIEW_TRANSACTION, $user['permission'])) 
                    <a href="{{ route('transaction.index') }}" aria-selected="true">Transaksi</a>
                @endif
                @if (in_array(\App\Constant\Permission::VIEW_DEBT, $user['permission'])) 
                    <a href="{{ route('debt.index') }}" aria-selected="true" class="selected">Kasbon</a>
                @endif
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14">
        <section class="w-4/5">
            <table class="w-full retro">
                <caption class="text-2xl text-black [text-align:unset]">Kasbon</caption>
                <thead>
                    <tr>
                        <th class="w-[5%]"></th>
                        <th class="text-left">No.Transaksi</th>
                        <th class="text-left">Nama Pembeli</th>
                        <th class="text-left">Total Hutang</th>
                        <th class="text-left">Total Pembayaran</th>
                        <th class="w-[5%]"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($debts as $debt)
                        <tr>
                            <td></td>
                            <td><a href="{{ route('transaction.edit.form', ['transactionId' => $debt->transaction_id]) }}">{{ $debt->order_id }}</a></td>
                            <td>{{ $debt->customer_name }}</td>
                            <td>{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $debt->amount) }}</td>
                            <td>{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $debt->receivable_amount) }}</td>
                            <td>
                                @if (in_array(\App\Constant\Permission::UPDATE_DEBT, $user['permission']) || in_array(\App\Constant\Permission::VIEW_RECEIVABLE, $user['permission'])) 
                                <div class="relative">
                                    <a href="" data-id="{{ $debt->id }}" data-name="action"  class="dropdown" role="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    </a>
                                    <div class="menu hidden w-[200px] left-[-12px]" data-id="{{ $debt->id }}" data-name="action" role="dropdown-content">
                                        @if (in_array(\App\Constant\Permission::UPDATE_DEBT, $user['permission'])) 
                                        <a href="{{ route('edit.debt.form', ['debtId' => $debt->id]) }}" class="menu-item">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                        @endif
                                        @if (in_array(\App\Constant\Permission::VIEW_RECEIVABLE, $user['permission'])) 
                                            <a href="{{ route('receivable.index', ['debtId' => $debt->id]) }}" class="menu-item">
                                                <svg class="h-4 w-4"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-coins"><path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 16 6 6"/><circle cx="16" cy="9" r="2.9"/><circle cx="6" cy="5" r="3"/></svg>
                                                Lihat pembayaran
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if (count($debts) < 1)
                    <tr>
                        <td colspan="6">Tidak ada data</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </section>
    </main>
@endsection
@push('styles')
    <style type="text/css">
        #cmenu::after {	
            content: "";
            border-left: solid .5rem rgba(0, 0, 0, 0);
            border-right: solid .5rem rgba(0, 0, 0, 0);
            border-bottom: solid .5rem black;
            position: absolute;
            top: -9px;
            left: 45%;
            transform: translate(-50%, 0);
            z-index: 30;
        }

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