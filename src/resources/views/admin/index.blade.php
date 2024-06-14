@extends('layout.dashboard')
@section('content')
<div class="second-nav py-14 px-14 w-full">
    <div class="w-4/5">
        <div class="flex justify-between items-center">
            <h1>
                Selamat datang di Ngajaga
            </h1>
        </div>
    </div>
</div>
<main class="w-full py-14 px-14">
    <section class="w-4/5">
		<h2 class="text-black font-normal text-2xl">Laporan Penjualan</h2>
			<div class="box border-black mt-4">
				<div class="flex gap-2 items-center justify-between">
					<div class="flex gap-2">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
						<h5 class="text-black font-normal">Juni 2024</h5>
						<h4 class="text-black font-light">(8%) dibanding bulan lalu</h4>
					</div>
					<button class="button text-base text-black p-3 rounded border border-black relative">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal"><line x1="21" x2="14" y1="4" y2="4"/><line x1="10" x2="3" y1="4" y2="4"/><line x1="21" x2="12" y1="12" y2="12"/><line x1="8" x2="3" y1="12" y2="12"/><line x1="21" x2="16" y1="20" y2="20"/><line x1="12" x2="3" y1="20" y2="20"/><line x1="14" x2="14" y1="2" y2="6"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="16" x2="16" y1="18" y2="22"/></svg>
						<div class="menu hidden top-14 p-10">
							<div class="flex gap-5">
								<fieldset>
									<label for="start" class="text-black">Dari</label>
									<input type="date" name="" id="">
								</fieldset>
								<fieldset>
									<legend>
										<label for="start" class="text-black">Dari</label>
									</legend>
									<input type="date" name="" id="">
								</fieldset>
							</div>
						</div>
					</button>
				</div>
				<table class="w-full mt-10 text-black">
					<tbody>
						<tr>
							<td rowspan="2" class="border-r p-4">
								<h4 class=" text-1xl">Total Penjualan</h4>
								<h3 class="text-3xl">Rp 0</h3>
							</td>
							<td class="border-r p-4">
								<div class="border-b border-black py-7">
									<h4 class="text-1xl">Total Keuntungan</h4>
									<h3 class="text-3xl">Rp 0</h3>
								</div>
							</td>
							<td class="p-4">
								<div class="border-b border-black py-7">
									<h4 class="text-1xl">Total Keuntungan</h4>
									<h3 class="text-3xl">Rp 0</h3>
								</div>
							</td>
						</tr>
						<tr>
							<td class="border-r p-4">
								<div class="py-7">
									<h4 class="text-1xl">Total Keuntungan</h4>
									<h3 class="text-3xl">Rp 0</h3>
								</div>
							</td>
							<td class="p-4">
								<div class="py-7">
									<h4 class="text-1xl">Total Keuntungan</h4>
									<h3 class="text-3xl">Rp 0</h3>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
    </section>
</main>
@endsection