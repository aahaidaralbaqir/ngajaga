@extends('layout.dashboard')
@section('content')
{{ Form::open(['route' => 'profile.update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    <div class="second-nav py-[2.7rem] px-14 w-full">
        <div class="w-4/5">
            <div class="flex justify-between items-center">
                <h1>
                   Data Diri 
                </h1>
                <div class="flex items-center justify-between gap-5 relative">
                    <button class="button text-base bg-[#ff91e7] text-black p-3 rounded border border-black">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <main class="w-full py-14 px-14">
        <section class="w-4/5">
                <section class="flex gap-2 justify-between border-b py-5">
                    <header class="text-[#000000] font-light flex-1">
                        <h1 class="text-2xl mb-2 font-normal">Identitas Kamu</h1>
                    </header>
                    <fieldset class="w-3/5">
                        <div class="mb-2">
                            <legend class="mb-2">
                                <label for="image" class="text-[#000000] font-light">Foto Profile <span class="text-danger">*</span></label>
                            </legend>
                            <div class="flex gap-5">
                                <div class="uploader bg-white rounded-md border border-dashed w-40 h-40 border-black flex justify-center items-center relative">
                                    <button type="button" id="btn-upload" class="button text-base hover:text-black bg-black hover:bg-[#ff91e7] text-white px-4 py-2 rounded border border-black flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                        Upload
                                    </button> 
                                    <img src="{{ empty($item) ? '' : $item->avatar }}" id="preview" class="absolute rounded-md w-full h-full object-contain {{ empty($item->avatar) ? 'hidden' : '' }}" />
                                    <svg class="close cursor-pointer {{ empty($item->avatar) ? 'hidden' : '' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="red" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                                </div>
                                <input type="file" name="avatar" class="hidden">
                                <span class="text-sm text-black">Masukan Foto Profile Kamu</span>
                            </div>
                            @error('avatar')
                                <span class="text-sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
            inputPassword.value = generatePassword()
        })

        function generatePassword() {
             // Define all possible characters that can be used in the password
            const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
            const numberChars = '0123456789';
            const symbolChars = '!@#$%^&*()-_=+[{]}|;:,<.>/?';

            // Combine all characters into a single string
            const allChars = uppercaseChars + lowercaseChars + numberChars + symbolChars;

            // Function to pick a random character from a given string
            function getRandomChar(characters) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                return characters.charAt(randomIndex);
            }

            let password = '';

            // Generate characters for each required type
            password += getRandomChar(uppercaseChars); // At least one uppercase letter
            password += getRandomChar(lowercaseChars); // At least one lowercase letter
            password += getRandomChar(numberChars);    // At least one number
            password += getRandomChar(symbolChars);    // At least one symbol

            // Fill the rest of the password with random characters from allChars
            for (let i = 0; i < 4; i++) { // Since we added one of each type, we need 4 more characters to reach the minimum of 8
                password += getRandomChar(allChars);
            }

            // Shuffle the password to ensure the added characters are not predictable
            password = password.split('').sort(() => Math.random() - 0.5).join('');

            return password;
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

        const btnUpload = document.getElementById('btn-upload')
        const uploader = document.querySelector('input[name="avatar"]')
        btnUpload.addEventListener('click', function (event) {
            event.preventDefault()
            uploader.click()
        })

        const closeIcon = document.querySelector('.close')
        const previewImage = document.getElementById('preview');
        uploader.addEventListener('change', function () {
            const fileInput = this;

            if (fileInput.files.length > 0) {

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.classList.remove('hidden')
                    closeIcon.classList.remove('hidden')
                    previewImage.setAttribute('src', e.target.result)
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
              
            }
        })

        closeIcon.addEventListener('click', function () {
            previewImage.setAttribute('src', '')
            previewImage.classList.add('hidden')
            closeIcon.classList.add('hidden')
        })
    })
</script>
@endpush