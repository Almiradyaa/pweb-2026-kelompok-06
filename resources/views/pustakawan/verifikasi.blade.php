@php
    $adminName = $adminName ?? 'Admin007';
    $verifyAction = $verifyAction ?? url('/preview-pustakawan-pengaturan');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — Verifikasi Pustakawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .otp-card-wrap {
            width: 100%;
            max-width: 22rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .otp-input-box {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .otp-lock-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #D8B584;
            pointer-events: none;
            display: inline-flex;
            align-items: center;
        }

        .otp-code-input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            border-radius: 9999px;
            border: 1px solid #D8B584;
            background-color: #FFFFFF;
            color: #2C3E50;
            font-size: 0.875rem;
            line-height: 1.25rem;
            box-sizing: border-box;
        }

        .otp-code-input::placeholder {
            color: #C8C0B4;
        }

        .otp-submit-btn {
            width: 100%;
            padding: 0.625rem 1.25rem;
            border-radius: 9999px;
            border: none;
            background-color: #465362;
            color: #FFFFFF;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.25rem;
            cursor: pointer;
            box-sizing: border-box;
        }

        .otp-submit-btn:hover {
            background-color: #384350;
        }
    </style>
</head>
<body class="min-h-screen bg-white text-[#2C3E50] antialiased overflow-x-hidden flex flex-col">
    {{-- Pita Pola Titik Atas --}}
    <div class="w-full shrink-0">
        <img
            src="{{ asset('images/Pita.png') }}"
            alt="Pita Hiasan Atas"
            class="w-full h-11 object-cover block"
            onerror="this.style.display='none'"
        >
    </div>

    {{-- Konten Tengah Verifikasi Kode --}}
    <main class="flex-1 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md flex flex-col items-start">
            <img
                src="{{ asset('images/Doodle masuk.png') }}"
                alt="Maskot Pustakawan"
                class="w-18 h-18 object-contain mb-1.5 block"
                onerror="this.style.display='none'"
            >

            <h1 class="text-lg sm:text-xl font-extrabold text-[#2C3E50]">
                Halo, {{ $adminName }}!
            </h1>

            <p class="mt-5 text-xs sm:text-sm font-medium text-[#3E4C59] leading-relaxed max-w-xs">
                Kode verifikasi telah dikirim ke email kerja Anda.
            </p>

            <form id="admin-otp-form" method="POST" action="{{ $verifyAction }}" class="w-full mt-1 space-y-3.5">
                @csrf
                <div class="otp-input-box">
                    <span class="otp-lock-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input
                        id="admin-otp-code"
                        name="code"
                        type="text"
                        required
                        autocomplete="one-time-code"
                        placeholder="Kode*"
                        class="otp-code-input focus:outline-none focus:ring-2 focus:ring-[#D8B584]/50 transition"
                    >
                </div>

                <button
                    type="submit"
                    class="otp-submit-btn transition"
                >
                    Lanjut
                </button>
            </form>

            <p id="admin-otp-feedback" class="hidden mt-3 text-xs font-medium text-[#C96A5B]"></p>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('admin-otp-form');
            const codeInput = document.getElementById('admin-otp-code');
            const feedback = document.getElementById('admin-otp-feedback');

            form?.addEventListener('submit', (e) => {
                const action = form.getAttribute('action') || '';
                if (!codeInput.value.trim()) {
                    e.preventDefault();
                    feedback.textContent = 'Silakan masukkan kode verifikasi terlebih dahulu.';
                    feedback.classList.remove('hidden');
                    return;
                }
                if (action.includes('/preview-')) {
                    e.preventDefault();
                    window.location.href = action;
                }
            });
        });
    </script>
</body>
</html>