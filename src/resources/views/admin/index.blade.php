@extends('layout.dashboard')
@section('content')
<div class="pt-5 px-14 w-full" style="border: none;">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1 class="mt-4 text-4xl text-black">
                Selamat datang
            </h1>
			<div class="flex items-center justify-between gap-5 relative">
                   
                </div>
        </div>
    </div>
</div>
<main class="w-full px-14 mt-4 pb-10">
    <section class="w-4/5">
		<div class="greeting">
			<svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 21.61a9.6 9.6 0 1 0 0-19.2 9.6 9.6 0 0 0 0 19.2Zm4.45-11.152a1.2 1.2 0 0 0-1.698-1.697l-3.951 3.952-1.552-1.552a1.2 1.2 0 0 0-1.697 1.697l2.4 2.4a1.2 1.2 0 0 0 1.697 0l4.8-4.8Z" fill="#23A094"></path>
			</svg>
			<div class="ml-3 text-sm"> Halo {{ $user['name'] }}</div>
		</div>
		@if (in_array(\App\Constant\Permission::VIEW_REPORT_SALE_SUMMARY, $user['permission']))
			<div class="flex justify-between items-center relative">
				<h2 class="text-black font-normal text-2xl">Laporan Penjualan</h2>
				@if (in_array(\App\Constant\Permission::FILTER_DASHBOARD_SUMMARY, $user['permission']))	
					<div class="flex gap-5">
						@if ($has_filter)
							<a href="{{ route('dashboard') }}" class="button text-base text-black p-3 rounded border border-black relative">
								Hapus Filter
							</a>
						@endif
						<button class="button text-base text-black p-3 rounded border border-black relative" role="dropdown" data-id="89" data-name="action">
							<svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-filter"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
						</button>
						<div class="menu top-14 right-1 mt-2 hidden" id="cmenu" data-id="89" data-name="action" role="dropdown-content">
							<form action="{{ route('dashboard') }}" method="GET">
								<div class="flex gap-5 p-4 border-b border-black">
									<fieldset>
										<label for="start" class="text-black">Dari Tanggal</label>
										<div class="flex gap-4 mt-2">
											<input type="date" name="start_date" id="" value="{{ request('start_date') }}">
											<input type="date" name="end_date" id="" value="{{ request('end_date') }}">
										</div>
									</fieldset>
								</div>
								<div class="mt-4 flex px-4">
									<button type="submit" class="w-full button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Saring</a>
								</div>
							</form>
						</div>
					</div>
				@endif
			</div>
			<div class="box border-black mt-4">
				<table class="w-full mt-10 text-black">
					<tbody>
						<tr>
							<td rowspan="2" class="border-r p-4">
								<h4 class=" text-1xl">Total Keuntungan</h4>
								<h3 class="text-3xl">{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $summary->total_amount) }}</h3>
							</td>
							<td class="border-r p-4">
								<div class="border-b border-black py-7">
									<h4 class="text-1xl">Total Transaksi</h4>
									<h3 class="text-3xl">{{ $summary->total_transaction }}</h3>
								</div>
							</td>
							<td class="p-4">
								<div class="border-b border-black py-7">
									<h4 class="text-1xl">Total Produk Terjual</h4>
									<h3 class="text-3xl">{{ $summary->total_product_qty }}</h3>
								</div>
							</td>
						</tr>
						<tr>
							<td class="border-r p-4">
								<div class="py-7">
									<h4 class="text-1xl">Total Pembelian</h4>
									<h3 class="text-3xl">{{ $total_purchase }}</h3>
								</div>
							</td>
							<td class="p-4">
								<div class="py-7">
									<h4 class="text-1xl">Total Kasbon</h4>
									<h3 class="text-3xl">{{ \App\Util\Common::formatAmount(\App\Constant\Constant::UNIT_NAME_RUPIAH, $total_debt) }}</h3>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		@endif

		<div class="flex gap-7 mt-10">
			@if (in_array(\App\Constant\Permission::VIEW_TOP_PRODUCT, $user['permission']))
				<div class="flex-1">
					<table class="w-full retro">
						<caption class="text-2xl text-black [text-align:unset]">Produk Terfavorit</caption>
						<thead>
							<tr>
								<th class="w-[15%]"></th>
								<th class="text-left">Nama Produk</th>
								<th class="text-left">Jumlah Penjualan</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($most_purchased_products as $product)
								<tr>
									<td class="cell-image">
										<img src="{{ \App\Util\Common::getStorage(\App\Constant\Constant::STORAGE_PRODUCT, $product->product_image) }}" alt="">
									</td>
									<td>{{ $product->product_name }}</td>
									<td>{{ $product->total_qty }}</td>
								</tr>
							@endforeach
							@if (count($most_purchased_products) < 1)
								<tr>
									<td colspan="3">Tidak ada data</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			@endif
			@if (in_array(\App\Constant\Permission::VIEW_LOWEST_PRODUCT, $user['permission']))
				<div class="flex-1">
					<table class="w-full retro">
						<caption class="text-2xl text-black [text-align:unset]">Stok Menipis</caption>
						<thead>
							<tr>
								<th class="w-[15%]"></th>
								<th class="text-left">Nama Produk</th>
								<th class="text-left">Jumlah Stok  Saat Ini</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($lowest_product as $lp)
								<tr>
									<td class="cell-image">
										<img src="{{ \App\Util\Common::getStorage(\App\Constant\Constant::STORAGE_PRODUCT, $product->product_image) }}" alt="">
									</td>
									<td>{{ $lp->name }}</td>
									<td>{{ $lp->total_qty }}</td>
								</tr>
							@endforeach
							@if (count($lowest_product) < 1)
								<tr>
									<td colspan="3">Tidak ada data</td>
								</tr>
							@endif
						</tbody>
					</table>	
				</div>
			@endif
    </section>
</main>
@endsection
@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script type="text/javascript">
		
		const getChartOptions = () => {
		return {
			series: [35.1, 23.5, 2.4, 5.4],
			colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#E74694"],
			chart: {
			height: 320,
			width: "100%",
			type: "donut",
			},
			stroke: {
			colors: ["transparent"],
			lineCap: "",
			},
			plotOptions: {
			pie: {
				donut: {
				labels: {
					show: true,
					name: {
					show: true,
					fontFamily: "Inter, sans-serif",
					offsetY: 20,
					},
					total: {
					showAlways: true,
					show: true,
					label: "Unique visitors",
					fontFamily: "Inter, sans-serif",
					formatter: function (w) {
						const sum = w.globals.seriesTotals.reduce((a, b) => {
						return a + b
						}, 0)
						return '$' + sum + 'k'
					},
					},
					value: {
					show: true,
					fontFamily: "Inter, sans-serif",
					offsetY: -20,
					formatter: function (value) {
						return value + "k"
					},
					},
				},
				size: "80%",
				},
			},
			},
			grid: {
			padding: {
				top: -2,
			},
			},
			labels: ["Direct", "Sponsor", "Affiliate", "Email marketing"],
			dataLabels: {
			enabled: false,
			},
			legend: {
			position: "bottom",
			fontFamily: "Inter, sans-serif",
			},
			yaxis: {
			labels: {
				formatter: function (value) {
				return value + "k"
				},
			},
			},
			xaxis: {
			labels: {
				formatter: function (value) {
				return value  + "k"
				},
			},
			axisTicks: {
				show: false,
			},
			axisBorder: {
				show: false,
			},
			},
		}
		}

		if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
		const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
		chart.render();

		// Get all the checkboxes by their class name
		const checkboxes = document.querySelectorAll('#devices input[type="checkbox"]');

		// Function to handle the checkbox change event
		function handleCheckboxChange(event, chart) {
			const checkbox = event.target;
			if (checkbox.checked) {
				switch(checkbox.value) {
					case 'desktop':
					chart.updateSeries([15.1, 22.5, 4.4, 8.4]);
					break;
					case 'tablet':
					chart.updateSeries([25.1, 26.5, 1.4, 3.4]);
					break;
					case 'mobile':
					chart.updateSeries([45.1, 27.5, 8.4, 2.4]);
					break;
					default:
					chart.updateSeries([55.1, 28.5, 1.4, 5.4]);
				}

			} else {
				chart.updateSeries([35.1, 23.5, 2.4, 5.4]);
			}
		}

		// Attach the event listener to each checkbox
		checkboxes.forEach((checkbox) => {
			checkbox.addEventListener('change', (event) => handleCheckboxChange(event, chart));
		});
		}

	</script>
@endpush
@push('styles')
    <style type="text/css">
        #cmenu::after {	
            content: "";
            border-left: solid .5rem rgba(0, 0, 0, 0);
            border-right: solid .5rem rgba(0, 0, 0, 0);
            border-bottom: solid .5rem black;
            position: absolute;
            top: -9px;
            left: 95%;
            transform: translate(-50%, 0);
            z-index: 30;
        }
		.greeting {
			display: flex;
			gap: 5;
			align-items: center;
			background-color: rgb(35 160 148 / 0.2);
			color: black;
			padding: 1rem;
			border: 1px solid  rgb(35 160 148);
			border-radius: 4px;
			margin-bottom: 15px;
		}
    </style>
@endpush