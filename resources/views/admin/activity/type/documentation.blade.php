@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Dokumentasi Kegiatan'])
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div x-data="{popupOpen: false}" class="py-6 px-4 md:px-6 xl:px-7.5 flex justify-end items-center">
		<a @click.prevent="popupOpen = true" class="flex items-center justify-center rounded-md bg-primary py-2 px-10 text-white hover:bg-opacity-95">Tambah Gambar</a>
		<div x-show="popupOpen" x-transition="" class="fixed top-0 left-0 z-99999 flex h-screen w-full justify-center overflow-y-scroll bg-black/80 py-5 px-4">
			<div @click.outside="popupOpen = false" class="relative m-auto w-full max-w-180 rounded-sm border border-stroke bg-gray p-4 shadow-default dark:border-strokedark dark:bg-meta-4 sm:p-8 xl:p-10">
			  <button @click="popupOpen = false" class="absolute right-1 top-1 sm:right-5 sm:top-5">
				<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				  <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z" fill=""></path>
				</svg>
			  </button>
			 	{{ Form::open(['route' => 'activity.type.documentation.upload', 'method' => 'POST', 'enctype' => 'multipart/form-data']); }}
				<div class="mb-5">
					<input type="hidden" name="activity_id" value="{{ $activity_id }}">
					<label for="taskImg" class="mb-2.5 block font-medium text-black dark:text-white">Add image</label>
					<div x-data="{ files: null }">
						<div id="FileUpload" class="relative block w-full appearance-none rounded-sm border border-dashed border-stroke bg-white py-4 px-4 dark:border-strokedark dark:bg-boxdark sm:py-14">
						<input type="file"  name="image" accept="image/*" class="absolute inset-0 z-50 m-0 h-full w-full p-0 opacity-0 outline-none" x-on:change="files = $event.target.files;" x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')">
						<div class="flex flex-col items-center justify-center space-y-3">
							<span class="flex h-11.5 w-11.5 items-center justify-center rounded-full border border-stroke bg-primary/5 dark:border-strokedark">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_75_12841)">
								<path d="M2.5 15.8333H17.5V17.5H2.5V15.8333ZM10.8333 4.85663V14.1666H9.16667V4.85663L4.1075 9.91663L2.92917 8.73829L10 1.66663L17.0708 8.73746L15.8925 9.91579L10.8333 4.85829V4.85663Z" fill="#3C50E0"></path>
								</g>
								<defs>
								<clipPath id="clip0_75_12841">
									<rect width="20" height="20" fill="white"></rect>
								</clipPath>
								</defs>
							</svg>
							</span>
							<p class="text-xs">
							<span class="text-primary">Click to upload</span> or drag and
							drop
							</p>
						</div>
						</div>
			
						<template x-if="files !== null">
						<div class="mt-4.5 border border-stroke bg-white py-3 px-4 dark:border-strokedark dark:bg-boxdark">
							<div class="flex items-center justify-between">
							<template x-for="(_,index) in Array.from({ length: files.length })">
								<span x-text="files[index].name">Uploading</span>
							</template>
			
							<button @click="files = null">
								<svg class="fill-current" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z" fill=""></path>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z" fill=""></path>
								</svg>
							</button>
							</div>
						</div>
						</template>
					</div>
				</div>
				<button class="flex w-full items-center justify-center gap-2 rounded bg-primary py-2.5 px-4.5 font-medium text-white">
				<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_60_9740)">
					<path d="M18.75 9.3125H10.7187V1.25C10.7187 0.875 10.4062 0.53125 10 0.53125C9.625 0.53125 9.28125 0.84375 9.28125 1.25V9.3125H1.25C0.875 9.3125 0.53125 9.625 0.53125 10.0312C0.53125 10.4062 0.84375 10.75 1.25 10.75H9.3125V18.75C9.3125 19.125 9.625 19.4687 10.0312 19.4687C10.4062 19.4687 10.75 19.1562 10.75 18.75V10.7187H18.75C19.125 10.7187 19.4687 10.4062 19.4687 10C19.4687 9.625 19.125 9.3125 18.75 9.3125Z" fill=""></path>
					</g>
					<defs>
					<clipPath id="clip0_60_9740">
						<rect width="20" height="20" fill="white"></rect>
					</clipPath>
					</defs>
				</svg>
				Unggah Gambar
				</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
    
    <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-3 flex items-center">
        <p class="font-medium">Gambar</p>
        </div>
        <div class="col-span-1 flex items-center">
        <p class="font-medium">Aksi</p>
        </div>
    </div>
    @if (count($documentation) == 0)
        <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-6 text-center">
                Tidak ada data
            </div> 
        </div>
    @endif 
    @foreach($documentation as $item)
        <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-3 flex items-center" x-data="{showModal: false, image: '{{ $item->image }}'}">
				<div class="flex flex-col gap-4 sm:flex-row sm:items-center cursor-pointer" @click="showModal = true">
					<div class="h-12.5 w-15 rounded-md overflow-hidden">
					<img src="{{ $item->image }}" alt="Gambar" />
					</div>
				</div>
				<div x-show="showModal" x-transition="" class="fixed top-0 left-0 z-99999 flex h-screen w-full justify-center overflow-y-scroll bg-black/80 py-5 px-4">
					<div @click.outside="showModal = false" class="relative m-auto w-full max-w-180 rounded-sm border border-stroke bg-gray p-4 shadow-default dark:border-strokedark dark:bg-meta-4 sm:p-8 xl:p-10">
					  <button @click="showModal = false" class="absolute right-1 top-1 sm:right-5 sm:top-5">
						<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						  <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z" fill=""></path>
						</svg>
					  </button>
						<div class="mb-5 overflow-hidden mt-5">
							<img :src="image" alt="Cover">	
						</div>
						
					</div>
				</div>
            </div>
            <div class="flex items-center space-x-3.5">
				<div x-data="{openDropDown: false}" class="relative">
                    <button @click="openDropDown = !openDropDown">
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.25 11.25C3.49264 11.25 4.5 10.2426 4.5 9C4.5 7.75736 3.49264 6.75 2.25 6.75C1.00736 6.75 0 7.75736 0 9C0 10.2426 1.00736 11.25 2.25 11.25Z" fill="#98A6AD"></path>
                        <path d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z" fill="#98A6AD"></path>
                        <path d="M15.75 11.25C16.9926 11.25 18 10.2426 18 9C18 7.75736 16.9926 6.75 15.75 6.75C14.5074 6.75 13.5 7.75736 13.5 9C13.5 10.2426 14.5074 11.25 15.75 11.25Z" fill="#98A6AD"></path>
                      </svg>
                    </button>
                    <div x-show="openDropDown" @click.outside="openDropDown = false" class="absolute right-0 top-full z-40 w-60 space-y-1 rounded-sm border border-stroke bg-white p-1.5 shadow-default dark:border-strokedark dark:bg-boxdark">
						<a href="{{ route('activity.type.documentation.delete', ['id' => $item['id']]) }}" class="flex w-full items-center gap-2 rounded-sm py-1.5 px-4 text-left text-sm hover:bg-gray dark:hover:bg-meta-4">
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
							Hapus Gambar	
						</a>
                    </div>
                  </div>
                </div>
        </div>
    @endforeach
    
    </div>
</div>
@endsection