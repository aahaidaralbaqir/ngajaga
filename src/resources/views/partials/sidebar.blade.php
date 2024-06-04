<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'" class="absolute left-0 top-0 z-9999 flex h-screen w-65 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0" @click.outside="sidebarToggle = false">
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="{{ route('admin') }}">
        <img src="/img/logo/logo.svg" alt="Logo" />
        </a>
        <button class="block lg:hidden" @click.stop="sidebarToggle = !sidebarToggle">
        <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z" fill="" />
        </svg>
        </button>
    </div>
    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear h-full flex justify-between">
        <nav class="mt-2 px-4" x-data="{selected: 'Dashboard'}" x-init="
            selected = JSON.parse(localStorage.getItem('selected'));
            $watch('selected', value => localStorage.setItem('selected', JSON.stringify(value)))">
            <div>
                <ul class="mb-6 flex flex-col gap-1.5">
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 @php echo route_is('admin') ? 'bg-graydark dark:bg-meta-4' : '' @endphp" href="{{ route('admin') }}">
                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.10322 0.956299H2.53135C1.5751 0.956299 0.787598 1.7438 0.787598 2.70005V6.27192C0.787598 7.22817 1.5751 8.01567 2.53135 8.01567H6.10322C7.05947 8.01567 7.84697 7.22817 7.84697 6.27192V2.72817C7.8751 1.7438 7.0876 0.956299 6.10322 0.956299ZM6.60947 6.30005C6.60947 6.5813 6.38447 6.8063 6.10322 6.8063H2.53135C2.2501 6.8063 2.0251 6.5813 2.0251 6.30005V2.72817C2.0251 2.44692 2.2501 2.22192 2.53135 2.22192H6.10322C6.38447 2.22192 6.60947 2.44692 6.60947 2.72817V6.30005Z" fill="" />
                            <path d="M15.4689 0.956299H11.8971C10.9408 0.956299 10.1533 1.7438 10.1533 2.70005V6.27192C10.1533 7.22817 10.9408 8.01567 11.8971 8.01567H15.4689C16.4252 8.01567 17.2127 7.22817 17.2127 6.27192V2.72817C17.2127 1.7438 16.4252 0.956299 15.4689 0.956299ZM15.9752 6.30005C15.9752 6.5813 15.7502 6.8063 15.4689 6.8063H11.8971C11.6158 6.8063 11.3908 6.5813 11.3908 6.30005V2.72817C11.3908 2.44692 11.6158 2.22192 11.8971 2.22192H15.4689C15.7502 2.22192 15.9752 2.44692 15.9752 2.72817V6.30005Z" fill="" />
                            <path d="M6.10322 9.92822H2.53135C1.5751 9.92822 0.787598 10.7157 0.787598 11.672V15.2438C0.787598 16.2001 1.5751 16.9876 2.53135 16.9876H6.10322C7.05947 16.9876 7.84697 16.2001 7.84697 15.2438V11.7001C7.8751 10.7157 7.0876 9.92822 6.10322 9.92822ZM6.60947 15.272C6.60947 15.5532 6.38447 15.7782 6.10322 15.7782H2.53135C2.2501 15.7782 2.0251 15.5532 2.0251 15.272V11.7001C2.0251 11.4188 2.2501 11.1938 2.53135 11.1938H6.10322C6.38447 11.1938 6.60947 11.4188 6.60947 11.7001V15.272Z" fill="" />
                            <path d="M15.4689 9.92822H11.8971C10.9408 9.92822 10.1533 10.7157 10.1533 11.672V15.2438C10.1533 16.2001 10.9408 16.9876 11.8971 16.9876H15.4689C16.4252 16.9876 17.2127 16.2001 17.2127 15.2438V11.7001C17.2127 10.7157 16.4252 9.92822 15.4689 9.92822ZM15.9752 15.272C15.9752 15.5532 15.7502 15.7782 15.4689 15.7782H11.8971C11.6158 15.7782 11.3908 15.5532 11.3908 15.272V11.7001C11.3908 11.4188 11.6158 11.1938 11.8971 11.1938H15.4689C15.7502 11.1938 15.9752 11.4188 15.9752 11.7001V15.272Z" fill="" />
                        </svg> Dashboard </a>
                    </li>
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="{{ route('user.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-text"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/><path d="M8 7h6"/><path d="M8 11h8"/></svg>
                            Buku Kas 
                        </a>
                    </li>
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="#" @click.prevent="selected = (selected === 'Users' ? '':'Users')">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.43425 7.5093H2.278C2.44675 7.5093 2.55925 7.3968 2.58737 7.31243L2.98112 6.32805H5.90612L6.27175 7.31243C6.328 7.48118 6.46862 7.5093 6.58112 7.5093H7.453C7.76237 7.48118 7.87487 7.25618 7.76237 7.03118L5.428 1.4343C5.37175 1.26555 5.3155 1.23743 5.14675 1.23743H3.88112C3.76862 1.23743 3.59987 1.29368 3.57175 1.4343L1.153 7.08743C1.0405 7.2843 1.20925 7.5093 1.43425 7.5093ZM4.47175 2.98118L5.3155 5.17493H3.59987L4.47175 2.98118Z" fill="" />
                            <path d="M10.1249 2.5031H16.8749C17.2124 2.5031 17.5218 2.22185 17.5218 1.85623C17.5218 1.4906 17.2405 1.20935 16.8749 1.20935H10.1249C9.7874 1.20935 9.47803 1.4906 9.47803 1.85623C9.47803 2.22185 9.75928 2.5031 10.1249 2.5031Z" fill="" />
                            <path d="M16.8749 6.21558H10.1249C9.7874 6.21558 9.47803 6.49683 9.47803 6.86245C9.47803 7.22808 9.75928 7.50933 10.1249 7.50933H16.8749C17.2124 7.50933 17.5218 7.22808 17.5218 6.86245C17.5218 6.49683 17.2124 6.21558 16.8749 6.21558Z" fill="" />
                            <path d="M16.875 11.1656H1.77187C1.43438 11.1656 1.125 11.4469 1.125 11.8125C1.125 12.1781 1.40625 12.4594 1.77187 12.4594H16.875C17.2125 12.4594 17.5219 12.1781 17.5219 11.8125C17.5219 11.4469 17.2125 11.1656 16.875 11.1656Z" fill="" />
                            <path d="M16.875 16.1156H1.77187C1.43438 16.1156 1.125 16.3969 1.125 16.7625C1.125 17.1281 1.40625 17.4094 1.77187 17.4094H16.875C17.2125 17.4094 17.5219 17.1281 17.5219 16.7625C17.5219 16.3969 17.2125 16.1156 16.875 16.1156Z" fill="white" />
                            </svg> 
                            Akses Kontrol 
                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': (selected === 'Users') }" >
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z" fill="" />
                            </svg>
                        </a>
                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden" :class="(selected === 'Users') ? 'block' :'hidden'">
                            <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                            @php echo in_array(route_name(), ['permission.index', 'permission.create.form', 'permission.update.form']) ? 'text-white' : '' @endphp" href="{{ route('permission.index') }}">Hak Akses</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                    @php echo in_array(route_name(), ['roles.index', 'roles.create.form', 'roles.update.form']) ? 'text-white' : '' @endphp" href="{{ route('roles.index') }}">Jenis Peran</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="#" @click.prevent="selected = (selected === 'Produk' ? '':'Produk')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-open"><path d="M12 22v-9"/><path d="M15.17 2.21a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.655 1.655 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z"/><path d="M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13"/><path d="M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.636 1.636 0 0 0 1.63 0z"/></svg>
                                Produk 
                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': (selected === 'Produk') }" >
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z" fill="" />
                            </svg>
                        </a>
                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden" :class="(selected === 'Produk') ? 'block' :'hidden'">
                            <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                            @php echo in_array(route_name(), ['permission.index', 'permission.create.form', 'permission.update.form']) ? 'text-white' : '' @endphp" href="{{ route('permission.index') }}">Daftar Rak</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                    @php echo in_array(route_name(), ['roles.index', 'roles.create.form', 'roles.update.form']) ? 'text-white' : '' @endphp" href="{{ route('roles.index') }}">Daftar Kategori</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                    @php echo in_array(route_name(), ['roles.index', 'roles.create.form', 'roles.update.form']) ? 'text-white' : '' @endphp" href="{{ route('roles.index') }}">Daftar Penyuplai</a>
                                </li>
                                
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="#" @click.prevent="selected = (selected === 'Inventori' ? '':'Inventori')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                Inventori 
                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': (selected === 'Inventori') }" >
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z" fill="" />
                            </svg>
                        </a>
                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden" :class="(selected === 'Inventori') ? 'block' :'hidden'">
                            <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                            @php echo in_array(route_name(), ['permission.index', 'permission.create.form', 'permission.update.form']) ? 'text-white' : '' @endphp" href="{{ route('permission.index') }}">Pemesanan Stok</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                    @php echo in_array(route_name(), ['roles.index', 'roles.create.form', 'roles.update.form']) ? 'text-white' : '' @endphp" href="{{ route('roles.index') }}">Faktur Pembelian</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white
                                    @php echo in_array(route_name(), ['roles.index', 'roles.create.form', 'roles.update.form']) ? 'text-white' : '' @endphp" href="{{ route('roles.index') }}">Daftar Stok</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                        <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 @php echo in_array(route_name(), ['user.index', 'user.create.form', 'user.update.form']) ? 'bg-graydark dark:bg-meta-4' : '' @endphp" href="{{ route('user.index') }}">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.0002 7.79065C11.0814 7.79065 12.7689 6.1594 12.7689 4.1344C12.7689 2.1094 11.0814 0.478149 9.0002 0.478149C6.91895 0.478149 5.23145 2.1094 5.23145 4.1344C5.23145 6.1594 6.91895 7.79065 9.0002 7.79065ZM9.0002 1.7719C10.3783 1.7719 11.5033 2.84065 11.5033 4.16252C11.5033 5.4844 10.3783 6.55315 9.0002 6.55315C7.62207 6.55315 6.49707 5.4844 6.49707 4.16252C6.49707 2.84065 7.62207 1.7719 9.0002 1.7719Z" fill="" />
                                <path d="M10.8283 9.05627H7.17207C4.16269 9.05627 1.71582 11.5313 1.71582 14.5406V16.875C1.71582 17.2125 1.99707 17.5219 2.3627 17.5219C2.72832 17.5219 3.00957 17.2407 3.00957 16.875V14.5406C3.00957 12.2344 4.89394 10.3219 7.22832 10.3219H10.8564C13.1627 10.3219 15.0752 12.2063 15.0752 14.5406V16.875C15.0752 17.2125 15.3564 17.5219 15.7221 17.5219C16.0877 17.5219 16.3689 17.2407 16.3689 16.875V14.5406C16.2846 11.5313 13.8377 9.05627 10.8283 9.05627Z" fill="" />
                            </svg>
                            Pengguna 
                        </a>
                    </li>
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="{{ route('user.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-contact-round"><path d="M16 18a4 4 0 0 0-8 0"/><circle cx="12" cy="11" r="3"/><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="8" x2="8" y1="2" y2="4"/><line x1="16" x2="16" y1="2" y2="4"/></svg>
                            Pelanggan 
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 ml-4 text-sm text-sm text-bodydark2">TRANSAKSI &amp; LAPORAN</h3>
                <ul class="mb-6 flex flex-col gap-1.5">
                    <!-- Menu Item Chart -->
                    <li>
                        <a href="{{ route('report.index') }}" class="@php echo in_array(route_name(), ['report.index']) ? 'bg-graydark dark:bg-meta-4' : '' @endphp group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4">
                            <svg class="fill-current" width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_130_9801)">
                                <path d="M10.8563 0.55835C10.5188 0.55835 10.2095 0.8396 10.2095 1.20522V6.83022C10.2095 7.16773 10.4907 7.4771 10.8563 7.4771H16.8751C17.0438 7.4771 17.2126 7.39272 17.3251 7.28022C17.4376 7.1396 17.4938 6.97085 17.4938 6.8021C17.2688 3.28647 14.3438 0.55835 10.8563 0.55835ZM11.4751 6.15522V1.8521C13.8095 2.13335 15.6938 3.8771 16.1438 6.18335H11.4751V6.15522Z" fill="" />
                                <path d="M15.3845 8.7427H9.1126V2.69582C9.1126 2.35832 8.83135 2.07707 8.49385 2.07707C8.40947 2.07707 8.3251 2.07707 8.24072 2.07707C3.96572 2.04895 0.506348 5.53645 0.506348 9.81145C0.506348 14.0864 3.99385 17.5739 8.26885 17.5739C12.5438 17.5739 16.0313 14.0864 16.0313 9.81145C16.0313 9.6427 16.0313 9.47395 16.0032 9.33332C16.0032 8.99582 15.722 8.7427 15.3845 8.7427ZM8.26885 16.3083C4.66885 16.3083 1.77197 13.4114 1.77197 9.81145C1.77197 6.3802 4.47197 3.53957 7.8751 3.3427V9.36145C7.8751 9.69895 8.15635 10.0083 8.52197 10.0083H14.7938C14.6813 13.4958 11.7845 16.3083 8.26885 16.3083Z" fill="" />
                            </g>
                            <defs>
                                <clipPath id="clip0_130_9801">
                                <rect width="18" height="18" fill="white" transform="translate(0 0.052124)" />
                                </clipPath>
                            </defs>
                            </svg> 
                            Laporan 
                        </a>
                    </li>

                    <!-- Menu Item Chart -->
                    <!-- Menu Item Ui Elements -->
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4" href="#" @click.prevent="selected = (selected === 'UiElements' ? '':'UiElements')" :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'UiElements') || (page === 'alerts' || page === 'buttons' || page === 'card' || page === 'tabs' || page === 'modals') }">
                            <svg class="fill-current" width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_130_9807)">
                                <path d="M15.7501 0.55835H2.2501C1.29385 0.55835 0.506348 1.34585 0.506348 2.3021V7.53335C0.506348 8.4896 1.29385 9.2771 2.2501 9.2771H15.7501C16.7063 9.2771 17.4938 8.4896 17.4938 7.53335V2.3021C17.4938 1.34585 16.7063 0.55835 15.7501 0.55835ZM16.2563 7.53335C16.2563 7.8146 16.0313 8.0396 15.7501 8.0396H2.2501C1.96885 8.0396 1.74385 7.8146 1.74385 7.53335V2.3021C1.74385 2.02085 1.96885 1.79585 2.2501 1.79585H15.7501C16.0313 1.79585 16.2563 2.02085 16.2563 2.3021V7.53335Z" fill="" />
                                <path d="M6.13135 10.9646H2.2501C1.29385 10.9646 0.506348 11.7521 0.506348 12.7083V15.8021C0.506348 16.7583 1.29385 17.5458 2.2501 17.5458H6.13135C7.0876 17.5458 7.8751 16.7583 7.8751 15.8021V12.7083C7.90322 11.7521 7.11572 10.9646 6.13135 10.9646ZM6.6376 15.8021C6.6376 16.0833 6.4126 16.3083 6.13135 16.3083H2.2501C1.96885 16.3083 1.74385 16.0833 1.74385 15.8021V12.7083C1.74385 12.4271 1.96885 12.2021 2.2501 12.2021H6.13135C6.4126 12.2021 6.6376 12.4271 6.6376 12.7083V15.8021Z" fill="" />
                                <path d="M15.75 10.9646H11.8688C10.9125 10.9646 10.125 11.7521 10.125 12.7083V15.8021C10.125 16.7583 10.9125 17.5458 11.8688 17.5458H15.75C16.7063 17.5458 17.4938 16.7583 17.4938 15.8021V12.7083C17.4938 11.7521 16.7063 10.9646 15.75 10.9646ZM16.2562 15.8021C16.2562 16.0833 16.0312 16.3083 15.75 16.3083H11.8688C11.5875 16.3083 11.3625 16.0833 11.3625 15.8021V12.7083C11.3625 12.4271 11.5875 12.2021 11.8688 12.2021H15.75C16.0312 12.2021 16.2562 12.4271 16.2562 12.7083V15.8021Z" fill="" />
                            </g>
                            <defs>
                                <clipPath id="clip0_130_9807">
                                <rect width="18" height="18" fill="white" transform="translate(0 0.052124)" />
                                </clipPath>
                            </defs>
                            </svg> Transaksi <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current" :class="{ 'rotate-180': (selected === 'UiElements') }" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z" fill="" />
                            </svg>
                        </a>
                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden" :class="(selected === 'UiElements') ? 'block' :'hidden'">
                            <ul class="mt-4 mb-3 flex flex-col gap-2 pl-6">
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white @php echo in_array(route_name(), ['transaction.type.index', 'transaction.type.create.form', 'transaction.type.update.form']) ? 'text-white' : '' @endphp" href="{{ route('transaction.type.index') }}">Jenis Transaksi</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white @php echo in_array(route_name(), ['payment.index', 'payment.create.form', 'payment.update.form']) ? 'text-white' : '' @endphp" href="{{ route('payment.index') }}">Jenis Pembayaran</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white @php echo in_array(route_name(), ['transaction.index', 'transaction.create.form', 'transaction.update.form']) ? 'text-white' : '' @endphp"  href="{{ route('transaction.index') }}">Transaksi Masuk</a>
                                </li>
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-sm text-bodydark2 duration-300 ease-in-out hover:text-white @php echo in_array(route_name(), ['distribution.index', 'distribution.create.form', 'distribution.update.form']) ? 'text-white' : '' @endphp"  href="{{ route('distribution.index') }}">Distribusi Dana</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Menu Item Auth Pages -->
                    <li>
                        <a href="{{ route('beneficiary.index') }}" class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 text-sm text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 @php echo in_array(route_name(), ['beneficiary.index', 'beneficiary.create.form', 'beneficiary.update.form']) ? 'bg-graydark dark:bg-meta-4' : '' @endphp" >
                            <svg class="fill-current" width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.8749 7.44902C16.5374 7.44902 16.228 7.73027 16.228 8.0959V13.3834C16.228 14.4803 15.4124 15.3521 14.3999 15.3521H3.5999C2.55928 15.3521 1.77178 14.4803 1.77178 13.3834V8.06777C1.77178 7.73027 1.49053 7.4209 1.1249 7.4209C0.759277 7.4209 0.478027 7.70215 0.478027 8.06777V13.3553C0.478027 15.1271 1.85615 16.5896 3.57178 16.5896H14.3999C16.1155 16.5896 17.4937 15.1553 17.4937 13.3553V8.06777C17.5218 7.73027 17.2124 7.44902 16.8749 7.44902Z" fill=""></path>
                                <path d="M8.5498 11.6396C8.6623 11.7521 8.83105 11.8365 8.9998 11.8365C9.16855 11.8365 9.30918 11.7803 9.4498 11.6396L12.8811 8.23652C13.1342 7.9834 13.1342 7.58965 12.8811 7.33652C12.6279 7.0834 12.2342 7.0834 11.9811 7.33652L9.64668 9.64277V2.16152C9.64668 1.82402 9.36543 1.51465 8.9998 1.51465C8.6623 1.51465 8.35293 1.7959 8.35293 2.16152V9.69902L6.01855 7.36465C5.76543 7.11152 5.37168 7.11152 5.11855 7.36465C4.86543 7.61777 4.86543 8.01152 5.11855 8.26465L8.5498 11.6396Z" fill=""></path>
                            </svg>
                            Penerima Dana
                        </a>
                    </li>
                </ul>
            </div> 
        </nav>
        <!-- Sidebar Menu -->
        <div class="mx-auto mb-10 w-full max-w-60 text-center px-4">
            <a href="{{ route('logout') }}" rel="nofollow" class="flex items-center justify-center rounded-md bg-primary p-2 text-white hover:bg-opacity-95">Keluar</a>
        </div>
    </div>
</aside>