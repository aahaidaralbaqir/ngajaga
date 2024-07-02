@extends('layout.dashboard')
@section('content')
    <div class="second-nav py-8 px-14 w-full">
        <div class="w-4/5">
            <div class="flex justify-between items-center">
                <h1>
                    Informasi Pembayaran Kasbon
                </h1>
                <div class="flex items-center justify-between gap-5 relative">
                    <a href="{{ route('debt.index') }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        Kembali
                    </a>
                    @if (in_array(\App\Constant\Permission::CREATE_RECEIVABLE, $user['permission'])) 
                        <a href="{{ route('receivable.create.form', ['debtId' => $debt_record->id]) }}" class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Buat Pembayaran Kasbon</a>
                    @endif
                </div>
            </div>
            <div class="tab">
                <a href="{{ route('transaction.index') }}" aria-selected="true">Transaksi</a>
                <a href="{{ route('debt.index') }}" aria-selected="true" class="selected">Kasbon</a>
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14">
        <section class="w-4/5">
            <table class="w-full retro">
                <caption class="text-2xl text-black [text-align:unset]">
                    Penerimaan Kasbon
                </caption>
                <thead>
                    <tr>
                        <th class="w-[5%]"></th>
                        <th class="text-left">Total Pembayaran</th>
                        <th class="text-left">Tanggal Pembayaran</th>
                        <th class="text-left">Penerima Pembayaran</th>
                        <th class="w-[5%]"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receivable_records as $receivable)
                        <tr>
                            <td></td>
                            <td>{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $receivable->amount) }}</td>
                            <td>{{ date('Y-m-d', $receivable->receivable_date) }}</td>
                            <td>{{ $receivable->created_by_name }}</td>
                            <td>
                                @if (in_array(\App\Constant\Permission::UPDATE_RECEIVABLE, $user['permission'])) 
                                    <div class="relative">
                                        <a href="" data-id="{{ $receivable->id }}" data-name="action"  class="dropdown" role="dropdown">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                        </a>
                                        <div class="menu hidden " data-id="{{ $receivable->id }}" data-name="action" role="dropdown-content">
                                            <a href="{{ route('receivable.edit.form', ['receivableId' => $receivable->id]) }}" class="menu-item">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                                Ubah
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if (count($receivable_records) < 1)
                    <tr>
                        <td colspan="5">Tidak ada data</td>
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
    </style>
@endpush