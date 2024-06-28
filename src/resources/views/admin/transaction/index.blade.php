@extends('layout.dashboard')
@section('content')
    <div class="second-nav py-8 px-14 w-full">
        <div class="w-4/5">
            <div class="flex justify-between items-center">
                <h1>
                    Transaksi
                </h1>
                <div class="flex items-center justify-between gap-5 relative">
                    @if ($has_filter)
                    <a href="{{ route('transaction.index') }}" class="button text-base text-black p-3 rounded border border-black relative">
                        Hapus Filter
                    </a>
                    @endif
                    <a href="{{ route('transaction.download') }}" class="button text-base text-black p-3 rounded border border-black relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-to-line"><path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/></svg>
                    </a>
                    <button class="button text-base text-black p-3 rounded border border-black relative" role="dropdown" data-id="89" data-name="action">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-filter"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
					</button>
                    <div class="menu top-14 right-1 mt-2 hidden" id="cmenu" data-id="89" data-name="action" role="dropdown-content">
                        <form action="{{ route('transaction.index') }}" method="GET">
                            <div class="flex gap-5 border-b p-4">
                                <fieldset>
                                    <label for="start" class="text-black">Dari Tanggal</label>
                                    <div class="flex gap-4 mt-2">
                                        <input type="date" name="transaction_start" id="" value="{{ request('transaction_start') }}">
                                        <input type="date" name="transaction_end" id="" value="{{ request('transaction_end') }}">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="flex gap-5 border-b p-4">
                                <fieldset>
                                    <label for="start" class="text-black">Total Pembelian</label>
                                    <div class="flex gap-4 mt-2">
                                        <input type="number" name="price_total_start" id="" value="{{ request('price_total_start') }}">
                                        <input type="number" name="price_total_end" id="" value="{{ request('price_total_end') }}">
                                    </div>
                                    
                                </fieldset>
                            </div>
                            <div class="flex gap-5 border-b p-4">
                                <fieldset class="w-full">
                                    <label for="start" class="text-black">Akun</label>
                                    <select name="account" class="w-full" id="">
                                        <option value="0" readonly>Pilih Akun</option>
                                        @foreach ($accounts as $account)
                                            <option 
                                                value="{{ $account->id }}"
                                                @if (request('account') == $account->id)
                                                    selected
                                                @endif
                                            >
                                                    {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="flex gap-5 border-b p-4">
                                <fieldset class="w-full">
                                    <label for="start" class="text-black">Pelanggan</label>
                                    <select name="customer" class="w-full" id="">
                                        <option value="0" readonly>Pilih Pelanggan</option>
                                        @foreach ($customers as $customer)
                                            <option 
                                                value="{{ $customer->id }}"
                                                @if (request('customer') == $customer->id)
                                                    selected
                                                @endif
                                            >
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="flex gap-5 border-b p-4">
                                <fieldset class="w-full">
                                    <label for="start" class="text-black">Pengguna</label>
                                    <select name="user" class="w-full" id="">
                                        <option value="0" readonly>Pilih Pengguna</option>
                                        @foreach ($users as $user1)
                                            <option 
                                                value="{{ $user1->id }}"
                                                @if (request('user') == $user1->id)
                                                    selected
                                                @endif
                                            >
                                                {{ $user1->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="mt-4 flex gap-5 p-4">
                                <button type="submit" class="w-full button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Saring</a>
                            </div>
                        </form>
                    </div>
                    <a href="{{ route('transaction.create.form') }}" class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Buat Transaksi Baru</a>
                </div>
            </div>
            <div class="tab">
                <a href="{{ route('transaction.index') }}" aria-selected="true" class="selected">Transaksi</a>
                <a href="{{ route('transaction.debt.index') }}" aria-selected="true">Kasbon</a>
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14">
        <section class="w-4/5">
            <div class="flex gap-5">
                
                <div class="box w-[350px] border-black text-black" style="border-radius: 0.25rem;">
                    <h4 class="text-base">Total Transaksi Hari Ini</h4>
                    <span class="text-2xl block mt-5" style="font-size: 40px">{{ $today_summary->total_transaction }}</span>
                </div>
                <div class="box w-[350px] border-black text-black" style="border-radius: 0.25rem;">
                    <h4 class="text-base">Produk Terjual</h4>
                    <span class="text-2xl block mt-5" style="font-size: 40px">{{ $today_summary->total_product_qty }}</span>
                </div>
                <div class="box w-[350px] border-black text-black" style="border-radius: 0.25rem;">
                    <h4 class="text-base">Keuntungan Hari Ini</h4>
                    <span class="text-2xl block mt-5" style="font-size: 40px">{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $today_summary->total_amount) }}</span>
                </div>
            </div>
            
            <table class="w-full retro mt-10">
                <caption class="text-2xl text-black [text-align:unset]">Transaksi</caption>
                <thead>
                    <tr>
                        <th class="w-[5%]"></th>
                        <th class="text-left">No.Transaksi</th>
                        <th class="text-left">Metode Pembayaran</th>
                        <th class="text-left">Di Buat Oleh</th>
                        <th class="text-left">Total Pembayaran</th>
                        <th class="text-left">Nominal Hutang</th>
                        <th class="text-left">Nama Pelanggan</th>
                        <th class="text-left">Akun</th>
                        <th class="w-[5%]"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td></td>
                            <td>{{ $transaction->order_id }}</td>
                            <td>
                                <a href="{{ route('transaction.edit.debt.form', ['debtId' => $transaction->debt_id]) }}" class="block px-1 text-center py-1 border border-black">
                                    {{ $transaction->debt_id ? 'Hutang ': 'Cash' }}
                                </a>
                            </td>
                            <td>{{ $transaction->created_by_name }}</td>
                            <td>{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $transaction->price_total) }}</td>
                            <td>
                                {{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $transaction->debt_amount) }}
                            </td>
                            <td>{{ $transaction->customer_name }}</td>
                            <td>{{ $transaction->account_name }}</td>
                            <td>
                                <div class="relative">
                                    <a href="" data-id="{{ $transaction->id }}" data-name="action"  class="dropdown" role="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    </a>
                                    <div class="menu hidden" data-id="{{ $transaction->id }}" data-name="action" role="dropdown-content">
                                        <a href="{{ route('transaction.edit.form', ['transactionId' => $transaction->id]) }}" class="menu-item">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($transactions) < 1)
                    <tr>
                        <td colspan="8">Tidak ada data</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @if ($transactions->total() > 0)
                {{ $transactions->appends(request()->except('page'))->links() }}
            @endif

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
    </style>
@endpush