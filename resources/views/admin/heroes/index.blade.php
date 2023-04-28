@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="py-6 px-4 md:px-6 xl:px-7.5 flex justify-between items-center">
        <h4 class="text-xl font-bold text-black dark:text-white">
        List Heroes
        </h4>
        <a href="{{ route('heroes.create') }}" class="flex items-center justify-center bg-primary p-2 text-white hover:bg-opacity-95">Add banner</a>
    </div>
    
    <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-3 flex items-center">
        <p class="font-medium">Title</p>
        </div>
        <div class="col-span-2 hidden items-center sm:flex">
        <p class="font-medium">Subtitle</p>
        </div>
        <div class="col-span-1 flex items-center">
        <p class="font-medium">Link</p>
        </div>
        <div class="col-span-1 flex items-center">
        <p class="font-medium">Action</p>
        </div>
    </div>
    @empty($heroes)
        <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-7 text-center">
                Tidak ada data
            </div> 
        </div>
    @endempty
    @foreach($heroes as $item)
        <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-3 flex items-center">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="h-12.5 w-15 rounded-md">
                <img src="{{ get_banner($item['image']) }}" alt="Product" />
                </div>
                <p class="font-medium text-sm text-black dark:text-white">{{ $item['title']; }}</p>
            </div>
            </div>
            <div class="col-span-2 hidden items-center sm:flex">
            <p class="font-medium text-sm text-black dark:text-white">{{ $item['subtitle']; }}</p>
            </div>
            <div class="col-span-1 flex items-center">
            <p class="font-medium text-sm text-black dark:text-white">
                <a href="{{ $item['link'] }}" class="text-primary" target="__blank">Tautan</a>
            </p>
            </div>
            <div class="flex items-center space-x-3.5">
                <button class="hover:text-primary">
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.8" clip-path="url(#clip0_88_10224)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M1.56524 3.23223C2.03408 2.76339 2.66997 2.5 3.33301 2.5H9.16634C9.62658 2.5 9.99967 2.8731 9.99967 3.33333C9.99967 3.79357 9.62658 4.16667 9.16634 4.16667H3.33301C3.11199 4.16667 2.90003 4.25446 2.74375 4.41074C2.58747 4.56702 2.49967 4.77899 2.49967 5V16.6667C2.49967 16.8877 2.58747 17.0996 2.74375 17.2559C2.90003 17.4122 3.11199 17.5 3.33301 17.5H14.9997C15.2207 17.5 15.4326 17.4122 15.5889 17.2559C15.7452 17.0996 15.833 16.8877 15.833 16.6667V10.8333C15.833 10.3731 16.2061 10 16.6663 10C17.1266 10 17.4997 10.3731 17.4997 10.8333V16.6667C17.4997 17.3297 17.2363 17.9656 16.7674 18.4344C16.2986 18.9033 15.6627 19.1667 14.9997 19.1667H3.33301C2.66997 19.1667 2.03408 18.9033 1.56524 18.4344C1.0964 17.9656 0.833008 17.3297 0.833008 16.6667V5C0.833008 4.33696 1.0964 3.70107 1.56524 3.23223Z"
                            fill="" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M16.6664 2.39884C16.4185 2.39884 16.1809 2.49729 16.0056 2.67253L8.25216 10.426L7.81167 12.188L9.57365 11.7475L17.3271 3.99402C17.5023 3.81878 17.6008 3.5811 17.6008 3.33328C17.6008 3.08545 17.5023 2.84777 17.3271 2.67253C17.1519 2.49729 16.9142 2.39884 16.6664 2.39884ZM14.8271 1.49402C15.3149 1.00622 15.9765 0.732178 16.6664 0.732178C17.3562 0.732178 18.0178 1.00622 18.5056 1.49402C18.9934 1.98182 19.2675 2.64342 19.2675 3.33328C19.2675 4.02313 18.9934 4.68473 18.5056 5.17253L10.5889 13.0892C10.4821 13.196 10.3483 13.2718 10.2018 13.3084L6.86847 14.1417C6.58449 14.2127 6.28409 14.1295 6.0771 13.9225C5.87012 13.7156 5.78691 13.4151 5.85791 13.1312L6.69124 9.79783C6.72787 9.65131 6.80364 9.51749 6.91044 9.41069L14.8271 1.49402Z"
                            fill="" />
                        </g>
                        <defs>
                        <clipPath id="clip0_88_10224">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                        </defs>
                    </svg>
                </button>
                <button class="hover:text-primary">
                    <svg
                        width="20"
                        height="20"
                        class="fill-current"
                        viewBox="0 0 20 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                        fill=""
                        />
                    </svg>
                </button>
                <button class="hover:text-primary">
                    <svg
                        width="20"
                        height="20"
                        class="fill-current rotate-180"
                        viewBox="0 0 20 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                        fill=""
                        />
                    </svg>
                </button>
                </div>
        </div>
    @endforeach
    
    </div>
</div>
@endsection