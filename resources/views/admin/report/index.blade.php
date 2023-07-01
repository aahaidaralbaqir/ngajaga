@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Rangkuman Transaksi'])
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="py-6 px-4 md:px-6 xl:px-7.5 flex justify-between items-center">
        <div class="flex justify-between w-full items-center">
            <section x-data="{modalOpen: false}">
                <div x-show="modalOpen" x-transition class="fixed top-0 left-0 z-999999 flex h-full min-h-screen w-full items-center justify-center bg-black/90 px-4 py-5">
                    <div @click.outside="modalOpen = false" class="w-2/3 rounded-lg bg-white  dark:bg-boxdark md:py-5 md:px-5 relative">
                        <form action="{{ route('report.index') }}" method="GET">
                            <div class="w-full flex justify-between">
                                <p class="pb-2 text-xl text-black dark:text-white ">
                                    Saring Data
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
                                        <label for="" class="font-primary text-base font-bold">Jenis Satuan</label>
                                    </div>
                                    <div class="col-span-5">
                                        <select name="unit_id" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="0">Pilih Satuan</option>
                                            @foreach($unit as $item)
                                                @php 
                                                    $selected = $item->id == request('unit_id') ? 'selected' : '';
                                                    if (isset($selected_unit))
                                                        $selected = $item->id == $selected_unit ? 'selected' : '';
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
                                <a href="{{ route('report.index') }}" class="pointer rounded border border-stroke bg-gray p-3 text-center font-medium text-black transition hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1">
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
						Saring Data
						<span class="absolute -top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-meta-1">
							<span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-meta-1 opacity-75"></span>
						</span>
					</a>
				</div>
                
            </section>
			<a href="{{ route('transaction.create.form') }}" class="flex gap-2 items-center justify-center rounded-md bg-primary py-2 px-10 text-white hover:bg-opacity-95">
                <svg class="fill-current" width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.8749 7.44902C16.5374 7.44902 16.228 7.73027 16.228 8.0959V13.3834C16.228 14.4803 15.4124 15.3521 14.3999 15.3521H3.5999C2.55928 15.3521 1.77178 14.4803 1.77178 13.3834V8.06777C1.77178 7.73027 1.49053 7.4209 1.1249 7.4209C0.759277 7.4209 0.478027 7.70215 0.478027 8.06777V13.3553C0.478027 15.1271 1.85615 16.5896 3.57178 16.5896H14.3999C16.1155 16.5896 17.4937 15.1553 17.4937 13.3553V8.06777C17.5218 7.73027 17.2124 7.44902 16.8749 7.44902Z" fill=""></path>
                    <path d="M8.5498 11.6396C8.6623 11.7521 8.83105 11.8365 8.9998 11.8365C9.16855 11.8365 9.30918 11.7803 9.4498 11.6396L12.8811 8.23652C13.1342 7.9834 13.1342 7.58965 12.8811 7.33652C12.6279 7.0834 12.2342 7.0834 11.9811 7.33652L9.64668 9.64277V2.16152C9.64668 1.82402 9.36543 1.51465 8.9998 1.51465C8.6623 1.51465 8.35293 1.7959 8.35293 2.16152V9.69902L6.01855 7.36465C5.76543 7.11152 5.37168 7.11152 5.11855 7.36465C4.86543 7.61777 4.86543 8.01152 5.11855 8.26465L8.5498 11.6396Z" fill=""></path>
                </svg>
                Unduh Laporan
            </a>
        </div>
    </div>
    <div
        class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Jenis Dana</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Uang Masuk</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Total Transaksi Masuk</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Uang Keluar</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Total Transaksi Keluar</p>
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
        <div class="col-span-1 flex items-center">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <p class="font-medium text-sm text-black dark:text-white">{{ $item->name; }}</p>
            </div>
        </div>
        <div class="col-span-1 flex items-center gap-4 flex-wrap">
            <p class="font-medium text-sm text-black dark:text-white">{{ \App\Util\Common::formatAmount($item->unit_name, $item->transaction_in); }}</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">{{ $item->transaction_total_in; }}</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium text-sm text-black dark:text-white">{{  \App\Util\Common::formatAmount($item->unit_name, $item->transaction_out); }}</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">{{ $item->transaction_total_out; }}</p>
        </div>
    </div>
    @endforeach
    
    </div>
</div>
@endsection