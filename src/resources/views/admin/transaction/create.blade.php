@extends('layout.dashboard')
@section('content')
<main class="w-full py-5 px-10">
    <div class="w-transaction flex justify-between h-full">
        <div class="catalog w-[70%]">
            <div class="category">
            <h3 class="text-2xl text-black">Kategori</h3>
            <div class="tab" style="margin-top: 1rem !important;">
                <a class="{{ $selected_category ? '': 'selected' }}" href="{{ route('transaction.create.form') }}">Semua Produk</a>
                @foreach ($categories as $category)
                    <a 
                        href="{{ route('transaction.create.form', ['cat' => $category->id]) }}"
                        @if ($category->id == $selected_category)
                            class="selected"
                        @endif
                    >
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            </div>
            <div class="product mt-4">
                <div class="w-head flex justify-between items-center">
                    <h3 class="text-2xl text-black">Produk</h3>
                    <div class="relative">
                        <form id="search">
                            <input type="text" style="padding-left: 35px !important;" placeholder="Cari Produk" name="search" value="{{ request()->get('search') }}" />
                            <svg class="h-5 w-5 absolute top-[15px] left-[10px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </form>
                    </div>
                </div>
                <div class="product-list flex mt-2 gap-5 flex-wrap">
                    @foreach ($products as $product)
                        @php
                            $target_route = 'transaction.cart.add';
                            if (array_key_exists($product->id, $orders))
                                $target_route = 'transaction.cart.remove';
                        @endphp
                        {{ Form::open(['route' => $target_route, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <article class="product-item border border-black bg-white w-50">
                            <figure class="border-b">
                                <img class="w-full h-35 object-cover" src="{{ $product->image }}" alt="product image">
                            </figure>
                            <header class="m-2">
                                <h4 class="text-lg text-black font-bold">{{ $product->name }}</h4>
                                <span class="text-sm font-normal text-black">Tempat: {{ $product->shelf_name }}</span>
                                @php
                                    $price = $product->lowest_price;
                                    if (array_key_exists($product->id, $orders))
                                        $price = $orders[$product->id]['price'];
                                @endphp
                                <p class="text-sm text-black font-semibold mt-2 price-{{ $product->id }}">{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $price) }} </p>
                            </header>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <footer class="m-2 pb-1">
                                <div class="mt-2">
                                    <div class="gap-2 flex">
                                        <select class="flex-2 w-[35rem]" name="unit">
                                            @foreach ($product->units as $unit)
                                                <option
                                                    value="{{ $unit->unit }}"
                                                    data-product-id="{{ $product->id }}"
                                                    data-price="{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $unit->price) }} "
                                                    @if (array_key_exists($product->id, $orders) && $orders[$product->id]['unit'] == $unit->unit)
                                                        selected="selected"
                                                    @endif
                                                >
                                                    {{ $unit->unit_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if (array_key_exists($product->id, $orders))
                                            <button type="submit" class="flex items-center justify-center button text-base w-full bg-[red] text-white p-3 rounded border border-black">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </button>
                                        @else
                                            <button type="submit" class="flex items-center justify-center button text-base w-full bg-black hover:bg-[#ff91e7] hover:text-black text-white p-3 rounded border border-black">
                                                <svg class="h-5 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </footer>
                        </article>
                        {{ Form::close() }}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-order h-full fixed right-4">
            <div class="border-l px-8 w-[400px] h-[93vh]">
                <h3 class="text-xl text-black">
                    Transaksi
                </h3>
                <div class="flex items-center mt-4 gap-3">
                    <a href="{{ route('transaction.create.form') }}" class="text-sm text-center text-black rounded-full py-3 px-7 border cursor-pointer {{ $customer_info ? '' : 'bg-black text-white' }}" role="tab" data-target="w-order-item">Daftar Belanja</a>
                    <a href="{{ route('transaction.customer') }}" class="text-sm text-center text-black rounded-full py-3 px-7 border cursor-pointer {{ $customer_info ? 'bg-black text-white' : '' }}" role="tab" data-target="w-order-info">Informasi Pembeli</a>
                </div>
                <div class="w-cart mt-4">
                    <div role="tabitem" id="w-order-info" class="{{ $customer_info ? '' : 'hidden' }}">
                        <form action="{{ route('transaction.create') }}" method="POST" id="form-create">
                            @csrf
                            <div>
                                <legend class="mb-2">
                                    <label for="role" class="text-[#000000] font-light">
                                        Informasi Pelanggan
                                    </label>
                                </legend>
                                <div class="flex gap-2 relative mb-2">
                                    <select name="customer">
                                        <option value="0" readonly>Pilih Pelanggan</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('customer')
                                    <span class="text-sm text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <label class="switch">
                                    <input 
                                        type="checkbox"
                                        name="new_customer"
                                        id="permission"
                                        value="{{ \App\Constant\Constant::OPTION_ENABLE }}"
                                        @if (old('new_customer') == \App\Constant\Constant::OPTION_ENABLE)
                                            checked
                                        @endif
                                    />
                                    <span class="slider round"></span>
                                    </label>
                                    <label for="new_customer" class="text-[#000] font-light ml-1">Pelanggan baru</label>
                                    <div class="notification-box box mt-3 relative {{ old('new_customer') == \App\Constant\Constant::OPTION_ENABLE ? '' : 'hidden' }}">
                                        <div>
                                            <legend class="mb-2">
                                                <label for="name" class="text-[#000000] font-light">Nama Pelanggan <span class="text-danger">*</span></label>
                                            </legend>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" />
                                            @error('name')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-2">
                                            <legend class="mb-2">
                                                <label for="phone_number" class="text-[#000000] font-light">No.Telepon</label>
                                            </legend>
                                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" />
                                            @error('phone_number')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-2">
                                            <legend class="mb-2">
                                                <label for="phone_number" class="text-[#000000] font-light">Alamat</label>
                                            </legend>
                                            <textarea name="address" rows="1">{{ old('description') }}</textarea>
                                            @error('address')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @error('new_customer')
                                        <span class="text-sm text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </form>
                    </div>
                    <div role="tabitem" id="w-order-item" class="{{ $customer_info ? 'hidden' : '' }}">
                        @php
                            $grand_total = 0;
                            $total_qty = 0;
                        @endphp
                        @foreach (array_values($orders) as $order)
                            @php
                                $total_price = $order['price'] * $order['quantity'];
                                $grand_total += $total_price;
                                $total_qty += $order['quantity'];
                            @endphp
                            <div class="order-item flex gap-4 py-2">
                                <div class="">
                                    <img src="{{ $order['detail']->image }}" class="w-10 h-10 object-contain" alt="">
                                </div>
                                <div class="w-full">
                                        <div class="flex justify-between items-center">
                                            <div class="">
                                                <h4 class="text-black text-md font-medium">{{ $order['detail']->name }}</h4>
                                                <h3 class="text-md font-normal text-sm text-black">{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $total_price) }}</h3>
                                            </div>
                                            <div class="qty-picker mt-4">
                                                <form action="{{ route('transaction.cart.action', ['actionType' => 'increment']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $order['detail']->id }}">
                                                    <button type="submit">
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                    </button>
                                                </form>
                                                <span>{{ $order['quantity'] }}</span>
                                                <form action="{{ route('transaction.cart.action', ['actionType' => 'decrement']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $order['detail']->id }}">
                                                    <button type="submit">
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus"><path d="M5 12h14"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-buy border-t border-black py-5">
                    <div class="flex justify-between color-[#6a748a]">
                        <h2>Total Belanjaan</h2>
                        <span>{{ $total_qty }}</span>
                    </div>
                   
                    <div class="flex justify-between text-black items-center mt-2">
                        <h2 class="text-xl font-semibold">Total </h2>
                        <span class="font-semibold">{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $grand_total) }}</span>
                    </div>
                     <div class="flex flex-wrap gap-2 mt-4 account">
                        @foreach($accounts as $account)
                                <div class="flex-1 border border-black p-3 rounded-sm account-item {{ $selected_account == $account->id ? 'active' : '' }}" data-account-id="{{ $account->id }}">
                                    <form method="POST" action="{{ route('transaction.account') }}">
                                        @csrf
                                        <h2 class="text-md text-black font-m1  font-semibold">{{ $account->name }}</h2>
                                        <input type="hidden" name="account_id" value="{{ $account->id }}">
                                        <span class="text-sm text-black">{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $account->current_balance) }}</span>
                                    </form>
                                </div>
                        @endforeach   
                    </div>
                    <div class="w-action mt-4">
                        <button id="btn-pay" class="button text-base w-full bg-black hover:bg-[#ff91e7] hover:text-black text-white p-3 rounded border border-black">Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</main>
@endsection
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', function () {
            const formSearch = document.getElementById('search')
            const inputSearch = document.querySelector('input[name="search"]')
            formSearch.addEventListener('submit', function (e) {
                e.preventDefault()
                const queryParam = new URLSearchParams(window.location.search);
                queryParam.set('search', inputSearch.value)
                window.location = '{{ route("transaction.create.form")}}?' + queryParam.toString()
            })

            const unitFields = document.querySelectorAll('select[name="unit"]')
            unitFields.forEach(function (item) {
                item.addEventListener('change', function (event) {
                    const price = item[event.target.selectedIndex].getAttribute('data-price')
                    const productId = item[event.target.selectedIndex].getAttribute('data-product-id')
                    const priceLabel = document.querySelector(`.price-${productId}`)
                    priceLabel.innerHTML = price
                })
            })

            const accountItems = document.querySelectorAll('.account-item')
            const accountRadio = document.querySelectorAll('input[name="account_id"]')
            accountItems.forEach(function(account) {
                const accountId = account.getAttribute('data-account-id')
                account.addEventListener('click', function (event) {
                    const as = account.querySelector('form')
                    as.submit()
                })
            })

            const tabs = document.querySelectorAll('[role="tab"]')
            const tabitems = document.querySelectorAll('[role="tabitem"]')
            tabs.forEach(function (item) {
                const target = item.getAttribute('data-target')
                item.addEventListener('click', function () {
                    tabitems.forEach(function (item1) {
                        const btt = item1.getAttribute('id')
                        item1.classList.add('hidden')
                        if (btt == target)
                            item1.classList.remove('hidden')
                    })
                    tabs.forEach(function (item2) {
                        item2.classList.remove('bg-black')
                        item2.classList.remove('text-white')
                        item2.classList.add('text-black')
                        const bct = item2.getAttribute('data-target')
                        if (target == bct) {
                            item2.classList.add('text-white')
                            item2.classList.add('text-black')
                            item2.classList.add('bg-black') 
                        }
                    })
                })
            })

            const toggleNotification = document.querySelector('input[name="new_customer"]')
            const notificationBox = document.querySelector('.notification-box')
            toggleNotification.addEventListener('change', function (event) {
                notificationBox.classList.toggle('hidden')
            })

            const btnPay = document.querySelector('#btn-pay')
            btnPay.addEventListener('click', function (event) {
                event.preventDefault()
                document.querySelector('#form-create').submit() 
            })
        })
    </script>
@endpush