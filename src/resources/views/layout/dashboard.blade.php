<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    SIMASJID | Dashboard Admin 
  </title>
  <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/font.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/dashboard.css') }}">
  @stack('styles')
</head>

<body class="bg-[#f4f4f0]">
  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <!-- ===== Sidebar Start ===== -->
    @include('partials.sidebar')
    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <!-- ===== Header Start ===== -->
      <!-- ===== Header End ===== -->

      <!-- ===== Main Content Start ===== -->
        <main>
            @yield('content')
        </main>
      <!-- ===== Main Content End ===== -->
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  <!-- ===== Page Wrapper End ===== -->
</body>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
@stack('scripts')
</html>