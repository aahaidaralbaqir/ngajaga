@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'payment'])
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="py-6 px-4 md:px-6 xl:px-7.5 flex justify-end items-center">
    	<a href="{{ route('payment.create.form') }}" class="flex items-center justify-center rounded-md bg-primary py-2 px-10 text-white hover:bg-opacity-95">Buat baru</a>
    </div>
    
    <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Name</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Expired time</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Status</p>
        </div>
        <div class="col-span-1 flex items-center">
        <p class="font-medium">Aksi</p>
        </div>
    </div>
    @empty($payment)
        <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-6 text-center">
                Tidak ada data
            </div> 
        </div>
    @endempty
    @foreach($payment as $item)
    <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-2 flex items-center">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <img src="{{ $item->payment_logo }}" alt="Product" class="h-15 w-15 rounded-md" />
                <p class="font-medium text-sm text-black dark:text-white">{{ $item['name']; }}</p>
            </div>
        </div>
        <div class="col-span-2 flex items-center">
            <span class="text-sm"> {{  $item['expired_time']; }} </span>
        </div>
        <div class="col-span-2 flex items-center">
            <button 
                class="inline-flex rounded-full {{ $item['status'] == 'Active' ? 'bg-[#13C296]' : 'bg-[#EFEFEF]' }} py-1 px-3 text-sm font-extralight {{ $item['status'] == 'Active' ? 'text-white' : 'text-[#212B36]' }} hover:bg-opacity-90"
            >
                {{ $item['status'] }}
            </button>
        </div>
        <div class="flex items-center space-x-3.5">
            <a
                href="{{ route('payment.update.form', ['paymentId' => $item['id']]) }}"
                class="hover:text-primary">
                <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_62_9787)">
                      <path d="M15.55 2.97499C15.55 2.77499 15.475 2.57499 15.325 2.42499C15.025 2.12499 14.725 1.82499 14.45 1.52499C14.175 1.24999 13.925 0.974987 13.65 0.724987C13.525 0.574987 13.375 0.474986 13.175 0.449986C12.95 0.424986 12.75 0.474986 12.575 0.624987L10.875 2.32499H2.02495C1.17495 2.32499 0.449951 3.02499 0.449951 3.89999V14C0.449951 14.85 1.14995 15.575 2.02495 15.575H12.15C13 15.575 13.725 14.875 13.725 14V5.12499L15.35 3.49999C15.475 3.34999 15.55 3.17499 15.55 2.97499ZM8.19995 8.99999C8.17495 9.02499 8.17495 9.02499 8.14995 9.02499L6.34995 9.62499L6.94995 7.82499C6.94995 7.79999 6.97495 7.79999 6.97495 7.77499L11.475 3.27499L12.725 4.49999L8.19995 8.99999ZM12.575 14C12.575 14.25 12.375 14.45 12.125 14.45H2.02495C1.77495 14.45 1.57495 14.25 1.57495 14V3.87499C1.57495 3.62499 1.77495 3.42499 2.02495 3.42499H9.72495L6.17495 6.99999C6.04995 7.12499 5.92495 7.29999 5.87495 7.49999L4.94995 10.3C4.87495 10.5 4.92495 10.675 5.02495 10.85C5.09995 10.95 5.24995 11.1 5.52495 11.1H5.62495L8.49995 10.15C8.67495 10.1 8.84995 9.97499 8.97495 9.84999L12.575 6.24999V14ZM13.5 3.72499L12.25 2.49999L13.025 1.72499C13.225 1.92499 14.05 2.74999 14.25 2.97499L13.5 3.72499Z" fill=""></path>
                    </g>
                    <defs>
                      <clipPath id="clip0_62_9787">
                        <rect width="16" height="16" fill="white"></rect>
                      </clipPath>
                    </defs>
                </svg>
            </a>
        </div>
    </div>
    @endforeach
    
    </div>
</div>
@endsection