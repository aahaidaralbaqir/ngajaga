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
        <div class="flex flex-col items-center gap-5">
          <figure>
            <img src="https://app.gumroad.com/error_pages/comic-rock.png" alt="">
            </figure>
            <h1 class="text-black text-4xl border-black">Tidak punya akses</h1>
            <hr class="w-[12.5rem] mx-auto" style="border: none; border-top: solid .125rem black;">
            <p class="text-black">Permintaan kamu di tolak, silahkan hubungi administrator</p>
            <a href="{{ route('dashboard') }}" class="mt-8 w-full button text-center text-base hover:bg-[#ff91e7] text-white hover:text-black bg-black p-3 rounded border border-black">Kembali ke halaman utama</a>
          </div>
			</div>
	</main>
</body>
</html>