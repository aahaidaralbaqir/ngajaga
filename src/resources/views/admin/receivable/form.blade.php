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
                    <a href="{{ route('receivable.index', ['debtId' => empty($item) ? $debt_record->id : $item->debt_id]) }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
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
                <section class="flex gap-2 justify-between">
                    <header class="text-[#000000] font-light flex-1">
                        <p>
                            Informasi Pembayaran Kasbon
                        </p>
                    </header>
                    <fieldset class="w-3/5">
                        @if (!empty($item))
                            <input type="hidden" name="id" value="{{ $item->id }}">
                        @endif
                        <input type="hidden" name="debt_id" value="{{ old('debt_id', empty($item) ? $debt_record->id : $item->debt_id) }}">
                        <div>
                            <legend class="mb-2">
                                <label for="receivable_date" class="text-[#000000] font-light">Tanggal Pembayaran</label>
                            </legend>
                            <input type="date" name="receivable_date" value="{{ old('amount', empty($item) ? '' : $item->receivable_date) }}">
                            @error('receivable_date')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div class="mt-4">
                            <legend class="mb-2">
                                <label for="amount" class="text-[#000000] font-light">Jumlah Hutang</label>
                            </legend>
                            <input type="text" name="amount" value="{{ old('amount', empty($item) ? '' : $item->amount) }}">
                            @error('amount')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror 
                        </div>
                    </fieldset>
                </section>
        </section>
    </main>
{{ Form::close() }}
@endsection