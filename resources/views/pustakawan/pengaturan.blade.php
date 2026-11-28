@php
    $backUrl = $backUrl ?? url('/preview-pustakawan-verifikasi');
    $logoutUrl = $logoutUrl ?? url('/preview-landing');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — Pengaturan Pustakawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .settings-actions-stack {
            width: 100%;
            max-width: 28rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.875rem;
        }

        .settings-pill-primary {
            width: 100%;
            padding: 0.625rem 1.5rem;
            border-radius: 9999px;
            border: none;
            background-color: #465362;
            color: #FFFFFF;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.25rem;
            text-align: center;
            cursor: pointer;
            box-sizing: border-box;
        }

        .settings-pill-primary:hover {
            background-color: #384350;
        }

        .settings-pill-logout {
            display: block;
            width: 100%;
            padding: 0.625rem 1.5rem;
            border-radius: 9999px;
            border: 1px solid #D8B584;
            background-color: #FFFFFF;
            color: #C96A5B;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.25rem;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
        }

        .settings-pill-logout:hover {
            background-color: #FAF9F6;
        }

        .settings-delete-link {
            margin-top: 0.25rem;
            border: none;
            background: transparent;
            color: #C96A5B;
            font-size: 0.75rem;
            font-weight: 500;
            text-decoration: underline;
            cursor: pointer;
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

    {{-- Header Kembali & Judul Pengaturan --}}
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
                    src="{{ asset('images/doodle-pengaturan.png') }}"
                    alt="Maskot Pengaturan"
                    class="w-11 h-11 object-contain shrink-0"
                    onerror="this.style.display='none'"
                >
                <h1 class="text-xl sm:text-2xl font-bold text-[#2C3E50]">
                    Pengaturan
                </h1>
            </div>
        </div>
    </header>

    {{-- Daftar Tombol Aksi di Tengah --}}
    <main class="flex-1 w-full flex flex-col items-center justify-center px-4 pb-14">
        <div class="settings-actions-stack">
            <button
                type="button"
                data-open-sheet="modal-profil"
                class="settings-pill-primary transition"
            >
                Ubah profil
            </button>

            <button
                type="button"
                data-open-sheet="modal-email"
                class="settings-pill-primary transition"
            >
                Ubah email
            </button>

            <button
                type="button"
                data-open-sheet="modal-sandi"
                class="settings-pill-primary transition"
            >
                Ubah kata sandi
            </button>

            <a
                href="{{ $logoutUrl }}"
                class="settings-pill-logout transition"
            >
                Keluar
            </a>

            <button
                type="button"
                data-open-sheet="modal-hapus"
                class="settings-delete-link transition"
            >
                Hapus akun
            </button>
        </div>

        <p
            id="settings-toast"
            class="hidden mt-5 px-5 py-2.5 rounded-full bg-white border border-slate-100 shadow-md text-xs font-semibold text-[#2C3E50]"
        ></p>
    </main>

    {{-- Modal Sederhana untuk Pratinjau Aksi Pengaturan --}}
    <div id="settings-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 px-4">
        <div class="w-full max-w-sm rounded-2xl bg-white border border-slate-100 shadow-xl p-6 space-y-4">
            <h2 id="settings-modal-title" class="text-sm sm:text-base font-bold text-[#2C3E50]"></h2>
            <p id="settings-modal-desc" class="text-xs text-slate-600 leading-relaxed"></p>
            <div id="settings-modal-input-wrap" class="hidden">
                <input
                    id="settings-modal-input"
                    type="text"
                    class="w-full px-3.5 py-2 rounded-full border border-slate-300 text-xs sm:text-sm text-[#2C3E50] focus:outline-none focus:ring-2 focus:ring-[#D8B584]/50"
                >
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button
                    id="settings-modal-cancel"
                    type="button"
                    class="px-4 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-[#2C3E50] cursor-pointer"
                >
                    Batal
                </button>
                <button
                    id="settings-modal-confirm"
                    type="button"
                    class="px-4 py-2 rounded-full bg-[#465362] hover:bg-[#384350] text-xs font-semibold text-white cursor-pointer"
                >
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('settings-modal');
            const titleEl = document.getElementById('settings-modal-title');
            const descEl = document.getElementById('settings-modal-desc');
            const inputWrap = document.getElementById('settings-modal-input-wrap');
            const inputEl = document.getElementById('settings-modal-input');
            const cancelBtn = document.getElementById('settings-modal-cancel');
            const confirmBtn = document.getElementById('settings-modal-confirm');
            const toastEl = document.getElementById('settings-toast');

            let currentMode = null;

            const config = {
                'modal-profil': {
                    title: 'Ubah profil',
                    desc: 'Perbarui nama tampilan pustakawan.',
                    placeholder: 'Nama pustakawan...',
                    inputType: 'text',
                    confirmLabel: 'Simpan',
                    toast: 'Profil pustakawan diperbarui.',
                },
                'modal-email': {
                    title: 'Ubah email',
                    desc: 'Masukkan alamat email kerja baru.',
                    placeholder: 'email@batabutu.id',
                    inputType: 'email',
                    confirmLabel: 'Simpan',
                    toast: 'Email kerja diperbarui.',
                },
                'modal-sandi': {
                    title: 'Ubah kata sandi',
                    desc: 'Masukkan kata sandi baru untuk akun pustakawan.',
                    placeholder: 'Kata sandi baru...',
                    inputType: 'password',
                    confirmLabel: 'Simpan',
                    toast: 'Kata sandi diperbarui.',
                },
                'modal-hapus': {
                    title: 'Hapus akun',
                    desc: 'Tindakan ini akan menghapus akun pustakawan secara permanen.',
                    placeholder: '',
                    inputType: 'text',
                    confirmLabel: 'Hapus',
                    toast: 'Permintaan hapus akun dicatat.',
                },
            };

            function openModal(mode) {
                const item = config[mode];
                if (!item || !modal) return;
                currentMode = mode;
                titleEl.textContent = item.title;
                descEl.textContent = item.desc;
                confirmBtn.textContent = item.confirmLabel;

                if (mode === 'modal-hapus') {
                    inputWrap.classList.add('hidden');
                } else {
                    inputWrap.classList.remove('hidden');
                    inputEl.type = item.inputType;
                    inputEl.placeholder = item.placeholder;
                    inputEl.value = '';
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentMode = null;
            }

            function showToast(msg) {
                if (!toastEl) return;
                toastEl.textContent = msg;
                toastEl.classList.remove('hidden');
                setTimeout(() => toastEl.classList.add('hidden'), 1800);
            }

            document.querySelectorAll('[data-open-sheet]').forEach((btn) => {
                btn.addEventListener('click', () => openModal(btn.dataset.openSheet));
            });

            cancelBtn?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            confirmBtn?.addEventListener('click', () => {
                if (!currentMode) return;
                const msg = config[currentMode]?.toast || 'Perubahan disimpan.';
                closeModal();
                showToast(msg);
            });
        });
    </script>
</body>
</html>