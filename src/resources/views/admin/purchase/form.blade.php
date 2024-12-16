@extends('layout.dashboard')
@section('content')
<div class="second-nav py-[2.7rem] px-14 w-full">
    <div class="w-11/12">
        <div class="flex justify-between items-center">
            <h1>
                {{ $page_title }}
            </h1>
            <div class="flex items-center justify-between gap-5 relative">
                <a href="{{ route('purchase.index') }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
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
                    <h1 class="text-2xl mb-2 font-lighter">Informasi Faktur Pembelian</h1>
                    <p>Detailkan pembelian produk yang akan kamu lakukan, pilih pemasok produk sampai dengan tanggal pembelian produk</p>
                </header>
                <fieldset class="w-3/5">
                    <input type="hidden" name="latest_order_id" value="{{ $latest_order_id }}">
                    @if (empty($item))
                        <div class="mb-4">
                            <legend class="mb-2">
                                <label for="supplier_id" class="text-[#000000] font-light">Pemasok <span class="text-danger">*</span></label>
                            </legend>
                            <select name="supplier_id" id="supplier_id" class="mb-2" v-model="form.supplier_id">
                                <option  value="0">Pilih Pemasok</option>
                                <option 
                                    v-for="(supplier, idx) in suppliers"
                                    :key="idx"
                                    :value="supplier.id"
                                >
                                    @{{ supplier.name }} 
                                </option>
                            </select>
                            <span 
                                class="text-sm text-danger"
                                v-for="(error) in getErrors('supplier_id')"
                            >
                                @{{ error }}
                            </span>
                        </div>
                    <div class="mb-4 w-3/4" id="supplier-information" v-if="form.supplier_id != 0">
                        <table class="w-full" v-if="selected_supplier != undefined">
                            <tr>
                                <td>
                                    <p class="text-[#000000] font-light text-md">Alamat</p> 
                                </td>
                                <td>
                                    <p class="text-[#000000] font-light text-md">@{{ selected_supplier.address }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-[#000000] font-light text-md">No.Ponsel</p> 
                                </td>
                                <td>
                                    <p class="text-[#000000] font-light text-md">@{{ selected_supplier.phone_number }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-[#000000] font-light text-md">Email</p> 
                                </td>
                                <td>
                                    <p class="text-[#000000] font-light text-md" id="supplier-email">@{{ selected_supplier.email }}</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @endif
                    <div class="mb-4">
                        <legend class="mb-2">
                            <label for="purchase_number" class="text-[#000000] font-light">No.Faktur Pembelian<span class="text-danger">*</span></label>
                        </legend>
                        <input type="text" name="purchase_number" v-model="form.purchase_number" class="mb-2 input border rounded-sm px-4 py-2 w-full" readonly />
                        <span 
                            class="text-sm text-danger"
                            v-for="(error) in getErrors('purchase_number')"
                        >
                            @{{ error }}
                        </span>
                    </div>
                    <div>
                        <legend class="mb-2">
                            <label for="purchase_date" class="text-[#000000] font-light">Tanggal Pemesanan Stok <span class="text-danger">*</span></label>
                        </legend>
                        <input type="date" name="purchase_date" v-model="form.purchase_date" class="mb-2 input border rounded-sm px-4 py-2 w-full" />
                        <span 
                            class="text-sm text-danger"
                            v-for="(error) in getErrors('purchase_date')"
                        >
                            @{{ error }}
                        </span>
                    </div>
                </fieldset>
            </section>

            <section class="flex gap-2 justify-between pt-15 items-start">
                <header class="text-[#000000] font-light flex-1">
                    <h1 class="text-2xl mb-2 font-lighter">Stok dan Produk</h1>
                    <p>Pilih produk - produk yang akan kamu beli, sesuaikan produk yang akan kamu beli dan tentukan harga pembelian</p>
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
                                            v-for="product in products"
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

                                <fieldset class="w-full">
                                    <label for="price" class="text-[#000000] font-normal">Harga Beli Satuan</label>
                                    <input type="number" name="price" v-model="order_item.price" class="mb-2"> 
                                    <span 
                                        class="text-sm text-danger"
                                        v-for="(error) in getErrors(`items.${idx}.price`)"
                                    >
                                        @{{ error }}
                                    </span>
                                </fieldset>

                                <fieldset class="w-full">
                                    <label for="notes" class="text-[#000000] font-normal">Catatan</label>
                                    <textarea name="notes" id="notes" v-model="order_item.notes"></textarea> 
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    
                    <div :class="get_add_button_class">
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
            suppliers: [],
            form: {
                supplier_id: 0,
                purchase_number: '',
                purchase_date: ''
            },
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
            async fetchSuppliers() {
                return fetch('/api/purchase/supplier', this.getHttpOption())
                    .then((response) => response.json())
                    .then((result) => {
                        this.suppliers = result.suppliers 
                })
            },
            async fetchPurchaseDetail() {
                let self = this;
                const orderId = document.querySelector('input[name="latest_order_id"]')
                const action = '{{ $action }}'
                if (action !== 'edit') return false;
                return fetch('/api/purchase/{{ empty($item) ? 0 : $item->id }}', this.getHttpOption())
                    .then((response) => response.json())
                    .then((result) => {
                        const {purchase_date, purchase_number, supplier_id, items} = result.purchase_order
                        console.log('masuk ke sini', purchase_number)
                        self.form.purchase_date = purchase_date
                        self.form.purchase_number = purchase_number
                        self.form.supplier_id = supplier_id
                        self.order_items = items
                        self.opened_item_idx = 0
                    })
            },
            handleAddNewProduct() {
                this.order_items.push({
                    product_id: 0,
                    qty: 0,
                    unit: 0,
                    price: 0,
                    notes: '',
                    units: []
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
                    const {product_id, qty, unit, price, notes, id} = this.order_items[seq]
                    const orderItem = {
                        product_id,
                        qty,
                        unit,
                        price,
                        notes
                    }
                    if (id) {
                        orderItem.id = id
                    }
                    orderItems.push(orderItem)
                }
                return orderItems;
            },
            buildPayload() {
                const {supplier_id, purchase_number, purchase_date} = this.form
                const userInput = {
                    supplier_id,
                    purchase_number,
                    purchase_date,
                    created_by: '{{ $user["id"] }}',
                    items: this.buildOrderItemPayload()
                }
                return userInput
            },
            handleSubmit() {
                const orderId = document.querySelector('input[name="latest_order_id"]')
                const action = '{{ $action }}'
                if (action == 'edit') {
                    const payload = this.buildPayload();
                    payload.purchase_order_id = '{{ empty($item) ? 0 : $item->id }}'
                    const httpOptions = {
                        method: 'POST',
                        body: JSON.stringify(payload),
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    }
                    console.log(payload)
                    this.is_loading = true
                    return fetch('/api/purchase/edit', httpOptions)
                        .then((response) => response.json())
                        .then((result) => {
                            const { status, errors } = result
                            if (!status && errors) {
                                this.errors = errors
                                return
                            } 
                            window.location = '{{ route("purchase.index") }}'
                        })
                        .finally(() => {
                            this.is_loading = false
                        })
                    return;
                }; 
                const payload = this.buildPayload();
                const httpOptions = {
                    method: 'POST',
                    body: JSON.stringify(payload),
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                }
                this.is_loading = true
                return fetch('/api/purchase', httpOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        const { status, errors } = result
                        if (!status && errors) {
                            this.errors = errors
                            return
                        }
                        window.location = '{{ route("purchase.index") }}'
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
            }
        },
        watch: {
            ['form.supplier_id'](supplierId) {
                let action = '{{ $action }}'
                if (action == 'edit') return
                const orderId = document.querySelector('input[name="latest_order_id"]')
                let dateObj = new Date();
                let currentDate = (dateObj.getUTCFullYear()) + "" + (dateObj.getMonth() + 1)+ "" + (dateObj.getUTCDate());
                const supplierDetail = this.suppliers.find((item) => item.id == supplierId)
                let purchaseNumber = '' 
                if (supplierDetail) {
                    purchaseNumber = `PO/${supplierDetail.code}/${currentDate}/${orderId.value}`
                }
                this.form.purchase_number = purchaseNumber
            }
        },
        computed: {
            selected_supplier () {
                if (this.form.supplier_id == 0) {
                    return {
                        address: '',
                        phone_number: '',
                        email: ''
                    };
                }

                const supplier = this.suppliers.find((item) => item.id == this.form.supplier_id)
                return supplier
            },
            get_add_button_class () {
                if (this.order_items.length > 0) {
                    return 'mt-8'
                }
                return 'border border-dashed bg-[#ffffff] p-8 mt-8'
            }
        },
        mounted () {
            this.fetchProducts()
            this.fetchSuppliers()
            this.fetchPurchaseDetail()
        }
    })
</script>
@endpush