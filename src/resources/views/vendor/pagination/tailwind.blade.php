<div class="flex text-black items-center mt-4 justify-between">
    @if ($paginator->onFirstPage())
        <a href="#" class="prev border border-black px-3 py-2 flex gap-2 bg-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
            <p>Kembali</p>
        </a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="prev border border-black px-3 py-2 flex gap-2 bg-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
            <p>Kembali</p>
        </a> 
    @endif
    <h2 class="page font-bold">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</h2>
    @if ($paginator->hasMorePages())
        <a  href="{{ $paginator->nextPageUrl() }}" hclass="next border border-black px-3 py-2 flex gap-2 bg-white">
            <p>Lanjut</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
        </a>
    @else
        <a href="#" class="next border border-black px-3 py-2 flex gap-2 bg-white">
            <p>Lanjut</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
        </a>
    @endif
</div>