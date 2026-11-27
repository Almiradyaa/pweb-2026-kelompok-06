<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
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

    {{-- Konten utama di tengah layar --}}
    <main class="flex-1 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md flex flex-col items-start">
            {{-- Maskot rata kiri sejajar dengan input email --}}
            <img
                src="{{ asset('images/Doodle masuk.png') }}"
                alt="Maskot Masuk"
                class="w-18 h-18 object-contain mb-1.5"
            >

            <h1 class="text-xl font-bold text-[#2C3E50] mb-5">
                Masuk
            </h1>

            <form method="POST" action="{{ route('login') }}" class="w-full space-y-3">
                @csrf

                <div>
                    <div class="relative flex items-center">
                        <span class="pointer-events-none absolute left-4 text-[#C8A064]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Email*"
                            class="w-full pl-11 pr-4 py-3 rounded-full border border-[#C8A064]/80 bg-white text-sm text-slate-700 placeholder:text-[#C8A064]/80 focus:border-[#3E4C59] focus:outline-none"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 px-3 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="relative flex items-center">
                        <span class="pointer-events-none absolute left-4 text-[#C8A064]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Kata sandi*"
                            class="w-full pl-11 pr-4 py-3 rounded-full border border-[#C8A064]/80 bg-white text-sm text-slate-700 placeholder:text-[#C8A064]/80 focus:border-[#3E4C59] focus:outline-none"
                        >
                    </div>
                    @error('password')
                        <p class="mt-1 px-3 text-[11px] text-red-600">{{ $message }}</p>
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
            </form>

            <p class="w-full mt-5 text-[14px] text-[#2C3E50] text-center">
                Belum punya akun?
                <a 
                    href="{{ Route::has('register') ? route('register') : url('/preview-daftar-email') }}" 
                    class="font-semibold underline underline-offset-2 hover:text-slate-900">
                    Daftar
                </a>
            </p>
        </div>
    </main>
</body>
</html>