<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    Analytics Dashboard | TailAdmin - Tailwind CSS Admin Dashboard Template
  </title>
  <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/font.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/dashboard.css') }}">
</head>
<body class="bg-[#f4f4f0]">
	<main class="flex justify-center items-center h-screen">
			<div class="w-1/4">
				{{ Form::open(['url' => '/login', 'method' => 'POST']) }}
					<img src="/img/logo/logo.svg" alt="Logo Ngajaga" class="w-50 mx-auto">
					<br>
					<fieldset>
						<legend class="mb-2">
							<label for="email" class="text-[#000000] font-light">Nama <span class="text-danger">*</span></label>
						</legend>
						<input type="email" name="email">
						@error('email')
							<span class="text-sm text-danger mt-1 block">{{ $message }}</span>
						@enderror
					</fieldset>

					<fieldset class="relative mt-4">
						<legend class="mb-2">
							<label for="password" class="text-[#000000] font-light">Password <span class="text-danger">*</span></label>
						</legend>
						<div class="relative">
							<input type="password" name="password" id="password">
							<button target="password" class="absolute right-5 top-3.5" id="toggle-password-btn">
								<svg class="open-eye h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
								<svg class="close-eye hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
							</button>
							@error('password')
								<span class="text-sm text-danger mt-1 block">{{ $message }}</span>
							@enderror
						</div>
					</fieldset>
					<a class="text-sm text-black font-light mt-2 block" href="">Tidak punya akun ?</a>
					<button type="submit" class="mt-8 w-full button text-base hover:bg-[#ff91e7] text-white hover:text-black bg-black p-3 rounded border border-black">Masuk</button>
				{{ Form::close() }}
			</div>
	</main>
</body>
<script type="text/javascript">
	window.addEventListener('DOMContentLoaded', function () {
		const togglePasswordBtn = document.querySelectorAll('#toggle-password-btn')
        togglePasswordBtn.forEach(function (btn) {
            btn.addEventListener('click', function (event) {
                event.preventDefault()
                const targetSelector = btn.getAttribute('target')
                const input = document.querySelector(`input[name="${targetSelector}"]`)
                const currentInputType = input.getAttribute('type')
                const toggleMapping = {
                    'password': 'text',
                    'text': 'password'
                }
                input.setAttribute('type', toggleMapping[currentInputType])
                if (currentInputType == 'text') {
                    document.querySelectorAll('.open-eye').forEach(function (item) {
                        const target = item.parentNode.getAttribute('target')
                        if (target == targetSelector) {
                            item.classList.remove('hidden')
                        }
                    })

                    document.querySelectorAll('.close-eye').forEach(function (item) {
                        const target = item.parentNode.getAttribute('target')
                        if (target == targetSelector) {
                            item.classList.add('hidden')
                        }
                    })
                } else {
                    document.querySelectorAll('.open-eye').forEach(function (item) {
                        const target = item.parentNode.getAttribute('target')
                        if (target == targetSelector) {
                            item.classList.add('hidden')
                        }
                    })

                    document.querySelectorAll('.close-eye').forEach(function (item) {
                        const target = item.parentNode.getAttribute('target')
                        if (target == targetSelector) {
                            item.classList.remove('hidden')
                        }
                    })
                }
            })
        })
	})
</script>

</html>