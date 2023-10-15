@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Buletin'])
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="py-6 px-4 md:px-6 xl:px-7.5 flex justify-between items-center">
        <form action="{{ route('post.index') }}" method="GET">
            <div class="relative">
                <button class="absolute top-1/2 left-0 -translate-y-1/2">
                <svg class="fill-body hover:fill-primary dark:fill-bodydark dark:hover:fill-primary" width="20" height="20"
                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                    fill="" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                    fill="" />
                </svg>
                </button>

                <input type="text" name="query" placeholder="Enter untuk mencari.."class="w-full bg-transparent pr-4 pl-9 focus:outline-none" value="{{ request('query') }}" />
            </div>
        </form>
		@if(in_array(App\Constant\Permission::CAN_CREATE_POST, $permissions))
        	<a href="{{ route('post.create') }}" class="flex items-center justify-center rounded-md bg-primary py-2 px-10 text-white hover:bg-opacity-95">Buat buletin baru</a>
		@endif
    </div>
    
    {{-- Table header --}}
    <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-3 flex items-center">
        <p class="font-medium">Judul</p>
        </div>
        <div class="col-span-1 flex items-center">
        <p class="font-medium">Kategori</p>
        </div>
		<div class="col-span-1 flex items-center">
			<p class="font-medium">Status</p>
		</div>
		@if(in_array(App\Constant\Permission::CAN_UPDATE_POST, $permissions))
        <div class="col-span-1 flex items-center">
        <p class="font-medium">Aksi</p>
        </div>
		@endif
    </div>
    {{-- End table header --}}
    {{-- Table body --}}
    @if (count($posts) == 0)
        <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-8 text-center">
                Tidak ada data
            </div> 
        </div>
    @endif
    @foreach($posts as $item)
        <div
            class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-3 flex items-center">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <div class="h-12.5 w-15 rounded-md">
                    <img src="{{ $item['banner'] }}" alt="Product" />
                    </div>
                    <p class="font-medium text-sm text-black dark:text-white">{{ $item['title']; }}</p>
                </div>
            </div>
            <div class="col-span-1 flex items-center">
                <p class="font-medium text-sm text-black dark:text-white">
                    {{  $item['category'] }}
                </p>
            </div>
			<div class="col-span-1 flex items-center">
				@php
					$classes = 'inline-flex rounded border border-[#13C296] py-1 px-2 text-sm font-medium text-[#13C296] hover:opacity-80';
					if ($item['status'] == App\Constant\Constant::STATUS_DRAFT_NAME)
						$classes = 'inline-flex rounded border border-[#212B36] py-1 px-2 text-sm font-medium text-[#212B36] hover:opacity-80 dark:text-white dark:border-white';
				@endphp
				<button class="{{ $classes }}">
					{{  $item['status'] }}
				</button>
            </div>
			@if(in_array(App\Constant\Permission::CAN_UPDATE_POST, $permissions))
            <div class="flex items-center space-x-3.5">
                <a
					href="{{ route('post.update.form', ['postId' => $item['id']]) }}"
					class="hover:text-primary text-center">
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
                </a>
            </div>
			@endif
        </div>
    @endforeach
    {{-- End table body --}}
    {{-- Footer --}}
    @if ($posts->total() > 0)
        <div class="border-t border-stroke py-4.5 px-4 flex dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            {{-- @include('partials.pagination') --}}
            {{ $posts->links() }}
        </div>
    @endif
    {{-- End footer --}}
</div> 
</div>
@endsection