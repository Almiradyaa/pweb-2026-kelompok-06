<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP</title>
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
                src="{{ asset('images\Doodle masuk.png') }}"
                alt="Maskot Masuk"
                class="w-16 h-16 object-contain mb-2"
            >

            <h1 class="text-xl font-bold text-[#2C3E50] mb-2">
                Masuk
            </h1>

            <p class="text-sm text-[#2C3E50] mb-6">
                Kode OTP sudah dikirim ke email-mu.
            </p>

            <form id="otp-form" method="POST" action="{{ url('/verify-otp') }}" class="w-full">
                @csrf
                <input type="hidden" name="otp" id="otp-combined" value="{{ old('otp') }}">

                <div class="flex items-center justify-center gap-4 mb-6">
                    @for ($i = 0; $i < 4; $i++)
                        <input
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            maxlength="1"
                            aria-label="Digit OTP {{ $i + 1 }}"
                            class="otp-input w-14 h-14 shrink-0 aspect-square p-0 rounded-full border border-[#C8A064]/80 bg-white text-center text-lg font-semibold text-[#2C3E50] focus:border-[#3E4C59] focus:ring-2 focus:ring-[#C8A064]/40 focus:outline-none"
                        >
                    @endfor
                </div>

                @error('otp')
                    <p class="mb-4 text-xs text-red-600 text-center">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    class="w-full py-3 px-5 rounded-full bg-[#3E4C59] hover:bg-[#2F3A44] text-white text-sm font-semibold transition cursor-pointer"
                >
                    Lanjut
                </button>
            </form>

            <form method="POST" action="{{ url('/resend-otp') }}" class="w-full mt-4 flex justify-center">
                @csrf
                <button
                    type="submit"
                    class="w-full mt-1 text-[14px] text-[#2C3E50] font-semibold underline underline-offset-2 hover:text-slate-900 cursor-pointer"
                >
                    Kirim ulang kode
                </button>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = Array.from(document.querySelectorAll('.otp-input'));
            const form = document.getElementById('otp-form');
            const combined = document.getElementById('otp-combined');

            if (!inputs.length) return;
            inputs[0].focus();

            function syncOtp() {
                if (combined) {
                    combined.value = inputs.map((el) => el.value).join('');
                }
            }

            inputs.forEach((input, idx) => {
                input.addEventListener('input', (e) => {
                    e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 1);
                    if (e.target.value && idx < inputs.length - 1) {
                        inputs[idx + 1].focus();
                    }
                    syncOtp();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && idx > 0) {
                        inputs[idx - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    const pasted = (e.clipboardData || window.clipboardData)
                        .getData('text')
                        .replace(/[^0-9]/g, '')
                        .slice(0, inputs.length);
                    if (!pasted) return;
                    e.preventDefault();
                    pasted.split('').forEach((char, i) => {
                        inputs[i].value = char;
                    });
                    const nextIndex = Math.min(pasted.length, inputs.length - 1);
                    inputs[nextIndex].focus();
                    syncOtp();
                });
            });

            form?.addEventListener('submit', syncOtp);
        });
    </script>
</body>
</html>