@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Distribusi Dana'])
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark" >
    <div class="py-6 px-4 md:px-6 xl:px-7.5 flex justify-between items-center">
        <div x-data="{openDropDown: false}" class="relative inline-block">
            <a href="#" @click.prevent="openDropDown = !openDropDown" class="flex items-center justify-center rounded-md bg-[#f6f6f6] py-2 px-10 text-[#212B36] hover:bg-opacity-95">
              Aksi Tambahan
              <svg class="fill-current duration-200 ease-linear ml-2" :class="openDropDown && 'rotate-180'" width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.564864 0.879232C0.564864 0.808624 0.600168 0.720364 0.653125 0.667408C0.776689 0.543843 0.970861 0.543844 1.09443 0.649756L5.82517 5.09807C5.91343 5.18633 6.07229 5.18633 6.17821 5.09807L10.9089 0.649756C11.0325 0.526192 11.2267 0.543844 11.3502 0.667408C11.4738 0.790972 11.4562 0.985145 11.3326 1.10871L6.60185 5.55702C6.26647 5.85711 5.73691 5.85711 5.41917 5.55702L0.670776 1.10871C0.600168 1.0381 0.564864 0.967492 0.564864 0.879232Z" fill=""></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.4719 0.229332L6.00169 4.48868L10.5171 0.24288C10.9015 -0.133119 11.4504 -0.0312785 11.7497 0.267983C12.1344 0.652758 12.0332 1.2069 11.732 1.50812L11.7197 1.52041L6.97862 5.9781C6.43509 6.46442 5.57339 6.47872 5.03222 5.96853C5.03192 5.96825 5.03252 5.96881 5.03222 5.96853L0.271144 1.50833C0.123314 1.3605 -5.04223e-08 1.15353 -3.84322e-08 0.879226C-2.88721e-08 0.660517 0.0936127 0.428074 0.253705 0.267982C0.593641 -0.0719548 1.12269 -0.0699964 1.46204 0.220873L1.4719 0.229332ZM5.41917 5.55702C5.73691 5.85711 6.26647 5.85711 6.60185 5.55702L11.3326 1.10871C11.4562 0.985145 11.4738 0.790972 11.3502 0.667408C11.2267 0.543844 11.0325 0.526192 10.9089 0.649756L6.17821 5.09807C6.07229 5.18633 5.91343 5.18633 5.82517 5.09807L1.09443 0.649756C0.970861 0.543844 0.776689 0.543843 0.653125 0.667408C0.600168 0.720364 0.564864 0.808624 0.564864 0.879232C0.564864 0.967492 0.600168 1.0381 0.670776 1.10871L5.41917 5.55702Z" fill=""></path>
              </svg>
            </a>
            <div x-show="openDropDown" @click.outside="openDropDown = false" class="absolute left-0 top-full z-40 mt-2 w-full rounded-md border border-stroke bg-white py-3 shadow-card dark:border-strokedark dark:bg-boxdark" style="">
              <ul class="flex flex-col">
                <li class="group relative inline-block">
                  <a href="{{ route('transaction.sample') }}" class="flex py-2 px-5 font-medium hover:bg-whiter hover:text-primary dark:hover:bg-meta-4">
                    Download Template
                  </a>
                  <div class="absolute bottom-full left-1/2 z-20 mb-3 -translate-x-1/2 whitespace-nowrap rounded bg-black py-1.5 px-4.5 text-sm font-medium text-white opacity-0 group-hover:opacity-100">
                    <span class="absolute bottom-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45 rounded-sm bg-black"></span>
                    Unduh contoh file yg digunakan penyisipan transaksi secara masal
                  </div>
                </li>
                <li>
                  <a href="#" class="flex py-2 px-5 font-medium hover:bg-whiter hover:text-primary dark:hover:bg-meta-4">
                    Sisipkan Transaksi
                  </a>
                </li>
                <li>
                  <a href="#" class="flex py-2 px-5 font-medium hover:bg-whiter hover:text-primary dark:hover:bg-meta-4">
                    Unduh Laporan (PDF)  
                  </a>
                </li>
              </ul>
            </div>
        </div>
        <div class="flex">
            <section x-data="{modalOpen: false}">
                <div x-show="modalOpen" x-transition class="fixed top-0 left-0 z-999999 flex h-full min-h-screen w-full items-center justify-center bg-black/90 px-4 py-5">
                    <div @click.outside="modalOpen = false" class="w-2/3 rounded-lg bg-white  dark:bg-boxdark md:py-5 md:px-5 relative">
                        <form action="{{ route('distribution.index') }}" method="GET">
                            <div class="w-full flex justify-between">
                                <p class="pb-2 text-xl text-black dark:text-white ">
                                    Pencarian Transaksi
                                </p>
                                <button @click.prevent="modalOpen = false" class="absolute right-1 top-1 sm:right-5 sm:top-5">
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z" fill=""></path>
                                    </svg>
                                  </button>
                            </div>
                            
                            <div class="w-full px-20 py-10">
                                <div class="grid grid-cols-6 gap-2">
                                    <div class="col-span-1 flex flex-col-reverse">
                                        <label for="" class="font-primary text-base font-bold">Waktu Transaksi</label>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                            Dari
                                            </label>
                                        <input type="date" name="transaction_start" value="{{ request('transaction_start') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                        @error('transaction_start')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                            Sampai
                                            </label>
                                        <input type="date" name="transaction_end" value="{{ request('transaction_end') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                        @error('transaction_end')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 mt-5">
                                    <div class="col-span-1 flex flex-col-reverse">
                                        <label for="" class="font-primary text-base font-bold">Nominal</label>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                            Dari
                                            </label>
                                            <input type="number" name="nominal_start" value="{{ request('nominal_start') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            @error('nominal_start')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                                            Sampai
                                            </label>
                                        <input type="number" name="nominal_end" value="{{ request('nominal_end') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                        @error('nominal_end')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-2 mt-5">
                                    <div class="col-span-1 flex flex-col-reverse">
                                        <label for="" class="font-primary text-base font-bold">ID Pesanan</label>
                                    </div>
                                    <div class="col-span-5">
                                        <input type=text" name="order_id" value="{{ old('start_time') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                        @error('order_id')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                               
                                <div class="grid grid-cols-6 gap-2 mt-5">
                                    <div class="col-span-1 flex flex-col-reverse">
                                        <label for="" class="font-primary text-base font-bold">Status Transaksi</label>
                                    </div>
                                    <div class="col-span-5">
                                        <select name="transaction_status" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="0">Pilih Status Transaksi</option>
                                            @foreach($transaction_statuses as $transaction_id => $transaction_name)
                                                @php
													if (!in_array($transaction_id, [\App\Constant\Constant::TRANSACTION_DISTRIBUTED, \App\Constant\Constant::TRANSACTION_REQUESTED])) continue;
                                                    $selected = $transaction_id == request('transaction_status') ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $transaction_id }}" {{ $selected }}  >{{ $transaction_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('transaction_status')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

								<div class="grid grid-cols-6 gap-2 mt-5">
                                    <div class="col-span-1 flex flex-col-reverse">
                                        <label for="" class="font-primary text-base font-bold">Penerima Dana</label>
                                    </div>
                                    <div class="col-span-5">
                                        <select name="id_beneficiary" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="0">Pilih Jenis Penerima Dana </option>
                                            @foreach($beneficiary as $each_beneficiary)
                                                @php
                                                    $selected = $each_beneficiary->id == request('id_beneficiary') ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $each_beneficiary->id }}" {{ $selected }}  >{{ $each_beneficiary->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_beneficiary')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                
                                <div class="grid grid-cols-6 gap-2 mt-5">
                                    <div class="col-span-1 flex flex-col-reverse">
                                        <label for="" class="font-primary text-base font-bold">Jenis Transaksi</label>
                                    </div>
                                    <div class="col-span-5">
                                        <select name="transaction_type" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="0">Pilih Jenis Transaksi</option>
                                            @foreach($transaction_type as $item)
                                                @php 
                                                    $selected = $item->id == request('transaction_type') ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $item->id }}" {{ $selected }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('transaction_type')
                                            <span class="text-sm text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="-mx-3 flex flex-wrap gap-y-4">
                                <div class="w-full px-3 flex justify-end gap-2">
                                <a href="{{ route('distribution.index') }}" class="pointer rounded border border-stroke bg-gray p-3 text-center font-medium text-black transition hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1">
                                    Clear Filter
                                </a>
                                <button type="submit" class="rounded border border-primary bg-primary p-3 text-center font-medium text-white transition hover:bg-opacity-90 btn-search">
                                    Pencarian
                                </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
				<div class="flex gap-5 justify-center items-center">
					<a href="#" class="relative" @click.prevent="modalOpen = true">
						Pencarian
						<span class="absolute -top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-meta-1">
							<span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-meta-1 opacity-75"></span>
						</span>
					</a>
					@if(in_array(App\Constant\Permission::CAN_CREATE_DISTRIBUTION, $permissions))
						<a href="{{ route('distribution.create.form') }}" class="flex items-center justify-center rounded-md bg-primary py-2 px-10 text-white hover:bg-opacity-95">Buat transaksi</a>
					@endif
				</div>
                
            </section>
            
        </div>
    </div>
    
    <div
        class="grid grid-cols-8  bg-[#f6f6f6] py-4.5 px-4 sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Jenis pembayaran</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Jenis Transaksi</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Tanggal & Waktu</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">ID Pesanan</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Penerima Dana</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Jumlah</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Status</p>
        </div>
		@if(in_array(App\Constant\Permission::CAN_CREATE_DISTRIBUTION, $permissions) || in_array(App\Constant\Permission::CAN_UPDATE_DISTRIBUTION, $permissions))
		<div class="col-span-1 flex items-center">
            <p class="font-medium">Aksi</p>
        </div>
		@endif
    </div>
    @if(count($transaction) == 0)
        <div class="grid grid-cols-8 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-8 text-center">
                Tidak ada data
            </div> 
        </div>
    @endif
    @foreach($transaction as $item)
    <div class="grid grid-cols-8 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-1 flex items-center">
            <p class="font-medium text-sm text-black dark:text-white">
                {{ $item->payment_name }}
            </p> 
        </div>
        <div class="col-span-1 flex items-center">
            <p class="text-sm text-black dark:text-white">
                {{ $item->transaction_type }}
            </p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="text-sm text-black dark:text-white">
                {{ $item->created_at }}
            </p> 
        </div>
        <div class="col-span-1 flex items-center">
            <a href="" class="font-medium text-sm text-black dark:text-white border-b border-stroke">
                {{  \App\Util\Common::trimWord($item->order_id, 16) }}
            </a>  
        </div>
        <div class="col-span-1 flex items-center">
            <p class="text-sm text-black dark:text-white">
                {{  \App\Util\Common::trimWord($item->beneficiary_name, 10) }}
            </p>   
        </div>
		
        <div class="col-span-1 flex items-center">
            <p class="text-sm text-black dark:text-white">
                {{  \App\Util\Common::formatAmount($item->unit_name, $item->paid_amount * -1, 16) }}
            </p> 
        </div>
        <div class="col-span-1 flex items-center space-x-3.5">
            <button class="{{  \App\Util\Transaction::getClassByTransactionStatus($item->transaction_status) }}">
                {{  \App\Util\Transaction::getTransactionNameByTransactionStatus($item->transaction_status) }}
            </button>
        </div>
		@if(in_array(App\Constant\Permission::CAN_UPDATE_DISTRIBUTION, $permissions))
		<div class="col-span-1 flex items-center">
			<div x-data="{openDropDown: false}" class="relative">
				<button @click.prevent="openDropDown = !openDropDown">
				  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M2.25 11.25C3.49264 11.25 4.5 10.2426 4.5 9C4.5 7.75736 3.49264 6.75 2.25 6.75C1.00736 6.75 0 7.75736 0 9C0 10.2426 1.00736 11.25 2.25 11.25Z" fill="#98A6AD"></path>
					<path d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z" fill="#98A6AD"></path>
					<path d="M15.75 11.25C16.9926 11.25 18 10.2426 18 9C18 7.75736 16.9926 6.75 15.75 6.75C14.5074 6.75 13.5 7.75736 13.5 9C13.5 10.2426 14.5074 11.25 15.75 11.25Z" fill="#98A6AD"></path>
				  </svg>
				</button>
				<div x-show="openDropDown" @click.outside="openDropDown = false" class="absolute right-0 top-full z-40 w-50 space-y-1 rounded-sm border border-stroke bg-white p-1.5 shadow-default dark:border-strokedark dark:bg-boxdark">
					@if(in_array(App\Constant\Permission::CAN_UPDATE_DISTRIBUTION, $permissions))
					<a href="{{ route('distribution.update.form', ['transactionId' => $item->order_id]) }}" class="flex w-full items-center gap-2 rounded-sm py-1.5 px-4 text-left text-sm hover:bg-gray dark:hover:bg-meta-4">
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
						Edit
					</a>
				  @endif
				 	@if ($item->transaction_status == \App\Constant\Constant::TRANSACTION_REQUESTED && in_array(\App\Constant\Permission::CAN_APPROVE_TRANSACTION, $permissions))
						<a href="{{ route('transaction.admin.approve', ['transactionId' => $item->order_id]) }}" class="flex w-full items-center gap-2 rounded-sm py-1.5 px-4 text-left text-sm hover:bg-gray dark:hover:bg-meta-4">
							<svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12.225 2.20005H10.3V1.77505C10.3 1.02505 9.70005 0.425049 8.95005 0.425049H7.02505C6.27505 0.425049 5.67505 1.02505 5.67505 1.77505V2.20005H3.75005C3.02505 2.20005 2.42505 2.80005 2.42505 3.52505V4.27505C2.42505 4.82505 2.75005 5.27505 3.22505 5.47505L3.62505 13.75C3.67505 14.775 4.52505 15.575 5.55005 15.575H10.4C11.425 15.575 12.275 14.775 12.325 13.75L12.75 5.45005C13.225 5.25005 13.55 4.77505 13.55 4.25005V3.50005C13.55 2.80005 12.95 2.20005 12.225 2.20005ZM6.82505 1.77505C6.82505 1.65005 6.92505 1.55005 7.05005 1.55005H8.97505C9.10005 1.55005 9.20005 1.65005 9.20005 1.77505V2.20005H6.85005V1.77505H6.82505ZM3.57505 3.52505C3.57505 3.42505 3.65005 3.32505 3.77505 3.32505H12.225C12.325 3.32505 12.425 3.40005 12.425 3.52505V4.27505C12.425 4.37505 12.35 4.47505 12.225 4.47505H3.77505C3.67505 4.47505 3.57505 4.40005 3.57505 4.27505V3.52505V3.52505ZM10.425 14.45H5.57505C5.15005 14.45 4.80005 14.125 4.77505 13.675L4.40005 5.57505H11.625L11.25 13.675C11.2 14.1 10.85 14.45 10.425 14.45Z" fill=""></path>
								<path d="M8.00005 8.1001C7.70005 8.1001 7.42505 8.3501 7.42505 8.6751V11.8501C7.42505 12.1501 7.67505 12.4251 8.00005 12.4251C8.30005 12.4251 8.57505 12.1751 8.57505 11.8501V8.6751C8.57505 8.3501 8.30005 8.1001 8.00005 8.1001Z" fill=""></path>
								<path d="M9.99994 8.60004C9.67494 8.57504 9.42494 8.80004 9.39994 9.12504L9.24994 11.325C9.22494 11.625 9.44994 11.9 9.77494 11.925C9.79994 11.925 9.79994 11.925 9.82494 11.925C10.1249 11.925 10.3749 11.7 10.3749 11.4L10.5249 9.20004C10.5249 8.87504 10.2999 8.62504 9.99994 8.60004Z" fill=""></path>
								<path d="M5.97497 8.60004C5.67497 8.62504 5.42497 8.90004 5.44997 9.20004L5.62497 11.4C5.64997 11.7 5.89997 11.925 6.17497 11.925C6.19997 11.925 6.19997 11.925 6.22497 11.925C6.52497 11.9 6.77497 11.625 6.74997 11.325L6.57497 9.12504C6.57497 8.80004 6.29997 8.57504 5.97497 8.60004Z" fill=""></path>
							</svg>
							Approve
						</a>
					@endif
					@if ($item->transaction_status == \App\Constant\Constant::TRANSACTION_REQUESTED && in_array(\App\Constant\Permission::CAN_MANAGE_TRANSACTION_PROOF, $permissions))
						<a href="{{ route('transaction.proof.form', ['transactionId' => $item->order_id]) }}" class="flex w-full items-center gap-2 rounded-sm py-1.5 px-4 text-left text-sm hover:bg-gray dark:hover:bg-meta-4">
							<svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12.225 2.20005H10.3V1.77505C10.3 1.02505 9.70005 0.425049 8.95005 0.425049H7.02505C6.27505 0.425049 5.67505 1.02505 5.67505 1.77505V2.20005H3.75005C3.02505 2.20005 2.42505 2.80005 2.42505 3.52505V4.27505C2.42505 4.82505 2.75005 5.27505 3.22505 5.47505L3.62505 13.75C3.67505 14.775 4.52505 15.575 5.55005 15.575H10.4C11.425 15.575 12.275 14.775 12.325 13.75L12.75 5.45005C13.225 5.25005 13.55 4.77505 13.55 4.25005V3.50005C13.55 2.80005 12.95 2.20005 12.225 2.20005ZM6.82505 1.77505C6.82505 1.65005 6.92505 1.55005 7.05005 1.55005H8.97505C9.10005 1.55005 9.20005 1.65005 9.20005 1.77505V2.20005H6.85005V1.77505H6.82505ZM3.57505 3.52505C3.57505 3.42505 3.65005 3.32505 3.77505 3.32505H12.225C12.325 3.32505 12.425 3.40005 12.425 3.52505V4.27505C12.425 4.37505 12.35 4.47505 12.225 4.47505H3.77505C3.67505 4.47505 3.57505 4.40005 3.57505 4.27505V3.52505V3.52505ZM10.425 14.45H5.57505C5.15005 14.45 4.80005 14.125 4.77505 13.675L4.40005 5.57505H11.625L11.25 13.675C11.2 14.1 10.85 14.45 10.425 14.45Z" fill=""></path>
								<path d="M8.00005 8.1001C7.70005 8.1001 7.42505 8.3501 7.42505 8.6751V11.8501C7.42505 12.1501 7.67505 12.4251 8.00005 12.4251C8.30005 12.4251 8.57505 12.1751 8.57505 11.8501V8.6751C8.57505 8.3501 8.30005 8.1001 8.00005 8.1001Z" fill=""></path>
								<path d="M9.99994 8.60004C9.67494 8.57504 9.42494 8.80004 9.39994 9.12504L9.24994 11.325C9.22494 11.625 9.44994 11.9 9.77494 11.925C9.79994 11.925 9.79994 11.925 9.82494 11.925C10.1249 11.925 10.3749 11.7 10.3749 11.4L10.5249 9.20004C10.5249 8.87504 10.2999 8.62504 9.99994 8.60004Z" fill=""></path>
								<path d="M5.97497 8.60004C5.67497 8.62504 5.42497 8.90004 5.44997 9.20004L5.62497 11.4C5.64997 11.7 5.89997 11.925 6.17497 11.925C6.19997 11.925 6.19997 11.925 6.22497 11.925C6.52497 11.9 6.77497 11.625 6.74997 11.325L6.57497 9.12504C6.57497 8.80004 6.29997 8.57504 5.97497 8.60004Z" fill=""></path>
							</svg>
							Bukti pembayaran
						</a>
					@endif
				</div>
			  </div>
		</div>
		@endif
    </div>
    @endforeach
    </div>
    
</div>
@endsection

@push('scripts')
@endpush