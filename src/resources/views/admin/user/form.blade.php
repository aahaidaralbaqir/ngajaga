@extends('layout.dashboard')
@section('content')
{{ Form::open(['route' => $target_route, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    <div class="second-nav py-[2.7rem] px-14 w-full">
        <div class="w-4/5">
            <div class="flex justify-between items-center">
                <h1>
                    {{ $page_title }}
                </h1>
                <div class="flex items-center justify-between gap-5 relative">
                    <a href="{{ route('user.index') }}" class="button text-base text-black p-3 rounded border border-black relative flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        Kembali
                    </a>
                    <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14">
        <section class="w-4/5">
                <section class="flex gap-2 justify-between border-b py-5">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Detail Pengguna</h1>
                    </header>
                    <fieldset class="w-3/5">
                        <div>
                            <legend class="mb-2">
                                <label for="name" class="text-[#000000] font-light">Nama <span class="text-danger">*</span></label>
                            </legend>
                            @if (!empty($item))
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            @endif
                            <input type="text" name="name" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ empty($item) ? ''  : $item->name }}" />
                            @error('name')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <legend class="mb-2">
                                <label for="email" class="text-[#000000] font-light">Email <span class="text-danger">*</span></label>
                            </legend>
                            <input type="email" name="email" class="mb-2 input border rounded-sm px-4 py-2 w-full" value="{{ empty($item) ? ''  : $item->email }}" />
                            @error('email')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>
                </section>
                @if (in_array(\App\Constant\Permission::CHANGE_PASSWORD, $user['permission']))
                <section class="flex gap-2 justify-between py-20 border-b   ">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Keamanan</h1>
                        <p>
                            Minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan simbol.
                        </p>
                    </header>
                    <fieldset class="w-3/5">
                        @if (!empty($item))
                        <div>
                            <legend class="mb-2">
                                <label for="role" class="text-[#000000] font-light">
                                    Password Lama
                                </label>
                            </legend>
                            <div class="flex gap-2 relative mb-2">
                                <input type="password" name="old_password" value="" />
                                <button target="old_password" class="absolute right-5 top-3" id="toggle-password-btn">
                                    <svg class="open-eye h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg class="close-eye hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                </button>
                            </div>
                            @error('old_password')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        <div>
                            <legend class="mb-2">
                                <label for="role" class="text-[#000000] font-light">
                                    Password
                                    @if (!empty($item))
                                        Baru
                                    @endif
                                </label>
                            </legend>
                            <div class="flex gap-2 relative mb-2">
                                <input type="password" name="password" value="" />
                                <button target="password" class="absolute right-30 top-3" id="toggle-password-btn">
                                    <svg class="open-eye h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg class="close-eye hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                </button>
                                <a class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black" id="btn-generate-password">Generate</a>
                            </div>
                            @error('password')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror 
                        </div>
                    </fieldset>
                </section>
                @endif

                <section class="flex gap-2 justify-between py-20">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Peran</h1>
                        <p>
                            Berikan peran sesuai dengan wewenang yang dimiliki
                        </p>
                    </header>
                    <fieldset class="w-3/5">
                        <div>
                            <legend class="mb-2">
                                <label for="role" class="text-[#000000] font-light">Peran <span class="text-danger">*</span></label>
                            </legend>
                            <select name="role_id" id="role">
                                <option disabled>Pilih Peran</option>
                                @foreach($roles as $role)
                                    <option 
                                        value="{{ $role->id }}"
                                        @if (!empty($item) && $role->id == $item->role_id)
                                            selected="selected"
                                        @endif
                                    >
                                            {{ $role->name }}
                                    </option>
                                @endforeach
                            </select> 
                            @error('role_id')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>                          
                    </fieldset>
                </section>
        </section>
    </main>
{{ Form::close() }}
@endsection

@push('scripts')
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function () {
        const generatePasswordBtn = document.getElementById('btn-generate-password')
        const inputPassword = document.querySelector('input[name="password"]')
        generatePasswordBtn.addEventListener('click', function (event) {
            inputPassword.value = generatePassword(15)
        })

        function generatePassword(passwordLength) {
            let numberChars = "0123456789";
            let upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            let lowerChars = "abcdefghijklmnopqrstuvwxyz";
            let allChars = numberChars + upperChars + lowerChars;
            let randPasswordArray = Array(passwordLength);
            randPasswordArray[0] = numberChars;
            randPasswordArray[1] = upperChars;
            randPasswordArray[2] = lowerChars;
            randPasswordArray = randPasswordArray.fill(allChars, 3);
            return shuffleArray(randPasswordArray.map(function(x) { return x[Math.floor(Math.random() * x.length)] })).join('');
        }

        function shuffleArray(array) {
            for (var i = array.length - 1; i > 0; i--) {
                var j = Math.floor(Math.random() * (i + 1));
                var temp = array[i];
                array[i] = array[j];
                array[j] = temp;
            }
            return array;
        }

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
@endpush