@php
    $backUrl = $backUrl ?? url('/preview-pustakawan-pengaturan');
    $saveAction = $saveAction ?? url('/preview-pustakawan-pengaturan');
    $avatarUrl = $avatarUrl ?? asset('images/avatar-pustakawan.jpg');
    $defaultName = $defaultName ?? '';
    $defaultBirthDate = $defaultBirthDate ?? '';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — Ubah Profil Pustakawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .profile-form-stack {
            width: 100%;
            max-width: 28rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-avatar-circle {
            width: 7.5rem;
            height: 7.5rem;
            border-radius: 9999px;
            overflow: hidden;
            background-color: #E2E8F0;
            border: 2px solid #F1F5F9;
        }

        .profile-avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-photo-trigger {
            margin-top: 0.75rem;
            border: none;
            background: transparent;
            color: #465362;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: underline;
            cursor: pointer;
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

    {{-- Header Kembali & Judul Ubah Profil --}}
    <header class="w-full max-w-5xl mx-auto px-6 sm:px-10 pt-6">
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
                    src="{{ asset('images/doodle-ubah-profil.png') }}"
                    alt="Maskot Ubah Profil"
                    class="w-11 h-11 object-contain shrink-0"
                    onerror="this.style.display='none'"
                >
                <h1 class="text-xl sm:text-2xl font-bold text-[#2C3E50]">
                    Ubah Profil
                </h1>
            </div>
        </div>
    </header>

    {{-- Konten Tengah Foto Profil & Form --}}
    <main class="flex-1 w-full flex flex-col items-center justify-center px-4 pt-1 sm:pt-6 pb-10">
        <div class="profile-form-stack">
            {{-- Foto Profil Bulat --}}
            <div class="flex flex-col items-center mb-3">
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

            <form id="edit-profile-form" method="POST" action="{{ $saveAction }}" class="w-full mt-6 space-y-3.5">
                @csrf
                {{-- Input Nama* --}}
                <div class="pill-input-wrap">
                    <span class="pill-input-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input
                        id="profile-name-input"
                        name="name"
                        type="text"
                        required
                        value="{{ $defaultName }}"
                        placeholder="Nama*"
                        class="pill-text-input focus:outline-none focus:ring-2 focus:ring-[#D8B584]/50 transition"
                    >
                </div>

                {{-- Input Tanggal Lahir* --}}
                <div class="pill-input-wrap">
                    <span class="pill-input-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input
                        id="profile-birthdate-input"
                        name="birth_date"
                        type="text"
                        required
                        value="{{ $defaultBirthDate }}"
                        placeholder="Tanggal lahir*"
                        onfocus="this.type='date'"
                        onblur="if(!this.value)this.type='text'"
                        class="pill-text-input focus:outline-none focus:ring-2 focus:ring-[#D8B584]/50 transition"
                    >
                </div>

                <button type="submit" class="pill-submit-btn transition">
                    Simpan
                </button>
            </form>

            <p id="edit-profile-feedback" class="hidden mt-3 text-xs font-medium text-[#C96A5B]"></p>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const changePhotoBtn = document.getElementById('change-photo-btn');
            const fileInput = document.getElementById('avatar-file-input');
            const previewImg = document.getElementById('avatar-preview-img');
            const form = document.getElementById('edit-profile-form');
            const nameInput = document.getElementById('profile-name-input');
            const birthInput = document.getElementById('profile-birthdate-input');
            const feedback = document.getElementById('edit-profile-feedback');

            changePhotoBtn?.addEventListener('click', () => fileInput?.click());

            fileInput?.addEventListener('change', (e) => {
                const file = e.target.files?.[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (ev) => {
                    if (ev.target?.result) {
                        previewImg.src = ev.target.result;
                    }
                };
                reader.readAsDataURL(file);
            });

            form?.addEventListener('submit', (e) => {
                const action = form.getAttribute('action') || '';
                if (!nameInput.value.trim() || !birthInput.value.trim()) {
                    e.preventDefault();
                    feedback.textContent = 'Mohon lengkapi nama dan tanggal lahir.';
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