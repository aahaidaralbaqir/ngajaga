@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">

@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Hak Akses'])
<div class="rounded-xl bg-white shadow">
  <div class="flex flex-col gap-y-1.5 p-6">
    <h3 class="font-semibold leading-none tracking-tight text-black">Products</h3>
    <p class="text-sm "> Manage your products and view their sales performance. </p>
  </div>
  <div class="p-6 pt-0">
    <div class="relative w-full overflow-auto ">
      <table class="w-full caption-bottom text-sm">
        <thead class="[&amp;_tr]:border-b">
          <tr class="border-b border-[#e4e4e7] transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden w-[100px] sm:table-cell">
              <span class="sr-only">img</span>
            </th>
            <th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">Name</th>
            <th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">Status</th>
            <th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> Price </th>
            <th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> Total Sales </th>
            <th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> Created at </th>
            <th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <span class="sr-only">Actions</span>
            </th>
          </tr>
        </thead>
        <tbody class="[&amp;_tr:last-child]:border-0">
          <tr class="border-b border-[#e4e4e7] text-black transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden sm:table-cell">
              <img alt="Product image" class="aspect-square rounded-md object-cover" height="64" src="/placeholder.svg" width="64">
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 font-medium"> Laser Lemonade Machine </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground"> Draft </div>
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> $499.99 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 25 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 2023-07-12 10:42 AM </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9 outline-none" aria-haspopup="true" id="radix-vue-dropdown-menu-trigger-15" type="button" aria-expanded="false" data-state="closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon h-4 w-4">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
                <span class="sr-only">Toggle menu</span>
              </button>
            </td>
          </tr>
          <tr class="border-b border-[#e4e4e7] text-black transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden sm:table-cell">
              <img alt="Product image" class="aspect-square rounded-md object-cover" height="64" src="/placeholder.svg" width="64">
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 font-medium"> Hypernova Headphones </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground"> Active </div>
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> $129.99 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 100 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 2023-10-18 03:21 PM </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9 outline-none" aria-haspopup="true" id="radix-vue-dropdown-menu-trigger-16" type="button" aria-expanded="false" data-state="closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon h-4 w-4">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
                <span class="sr-only">Toggle menu</span>
              </button>
            </td>
          </tr>
          <tr class="border-b border-[#e4e4e7] text-black  transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden sm:table-cell">
              <img alt="Product image" class="aspect-square rounded-md object-cover" height="64" src="/placeholder.svg" width="64">
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 font-medium"> AeroGlow Desk Lamp </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground"> Active </div>
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> $39.99 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 50 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 2023-11-29 08:15 AM </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9 outline-none" aria-haspopup="true" id="radix-vue-dropdown-menu-trigger-17" type="button" aria-expanded="false" data-state="closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon h-4 w-4">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
                <span class="sr-only">Toggle menu</span>
              </button>
            </td>
          </tr>
          <tr class="border-b border-[#e4e4e7] text-black  transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden sm:table-cell">
              <img alt="Product image" class="aspect-square rounded-md object-cover" height="64" src="/placeholder.svg" width="64">
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 font-medium"> TechTonic Energy Drink </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80"> Draft </div>
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> $2.99 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 0 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 2023-12-25 11:59 PM </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9 outline-none" aria-haspopup="true" id="radix-vue-dropdown-menu-trigger-18" type="button" aria-expanded="false" data-state="closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon h-4 w-4">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
                <span class="sr-only">Toggle menu</span>
              </button>
            </td>
          </tr>
          <tr class="border-b border-[#e4e4e7] text-black  transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden sm:table-cell">
              <img alt="Product image" class="aspect-square rounded-md object-cover" height="64" src="/placeholder.svg" width="64">
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 font-medium"> Gamer Gear Pro Controller </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground"> Active </div>
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> $59.99 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 75 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 2024-01-01 12:00 AM </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9 outline-none" aria-haspopup="true" id="radix-vue-dropdown-menu-trigger-19" type="button" aria-expanded="false" data-state="closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon h-4 w-4">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
                <span class="sr-only">Toggle menu</span>
              </button>
            </td>
          </tr>
          <tr class="border-b border-[#e4e4e7] text-black  transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden sm:table-cell">
              <img alt="Product image" class="aspect-square rounded-md object-cover" height="64" src="/placeholder.svg" width="64">
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 font-medium"> Luminous VR Headset </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground"> Active </div>
            </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> $199.99 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 30 </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5 hidden md:table-cell"> 2024-02-14 02:14 PM </td>
            <td class="p-2 align-middle [&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-0.5">
              <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 w-9 outline-none" aria-haspopup="true" id="radix-vue-dropdown-menu-trigger-20" type="button" aria-expanded="false" data-state="closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon h-4 w-4">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
                <span class="sr-only">Toggle menu</span>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="flex items-center p-6 pt-0">
    <div class="text-xs text-muted-foreground"> Showing <strong>1-10</strong> of <strong>32</strong> products </div>
  </div>
</div>
@endsection