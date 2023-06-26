@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Rangkuman Transaksi'])
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Jenis Dana</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Uang Masuk</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Uang Keluar</p>
        </div>
    </div>
    @if(count($reports) == 0)
        <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-6 text-center">
                Tidak ada data
            </div> 
        </div>
    @endif
    @foreach($reports as $item)
    <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-2 flex items-center">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <p class="font-medium text-sm text-black dark:text-white">{{ $item->name; }}</p>
            </div>
        </div>
        <div class="col-span-2 flex items-center gap-4 flex-wrap">
            <p class="font-medium text-sm text-black dark:text-white">{{ $item->transaction_in; }}</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium text-sm text-black dark:text-white">{{ $item->transaction_out; }}</p>
        </div>
    </div>
    @endforeach
    
    </div>
</div>
@endsection