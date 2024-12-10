@extends('layout.dashboard')
@section('content')
<div class="second-nav py-[2.7rem] px-14 w-full">
    <div class="w-11/12">
        <div class="flex justify-between items-center">
            <h1>
                {{ $page_title }}
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                <a href="{{ route('transaction.index') }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    Kembali
                </a>
                <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black" :disabled="is_loading" @click.prevent="handleSubmit">
                    <span v-if="is_loading">Menyimpan...</span>
                    <span v-else>Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-11/12">
            <section class="flex gap-2 justify-between border-b pb-15">
                <header class="text-[#000000] font-light flex-1">
                    <h1 class="text-2xl mb-2 font-lighter">Informasi Transaksi</h1>
                </header>
                <fieldset class="w-3/5">
                    <div class="mb-4">
                        <legend class="mb-2">
                            <label for="order_id" class="text-[#000000] font-light">Nomor Transaksi <span class="text-danger">*</span></label>
                        </legend>
                        <input type="text" name="order_id" v-model="form.order_id" class="mb-2 input border rounded-sm px-4 py-2 w-full" disabled />
                        <span 
                            class="text-sm text-danger"
                            v-for="(error) in getErrors('order_id')"
                        >
                            @{{ error }}
                        </span>
                    </div>
                    <div class="mb-4">
                        <legend class="mb-2">
                            <label for="customer_id" class="text-[#000000] font-light">Pelanggan <span class="text-danger">*</span></label>
                        </legend>
                        <select name="customer_id" id="customer_id" class="mb-2" v-model="form.customer_id">
                            <option  value="0">Pilih Pelanggan</option>
                            <option 
                                v-for="(customer, idx) in customers"
                                :key="idx"
                                :value="customer.id"
                            >
                                @{{ customer.name }} 
                            </option>
                        </select>
                        <span 
                            class="text-sm text-danger"
                            v-for="(error) in getErrors('customer_id')"
                        >
                            @{{ error }}
                        </span>
                    </div>
                    
                    <div class="mb-4 w-3/4" id="supplier-information" v-if="form.customer_id != 0">
                        <table class="w-full">
                            <tr>
                                <td>
                                    <p class="text-[#000000] font-light text-md">Alamat</p> 
                                </td>
                                <td>
                                    <p class="text-[#000000] font-light text-md">@{{ selected_customer.address }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-[#000000] font-light text-md">No.Ponsel</p> 
                                </td>
                                <td>
                                    <p class="text-[#000000] font-light text-md">@{{ selected_customer.phone_number }}</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="mb-4">
                        <legend class="mb-2">
                            <label for="account_id" class="text-[#000000] font-light">Pilih Akun Penerima Pembayaran <span class="text-danger">*</span></label>
                        </legend>
                        <select name="account_id" id="account_id" class="mb-2" v-model="form.account_id">
                            <option  value="0">Pilih Akun</option>
                            <option 
                                v-for="(account, idx) in accounts"
                                :key="idx"
                                :value="account.id"
                            >
                                @{{ account.name }} - @{{ account.formated_current_balance }} 
                            </option>
                        </select>
                        <span 
                            class="text-sm text-danger"
                            v-for="(error) in getErrors('account_id')"
                        >
                            @{{ error }}
                        </span>
                    </div>
                    
                    <div>
                        <legend class="mb-2">
                            <label for="transaction_date" class="text-[#000000] font-light">Tanggal Transaksi <span class="text-danger">*</span></label>
                        </legend>
                        <input type="date" name="transaction_date" v-model="form.transaction_date" class="mb-2 input border rounded-sm px-4 py-2 w-full" />
                        <span 
                            class="text-sm text-danger"
                            v-for="(error) in getErrors('transaction_date')"
                        >
                            @{{ error }}
                        </span>
                    </div>
                </fieldset>
            </section>

            <section class="flex gap-2 justify-between pt-15 items-start">
                <header class="text-[#000000] font-light flex-1">
                    <h1 class="text-2xl mb-2 font-lighter">Stok dan Produk</h1>
                </header>
                <fieldset class="w-3/5 flex flex-col">
                    <div class="box-w">
                        <div 
                            v-for="(order_item, idx) in order_items" 
                            class="box border-[#000000] boxitem" 
                            role="listitem"
                            :key="idx"
                        >
                            <div class="flex justify-between">
                                <div class="flex items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                    <div class="text-black">
                                        <h4 class="text-base font-normal capitalize">@{{ getProductName(idx, order_item.product_id) }}</h4>
                                        <ul class="inline p-0 list-none text-base font-normal">
                                            <li>@{{ order_item.qty <= 0 ? 'Kuantitas' : order_item.qty }}</li>
                                            <li>@{{ getUnitName(order_item.unit, order_item.product_id) }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="actions flex gap-2">
                                    <button class="button text-base text-black p-3 rounded border border-black relative flex gap-2" role="delete" @click.prevent="handleRemoveProduct(idx)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                    <button @click.prevent="handleToggleCollapse(idx)" class="button text-base text-black p-3 rounded border border-black relative flex gap-2" role="collapse" aria-state="up">
                                        <svg :class="{'rotate-180': idx == opened_item_idx }" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-4 box-b mt-4" v-if="opened_item_idx == idx">
                                <fieldset class="w-full">
                                    <label for="product_id" class="text-[#000000] font-normal">Produk</label>
                                    <select name="product_id" id="product_id"  v-model="order_item.product_id" class="mb-2">
                                        <option value="0" selected>Pilih Produk</option>
                                        <option
                                            v-for="product in filteredProducts(order_item.product_id)"
                                            :value="product.id"
                                        >
                                            @{{ product.name }}
                                        </option>
                                    </select>
                                    <span 
                                        class="text-sm text-danger"
                                        v-for="(error) in getErrors(`items.${idx}.product_id`)"
                                    >
                                        @{{ error }}
                                    </span>
                                </fieldset>

                                <fieldset class="w-full">
                                    <label for="unit_id" class="text-[#000000] font-normal">Satuan</label>
                                    <select name="unit_id" id="unit_id" v-model="order_item.unit" class="mb-2">
                                        <option value="0" selected>Pilih Satuan</option>
                                        <option
                                            v-for="unit in order_item.units"
                                            :value="unit.id"
                                        >
                                        @{{ unit.name }}
                                        </option> 
                                    </select>
                                    <span 
                                        class="text-sm text-danger"
                                        v-for="(error) in getErrors(`items.${idx}.unit`)"
                                    >
                                        @{{ error }}
                                    </span>
                                </fieldset>

                                <fieldset class="w-full">
                                    <label for="qty" class="text-[#000000] font-normal">Kuantitas</label>
                                    <input type="number" name="qty" v-model="order_item.qty" class="mb-2">
                                    <span 
                                        class="text-sm text-danger"
                                        v-for="(error) in getErrors(`items.${idx}.qty`)"
                                    >
                                        @{{ error }}
                                    </span>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    
                    <div :class="get_add_button_class" v-if="order_items.length < products.length">
                        <button @click.prevent="handleAddNewProduct" id="btn-add-product" class="w-full mx-auto flex gap-2 items-center justify-center button text-base bg-black hover:bg-[#ff91e7] text-white hover:text-black p-3 rounded border border-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            Tambah Produk
                        </button>
                    </div>
                </fieldset>
            </section>
    </section>
</main>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.7.16"></script>
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            is_loading: false,
            opened_item_idx: -1,
            errors: {},
            order_items: [
            ],
            products: [],
            customers: [],
            accounts: [],
            form: {
                customer_id: 0,
                transaction_date: 0,
                order_id: '',
            },
            transaction_record: null
        },
        methods: {
            getHttpOption () {
                return {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                };
            },
            async fetchProducts() {
                return fetch('/api/purchase/product', this.getHttpOption())
                    .then((response) => response.json())
                    .then((result) => {
                        this.products = result.products 
                    })
            },
            async fetchAccount() {
                return fetch('/api/transaction/account', this.getHttpOption())
                    .then((response) => response.json())
                    .then((result) => {
                        this.accounts = result.account 
                    })
            },
            async fetchTransactionDetail() {
                return fetch('/api/transaction/{{ $transaction_record->id }}', this.getHttpOption())
                    .then((response) => response.json())
                    .then(({transaction}) => {
                        this.form = {
                            ...this.form,
                            order_id: transaction.order_id,
                            customer_id: transaction.customer_id,
                            transaction_date: transaction.transaction_date,
                            account_id: transaction.account_id
                        }
                        this.order_items = transaction.items
                        this.opened_item_idx = 0
                    })
            },
            async fetchCustomer() {
                return fetch('/api/transaction/customer', this.getHttpOption())
                    .then((response) => response.json())
                    .then((result) => {
                        this.customers = result.customer.data 
                })
            },
            handleAddNewProduct() {
                const unselectedProducts = this.products.filter(product => {
                    return !this.order_items.some(order_item => order_item.product_id === product.id);
                });

                if (unselectedProducts.length === 0) {
                    return;
                }

                if (this.order_items.length >= this.products.length) {
                    return;
                }
                this.order_items.push({
                    product_id: 0,
                    unit: 0,
                    qty: 0,
                })
                this.opened_item_idx++
            },
            handleRemoveProduct(idx) {
                this.order_items = this.order_items.filter((value, index) => index != idx)
                this.opened_item_idx--
            },
            handleToggleCollapse(idx) {
                if (idx == this.opened_item_idx) 
                {
                    this.opened_item_idx = -1
                    return;
                }
                this.opened_item_idx = idx
            },
            getProductName(idx, product_id) {
                const product_detail = this.products.find((item) => item.id == product_id)
                if (!product_detail) return 'Tidak ada produk yang dipilih'
                this.order_items[idx].units = product_detail.units
                return product_detail.name
            },
            getUnitName(unit_id, product_id) {
                const product_detail = this.products.find((item) => item.id == product_id)
                if (!product_detail) return 'Satuan'
                const unit_detail = product_detail.units.find((item) => item.id == unit_id)
                 if (!unit_detail) return 'Satuan'
                return unit_detail.name
            },
            getQuantity(idx, product_id) {
                const product_detail = this.products.find((item) => item.id == product_id)
                if (!product_detail) return 'Kuantitas'
                return this.order_items[idx].qty
            },
            buildOrderItemPayload() {
                let orderItems  = []
                for (let seq = 0; seq < this.order_items.length; seq++) {
                    const {product_id, qty, unit} = this.order_items[seq]
                    const orderItem = {
                        product_id,
                        qty,
                        unit,
                    }
                    orderItems.push(orderItem)
                }
                return orderItems;
            },
            buildPayload() {
                const {customer_id, account_id, transaction_date} = this.form
                const userInput = {
                    id: '{{ $transaction_record->id }}',
                    customer_id,
                    account_id,
                    transaction_date,
                    created_by: '{{ $user["id"] }}',
                    items: this.buildOrderItemPayload()
                }
                return userInput
            },
            handleSubmit() {
                const payload = this.buildPayload();
                const httpOptions = {
                    method: 'POST',
                    body: JSON.stringify(payload),
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }
                this.is_loading = true
                return fetch('/api/transaction/edit', httpOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        console.log(result)
                        const { status, errors } = result
                        if (!status && errors) {
                            this.errors = errors
                            return
                        } 

                        if (!status) {
                            window.location.reload()
                            return
                        }
                        window.location = '{{ route("transaction.index") }}'
                    })
                    .finally(() => {
                        this.is_loading = false
                    })
            },
            getErrors(name) {
                if (this.errors[name]) {
                    return this.errors[name]
                }
                return []
            },
            filteredProducts(product_id) {
                return this.products.filter((product) => {
                    return this.order_items.every((order_item) => {
                        return order_item.product_id === product_id || order_item.product_id !== product.id;
                    });
                });
            }
        },
        computed: {
            selected_customer () {
                if (this.form.customer_id == 0) {
                    return null;
                }
                const customer = this.customers.find((item) => item.id == this.form.customer_id)
                return customer
            },
            get_add_button_class () {
                if (this.order_items.length > 0) {
                    return 'mt-8'
                }
                return 'border border-dashed bg-[#ffffff] p-8 mt-8'
            },
           
        },
        mounted () {
            this.fetchProducts()
            this.fetchCustomer()
            this.fetchAccount()
            this.fetchTransactionDetail()
        }
    })
</script>
@endpush