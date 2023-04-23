@extends('layout.dashboard')
@section('content')
<!-- ===== Main Content Start ===== -->
<main>
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
	<div class="mx-auto max-w-270">
	@include('partials.alert')
	<!-- ====== Settings Section Start -->
	<div class="grid grid-cols-5 gap-8 mt-5">
		<div class="col-span-5 xl:col-span-3">
		<div
			class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
			<div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
			<h3 class="font-medium text-black dark:text-white">
				Konfigurasi Profile
			</h3>
			</div> 
			<div class="p-7">
			{{ Form::open(['route' => 'setting.update', 'method' => 'POST']) }}
				<div class="mb-5.5">
				<label class="mb-3 block text-sm font-medium text-black dark:text-white"
					for="emailAddress">Email Address</label>
				<div class="relative">
					<span class="absolute left-4.5 top-4">
					<svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<g opacity="0.8">
						<path fill-rule="evenodd" clip-rule="evenodd"
							d="M3.33301 4.16667C2.87658 4.16667 2.49967 4.54357 2.49967 5V15C2.49967 15.4564 2.87658 15.8333 3.33301 15.8333H16.6663C17.1228 15.8333 17.4997 15.4564 17.4997 15V5C17.4997 4.54357 17.1228 4.16667 16.6663 4.16667H3.33301ZM0.833008 5C0.833008 3.6231 1.9561 2.5 3.33301 2.5H16.6663C18.0432 2.5 19.1663 3.6231 19.1663 5V15C19.1663 16.3769 18.0432 17.5 16.6663 17.5H3.33301C1.9561 17.5 0.833008 16.3769 0.833008 15V5Z"
							fill="" />
						<path fill-rule="evenodd" clip-rule="evenodd"
							d="M0.983719 4.52215C1.24765 4.1451 1.76726 4.05341 2.1443 4.31734L9.99975 9.81615L17.8552 4.31734C18.2322 4.05341 18.7518 4.1451 19.0158 4.52215C19.2797 4.89919 19.188 5.4188 18.811 5.68272L10.4776 11.5161C10.1907 11.7169 9.80879 11.7169 9.52186 11.5161L1.18853 5.68272C0.811486 5.4188 0.719791 4.89919 0.983719 4.52215Z"
							fill="" />
						</g>
					</svg>
					</span>
					<input
					class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
					type="email" name="email" id="emailAddress" placeholder="devidjond45@gmail.com"
					value="{{ $email }}" />
					@error('email')
						<span class="text-sm text-danger">{{ $message }}</span>
					@enderror
				</div>
				</div>

				<div class="mb-5.5">
				<label class="mb-3 block text-sm font-medium text-black dark:text-white"
					for="Username">Name</label>
				<input
					class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
					type="text" name="name" id="name" value="{{ $name }}" />
				@error('name')
					<span class="text-sm text-danger">{{ $message }}</span>
				@enderror
				</div>

				<div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
				<div class="w-full sm:w-1/2">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white"
						for="newPassword">Kata sandi baru</label>
					<div class="relative">
						<span class="absolute left-4.5 top-4">
							<svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<g opacity="0.5">
									<path
									d="M16.1547 6.80626V5.91251C16.1547 3.16251 14.0922 0.825009 11.4797 0.618759C10.0359 0.481259 8.59219 0.996884 7.52656 1.95938C6.46094 2.92188 5.84219 4.29688 5.84219 5.70626V6.80626C3.84844 7.18438 2.33594 8.93751 2.33594 11.0688V17.2906C2.33594 19.5594 4.19219 21.3813 6.42656 21.3813H15.5016C17.7703 21.3813 19.6266 19.525 19.6266 17.2563V11C19.6609 8.93751 18.1484 7.21876 16.1547 6.80626ZM8.55781 3.09376C9.31406 2.40626 10.3109 2.06251 11.3422 2.16563C13.1641 2.33751 14.6078 3.98751 14.6078 5.91251V6.70313H7.38906V5.67188C7.38906 4.70938 7.80156 3.78126 8.55781 3.09376ZM18.1141 17.2906C18.1141 18.7 16.9453 19.8688 15.5359 19.8688H6.46094C5.05156 19.8688 3.91719 18.7344 3.91719 17.325V11.0688C3.91719 9.52189 5.15469 8.28438 6.70156 8.28438H15.2953C16.8422 8.28438 18.1141 9.52188 18.1141 11V17.2906Z"
									fill="" />
									<path
									d="M10.9977 11.8594C10.5852 11.8594 10.207 12.2031 10.207 12.65V16.2594C10.207 16.6719 10.5508 17.05 10.9977 17.05C11.4102 17.05 11.7883 16.7063 11.7883 16.2594V12.6156C11.7883 12.2031 11.4102 11.8594 10.9977 11.8594Z"
									fill="" />
								</g>
							</svg>
						</span>
						<input
							type="password"
							class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
							type="password" name="new_password" id="newPassword"/>
						@error('new_password')
							<span class="text-sm text-danger">{{ $message }}</span>
						@enderror
					</div>
				</div>

				<div class="w-full sm:w-1/2">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white"
						for="oldPassword">Kata sandi lama</label>
					<div class="relative">
						<span class="absolute left-4.5 top-4">
							<svg class="fill-current" width="22" height="22" viewBox="0 0 22 22" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<g opacity="0.5">
									<path
									d="M16.1547 6.80626V5.91251C16.1547 3.16251 14.0922 0.825009 11.4797 0.618759C10.0359 0.481259 8.59219 0.996884 7.52656 1.95938C6.46094 2.92188 5.84219 4.29688 5.84219 5.70626V6.80626C3.84844 7.18438 2.33594 8.93751 2.33594 11.0688V17.2906C2.33594 19.5594 4.19219 21.3813 6.42656 21.3813H15.5016C17.7703 21.3813 19.6266 19.525 19.6266 17.2563V11C19.6609 8.93751 18.1484 7.21876 16.1547 6.80626ZM8.55781 3.09376C9.31406 2.40626 10.3109 2.06251 11.3422 2.16563C13.1641 2.33751 14.6078 3.98751 14.6078 5.91251V6.70313H7.38906V5.67188C7.38906 4.70938 7.80156 3.78126 8.55781 3.09376ZM18.1141 17.2906C18.1141 18.7 16.9453 19.8688 15.5359 19.8688H6.46094C5.05156 19.8688 3.91719 18.7344 3.91719 17.325V11.0688C3.91719 9.52189 5.15469 8.28438 6.70156 8.28438H15.2953C16.8422 8.28438 18.1141 9.52188 18.1141 11V17.2906Z"
									fill="" />
									<path
									d="M10.9977 11.8594C10.5852 11.8594 10.207 12.2031 10.207 12.65V16.2594C10.207 16.6719 10.5508 17.05 10.9977 17.05C11.4102 17.05 11.7883 16.7063 11.7883 16.2594V12.6156C11.7883 12.2031 11.4102 11.8594 10.9977 11.8594Z"
									fill="" />
								</g>
							</svg>
						</span>
						<input
							type="password"
							class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
							type="password" name="old_password" id="oldPassword"/>
						@error('old_password')
							<span class="text-sm text-danger">{{ $message }}</span>
						@enderror
					</div>
				</div>
				</div>

				<div class="flex justify-end gap-4.5">
				<button
					class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
					type="submit">
					Simpan
				</button>
				</div>
			{{ Form::close() }}
			</div>
		</div>

		</div>
		<div class="col-span-5 xl:col-span-2">
		<div
			class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
			<div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
			<h3 class="font-medium text-black dark:text-white">
				Your Photo
			</h3>
			</div>
			<div class="p-7" 
			x-data="avatar"
			x-init="url = '@php echo $avatar @endphp'">
			{{ Form::open(['route' => 'setting.avatar.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
				<div class="mb-4 flex items-center gap-3">
				<div class="h-14 w-14 rounded-full">
					<img :src="url" alt="User" />
				</div>
				<div>
					<span class="mb-1.5 font-medium text-black dark:text-white">Edit your photo</span>
					<span class="flex gap-2.5">
					<a href="{{ route('setting.avatar.remove') }}" class="font-medium text-sm hover:text-primary">
						Delete
					</a>
					</span>
				</div>
				</div>

				<div id="FileUpload"
				class="relative mb-5.5 block w-full cursor-pointer appearance-none rounded border-2 border-dashed border-primary bg-gray py-4 px-4 dark:bg-meta-4 sm:py-7.5">
				<input type="file" accept="image/*"
					name="image"
					@change.debounce="handleChangeAvatar"
					class="absolute inset-0 z-50 m-0 h-full w-full cursor-pointer p-0 opacity-0 outline-none" />
				<div class="flex flex-col items-center justify-center space-y-3">
					<span
					class="flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd"
						d="M1.99967 9.33337C2.36786 9.33337 2.66634 9.63185 2.66634 10V12.6667C2.66634 12.8435 2.73658 13.0131 2.8616 13.1381C2.98663 13.2631 3.1562 13.3334 3.33301 13.3334H12.6663C12.8431 13.3334 13.0127 13.2631 13.1377 13.1381C13.2628 13.0131 13.333 12.8435 13.333 12.6667V10C13.333 9.63185 13.6315 9.33337 13.9997 9.33337C14.3679 9.33337 14.6663 9.63185 14.6663 10V12.6667C14.6663 13.1971 14.4556 13.7058 14.0806 14.0809C13.7055 14.456 13.1968 14.6667 12.6663 14.6667H3.33301C2.80257 14.6667 2.29387 14.456 1.91879 14.0809C1.54372 13.7058 1.33301 13.1971 1.33301 12.6667V10C1.33301 9.63185 1.63148 9.33337 1.99967 9.33337Z"
						fill="#3C50E0" />
						<path fill-rule="evenodd" clip-rule="evenodd"
						d="M7.5286 1.52864C7.78894 1.26829 8.21106 1.26829 8.4714 1.52864L11.8047 4.86197C12.0651 5.12232 12.0651 5.54443 11.8047 5.80478C11.5444 6.06513 11.1223 6.06513 10.8619 5.80478L8 2.94285L5.13807 5.80478C4.87772 6.06513 4.45561 6.06513 4.19526 5.80478C3.93491 5.54443 3.93491 5.12232 4.19526 4.86197L7.5286 1.52864Z"
						fill="#3C50E0" />
						<path fill-rule="evenodd" clip-rule="evenodd"
						d="M7.99967 1.33337C8.36786 1.33337 8.66634 1.63185 8.66634 2.00004V10C8.66634 10.3682 8.36786 10.6667 7.99967 10.6667C7.63148 10.6667 7.33301 10.3682 7.33301 10V2.00004C7.33301 1.63185 7.63148 1.33337 7.99967 1.33337Z"
						fill="#3C50E0" />
					</svg>
					</span>
					<p class="font-medium text-sm">
					<span class="text-primary">Click to upload</span>
					or drag and drop
					</p>
					<p class="mt-1.5 font-medium text-sm">SVG, PNG, JPG or GIF</p>
					<p class="font-medium text-sm">(max, 800 X 800px)</p>
				</div>
				</div>
				@error('avatar')
					<span class="text-sm text-danger">{{ $message }}</span>
				@enderror
				<div class="flex justify-end gap-4.5">
				<button
					class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
					type="submit">
					Save
				</button>
				</div>
			{{ Form::close() }}
			</div>
		</div>
		</div>
	</div>
	<!-- ====== Settings Section End -->
	</div>
</div>
</main>
<!-- ===== Main Content End ===== -->
@endsection