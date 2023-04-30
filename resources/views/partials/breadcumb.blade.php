 <!-- Breadcrumb Start -->
 <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
      {{ $title }} Page
    </h2>

    <nav>
      <ol class="flex items-center gap-2">
        <li><a class="font-medium" href="{{ route('admin') }}">Dashboard /</a></li>
        <li class="font-medium text-primary">{{ $title }}</li>
      </ol>
    </nav>
  </div>
  <!-- Breadcrumb End -->