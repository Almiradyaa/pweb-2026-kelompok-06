<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Atur Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-[#2C3E50] antialiased flex flex-col">
    {{-- Pita di bagian atas --}}
    <div class="w-full">
        <img
            src="{{ asset('images/Pita.png') }}"
            alt="Pita Hiasan Atas"
            class="w-full h-11 object-cover"
        >
    </div>

    <main class="flex-1 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md flex flex-col items-start">
            <img
                src="{{ asset('images/Doodle bulat.png') }}"
                alt="Maskot Daftar"
                class="w-14 h-14 rounded-full object-cover mb-1.5 shrink-0"
            >

            <h1 class="text-xl font-bold text-[#2C3E50] mb-5">
                Daftar
            </h1>

            <form method="POST" action="{{ url('/register/profile') }}" enctype="multipart/form-data" class="w-full flex flex-col items-center">
                @csrf

                {{-- Avatar Profil Bulat Fix + Label Ubah Foto Profil --}}
                <div class="flex flex-col items-center mb-5">
                    <label for="avatar" class="cursor-pointer group relative block w-28 h-28 shrink-0">
                        <img
                            id="avatar-preview"
                            src="{{ asset('images\foto profil.png') }}"
                            alt="Foto Profil"
                            class="w-28 h-28 rounded-full object-cover object-center border border-[#C8A064]/60 group-hover:opacity-90 transition"
                        >
                    </label>
                    <input
                        id="avatar"
                        name="avatar"
                        type="file"
                        accept="image/*"
                        class="hidden"
                    >
                    <label for="avatar" class="mt-2 text-[14px] text-[#2C3E50] font-semibold underline underline-offset-2 hover:text-slate-900 cursor-pointer">
                        Ubah Foto Profil
                    </label>
                    @error('avatar')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full space-y-3.5">
                    <div>
                        <div class="relative flex items-center">
                            <span class="pointer-events-none absolute left-4 text-[#C8A064]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                required
                                placeholder="Nama*"
                                class="w-full pl-11 pr-4 py-3 rounded-full border border-[#C8A064]/80 bg-white text-sm text-slate-700 placeholder:text-[#C8A064]/80 focus:border-[#3E4C59] focus:outline-none"
                            >
                        </div>
                        @error('name')
                            <p class="mt-1 px-3 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="relative flex items-center">
                            <span class="pointer-events-none absolute left-4 text-[#C8A064]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input
                                id="birth_date"
                                name="birth_date"
                                type="{{ old('birth_date') ? 'date' : 'text' }}"
                                value="{{ old('birth_date') }}"
                                max="{{ date('Y-m-d') }}"
                                required
                                placeholder="Tanggal Lahir*"
                                onfocus="this.type='date'; if (typeof this.showPicker === 'function') { this.showPicker(); }"
                                onblur="if (!this.value) { this.type='text'; }"
                                class="w-full pl-11 pr-4 py-3 rounded-full border border-[#C8A064]/80 bg-white text-sm text-slate-700 placeholder:text-[#C8A064]/80 focus:border-[#3E4C59] focus:outline-none"
                            >
                        </div>
                        @error('birth_date')
                            <p class="mt-1 px-3 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-1.5">
                        <button
                            type="submit"
                            class="w-full py-3 px-5 rounded-full bg-[#3E4C59] hover:bg-[#2F3A44] text-white text-sm font-semibold transition cursor-pointer"
                        >
                            Lanjut
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');

            avatarInput?.addEventListener('change', (e) => {
                const file = e.target.files?.[0];
                if (!file || !avatarPreview) return;
                avatarPreview.src = URL.createObjectURL(file);
            });

            const birthDateInput = document.getElementById('birth_date');
            const birthDatePlaceholder = document.getElementById('birth-date-placeholder');

            function toggleDatePlaceholder() {
                if (!birthDateInput || !birthDatePlaceholder) return;
                birthDatePlaceholder.classList.toggle('hidden', Boolean(birthDateInput.value));
            }

            birthDateInput?.addEventListener('change', toggleDatePlaceholder);
            birthDateInput?.addEventListener('input', toggleDatePlaceholder);
            birthDateInput?.addEventListener('click', () => {
                if (typeof birthDateInput.showPicker === 'function') {
                    birthDateInput.showPicker();
                }
            });

            toggleDatePlaceholder();
        });
    </script>
</body>
</html>