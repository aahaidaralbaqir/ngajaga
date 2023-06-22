@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Transaksi'])
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
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
                  <a href="#" class="flex py-2 px-5 font-medium hover:bg-whiter hover:text-primary dark:hover:bg-meta-4">
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
            <a href="#" class="relative" @click.prevent="modalOpen = true">
                Pencarian
                <span class="absolute -top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-meta-1">
                    <span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-meta-1 opacity-75"></span>
                </span>
            </a>
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
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Email</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Jumlah</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Status</p>
        </div>
    </div>
    @empty($transaction)
        <div class="grid grid-cols-8 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <div class="col-span-8 text-center">
                Tidak ada data
            </div> 
        </div>
    @endempty
    @foreach($transaction as $item)
    <div class="grid grid-cols-8 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-1 flex items-center">
            <p class="font-medium text-sm text-black dark:text-white">
                {{ $item->payment->name }}
            </p> 
        </div>
        <div class="col-span-1 flex items-center">
            <p class="text-sm text-black dark:text-white">
                {{ $item->type->name }}
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
        <div class="col-span-2 flex items-center">
            <p class="text-sm text-black dark:text-white">
                {{ $item->customer->email }}
            </p>   
        </div>
        <div class="col-span-1 flex items-center">
            <p class="text-sm text-black dark:text-white">
                {{  \App\Util\Common::formatRupiah($item->paid_amount, 16) }}
            </p> 
        </div>
        <div class="col-span-1 flex items-center space-x-3.5">
            <button class="{{  \App\Util\Transaction::getClassByTransactionStatus($item->transaction_status) }}">
                {{  \App\Util\Transaction::getTransactionNameByTransactionStatus($item->transaction_status) }}
            </button>
        </div>
    </div>
    @endforeach
    </div>

    <div class="fixed top-0 left-0 z-999999 flex h-full min-h-screen w-full items-center justify-center bg-black/90 px-4 py-5">
        <div @click.outside="modalOpen = false" class="w-full w-4/5 rounded-lg bg-white  dark:bg-boxdark md:py-5 md:px-5">
          <p class="pb-2 text-xl text-black dark:text-white ">
            Pencarian Transaksi
          </p>
          <div class="w-full px-36 py-10">
            <div class="grid grid-cols-6 gap-2">
                <div class="col-span-1">
                    <label for="" class="font-primary text-base font-bold">Waktu Transaksi</label>
                </div>
                <div class="col-span-2">
                    <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                        Dari
                        </label>
                    <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    @error('start_time')
                        <span class="text-sm text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                        Sampai
                        </label>
                    <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    @error('start_time')
                        <span class="text-sm text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 mt-5">
                <div class="col-span-1">
                    <label for="" class="font-primary text-base font-bold">Waktu Settlement</label>
                </div>
                <div class="col-span-2">
                    <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                        Dari
                        </label>
                    <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    @error('start_time')
                        <span class="text-sm text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                        Sampai
                        </label>
                    <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    @error('start_time')
                        <span class="text-sm text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-6 gap-2 mt-5">
                <div class="col-span-1 flex flex-column align-end">
                    <label for="" class="font-primary text-base font-bold">ID Pesanan</label>
                </div>
                <div class="col-span-5">
                    <input type=text" name="start_time" value="{{ old('start_time') }}" class="custom-input-date custom-input-date-2 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    @error('start_time')
                        <span class="text-sm text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
          </div>
          <div class="-mx-3 flex flex-wrap gap-y-4">
            <div class="w-full px-3 flex justify-end gap-2">
              <button @click="modalOpen = false" class="rounded border border-stroke bg-gray p-3 text-center font-medium text-black transition hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1">
                Clear Filter
              </button>
              <button class="rounded border border-primary bg-primary p-3 text-center font-medium text-white transition hover:bg-opacity-90">
                Pencarian
              </button>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection