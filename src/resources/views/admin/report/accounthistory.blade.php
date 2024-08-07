@extends('layout.dashboard')
@section('content')
<div class="second-nav py-8 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <div class="flex gap-4 items-center">
                <a href="{{ route('account.report') }}" class="button text-base bg-white text-black p-3 rounded border border-black relative flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <h3 class="text-2xl text-black">Laporan</h3>
            </div>
            <div class="flex items-center justify-between gap-5 relative">
                @if (in_array(\App\Constant\Permission::DOWNLOAD_ACCOUNT_ACTIVITY, $user['permission']))
                    <a href="{{ route('account.activity.download', ['accountId' => $item->id]) }}" class="button text-base text-black p-3 rounded border border-black relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-to-line"><path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/></svg>
                    </a>
                @endif
                @if (in_array(\App\Constant\Permission::FILTER_ACCOUNT_ACTIVITY, $user['permission']))
                    @if ($has_filter)
                        <a href="{{ route('account.activity.report', ['accountId' => $item->id]) }}" class="button text-base text-black p-3 rounded border border-black relative">
                            Hapus Filter
                        </a>
                    @endif
                    <button class="button text-base text-black p-3 rounded border border-black relative" role="dropdown" data-id="89" data-name="action">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-filter"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
                    </button>
                    <div class="menu top-14 right-1 mt-2 hidden" id="cmenu" data-id="89" data-name="action" role="dropdown-content">
                        <form action="{{ route('account.activity.report', ['accountId' => $item->id]) }}" method="GET">
                            <div class="flex gap-5 border-b p-4">
                                <fieldset>
                                    <label for="start" class="text-black">Dari Tanggal</label>
                                    <div class="flex gap-4 mt-2">
                                        <input type="date" name="start_date" id="" value="{{ request('start_date') }}">
                                        <input type="date" name="end_date" id="" value="{{ request('end_date') }}">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="mt-4 flex gap-5 p-4">
                                <button type="submit" class="w-full button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Filter</a>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="tab">
            <a href="{{ route('product.report') }}" aria-selected="true">Stok Produk</a>
            <a href="{{ route('account.report') }}" aria-selected="true" class="selected">Akun</a>
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
        <table class="w-full retro">
            <caption class="text-2xl text-black [text-align:unset]">Aktifitas akun pada <b>{{ $item->name }}</b></caption>
            <thead>
                <tr>
                    <th class="text-left">Deskripsi</th>
                    <th class="text-left">Referensi</th>
                    <th class="text-left">Waktu Kejadian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->description }}</td>
                        <td>
                            @php
                                $target_route = '';
                                if ($account->cashflow_type == 'purchase') {
                                    $target_route = route('invoice.edit.form', ['invoiceId' => $account->purchase_invoice_id]);
                                } else if ($account->cashflow_type == 'transaction') {
                                    $target_route = route('transaction.edit.form', ['transactionId' => $account->transaction_id]);
                                } else {
                                    $target_route = '';
                                }
                            @endphp
                            <a href="{{ $target_route }}">
                                @php
                                    if ($account->cashflow_type == 'purchase') {
                                        echo $account->invoice_code;
                                    } else if ($account->cashflow_type == 'transaction') {
                                        echo $account->order_id;
                                    } else {
                                        echo 'Tidak Ada Referensi';
                                    }
                                @endphp
                            </a>
                        </td>
                        <td>
                            @php
                                if ($account->cashflow_type == 'purchase') {
                                    echo date('Y-m-d', strtotime($account->invoice_date));
                                } else if ($account->cashflow_type == 'transaction') {
                                    echo date('Y-m-d', $account->transaction_date);
                                } else {
                                    echo date('Y-m-d', strtotime($account->created_at)); 
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
                @if (count ($accounts) <= 0)
                    <tr>
                        <td colspan="4">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if ($accounts->total() > 0)
            {{ $accounts->appends(request()->except('page'))->links() }}
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
            left: 96%;
            transform: translate(-50%, 0);
            z-index: 30;
        }
    </style>
@endpush