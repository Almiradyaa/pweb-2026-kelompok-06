@php
    $backUrl = $backUrl ?? url('/preview-pustakawan-pengaturan');
    $nextAction = $nextAction ?? url('/preview-pustakawan-pengaturan');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — Ubah Email Pustakawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .email-form-stack {
            width: 100%;
            max-width: 28rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .pill-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .pill-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #D8B584;
            pointer-events: none;
            display: inline-flex;
            align-items: center;
        }

        .pill-text-input {
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

        .pill-text-input::placeholder {
            color: #C8C0B4;
        }

        .pill-submit-btn {
            width: 100%;
            padding: 0.625rem 1.5rem;
            border-radius: 9999px;
            border: none;
            background-color: #465362;
            color: #FFFFFF;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.25rem;
            cursor: pointer;
            box-sizing: border-box;
        }

        .pill-submit-btn:hover {
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

    {{-- Header Kembali & Judul Ubah Email --}}
    <header class="w-full max-w-5xl mx-auto px-6 sm:px-10 pt-8">
        <div class="relative flex items-center justify-center min-h-12">
            <a
                href="{{ $backUrl }}"
                aria-label="Kembali"
                class="absolute left-0 p-2 -ml-2 text-[#2C3E50] hover:text-slate-600 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="flex items-center gap-3.5">
                <img
                    src="{{ asset('images/doodle-ubah-email.png') }}"
                    alt="Maskot Ubah Email"
                    class="w-11 h-11 object-contain shrink-0"
                    onerror="this.style.display='none'"
                >
                <h1 class="text-xl sm:text-2xl font-bold text-[#2C3E50]">
                    Ubah Email
                </h1>
            </div>
        </div>
    </header>

    {{-- Konten Tengah Form Ubah Email --}}
    <main class="flex-1 w-full flex flex-col items-center justify-center px-4 pb-14">
        <div class="email-form-stack">
            <form id="edit-email-form" method="POST" action="{{ $nextAction }}" class="w-full space-y-3.5">
                @csrf
                {{-- Input Email lama* --}}
                <div class="pill-input-wrap">
                    <span class="pill-input-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input
                        id="old-email-input"
                        name="old_email"
                        type="email"
                        required
                        placeholder="Email lama*"
                        class="pill-text-input focus:outline-none focus:ring-2 focus:ring-[#D8B584]/50 transition"
                    >
                </div>

                {{-- Input Email baru* --}}
                <div class="pill-input-wrap">
                    <span class="pill-input-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input
                        id="new-email-input"
                        name="new_email"
                        type="email"
                        required
                        placeholder="Email baru*"
                        class="pill-text-input focus:outline-none focus:ring-2 focus:ring-[#D8B584]/50 transition"
                    >
                </div>

                <button type="submit" class="pill-submit-btn transition">
                    Lanjut
                </button>
            </form>

            <p id="edit-email-feedback" class="hidden mt-3 text-xs font-medium text-[#C96A5B]"></p>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('edit-email-form');
            const oldEmail = document.getElementById('old-email-input');
            const newEmail = document.getElementById('new-email-input');
            const feedback = document.getElementById('edit-email-feedback');

            form?.addEventListener('submit', (e) => {
                const action = form.getAttribute('action') || '';
                if (!oldEmail.value.trim() || !newEmail.value.trim()) {
                    e.preventDefault();
                    feedback.textContent = 'Mohon isi email lama dan email baru.';
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