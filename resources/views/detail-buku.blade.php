@php
    $activeNav = $activeNav ?? 'katalog'; // 'pengaturan' | 'katalog' | 'pinjam'

    $tagStyle = function (string $label): string {
        return match (mb_strtolower(trim($label))) {
            'baru', 'baru tiba' => 'text-[#E5BE78]',
            'anak' => 'text-[#95A652]',
            'fiksi' => 'text-[#8EB9D6]',
            'non-fiksi', 'non-fiks' => 'text-[#E39B6D]',
            default => 'text-slate-400',
        };
    };

$book = $book ?? [
        'title' => 'Sense and Sensibility',
        'author' => 'Jane Austen',
        'categories' => ['Fiksi'],
        'is_new' => true,
        'cover' => 'images/book-3.png',
        'release_year' => '1811',
        'stock' => 2,
        'synopsis' => 'Setelah kehilangan harta warisan, keluarga Dashwood pindah ke Barton Cottage. Elinor menghadapi cinta yang rumit dengan Edward Ferrars, sementara Marianne patah hati karena ditinggalkan John Willoughby. Setelah melewati berbagai konflik dan kekecewaan, Elinor menikahi Edward, sedangkan Marianne menikahi Kolonel Brandon.',
        'borrow_date' => '18/12/2026',
        'due_date' => '23/12/2026',
        'borrow_action' => '#pinjam-submit',
        'available_again' => '01-01-2027',
        'return_date' => '06-01-2027',
        'queue_action' => '#antre-submit',
    ];

    $similarBooks = $similarBooks ?? [
        [
            'title' => 'Persuasion',
            'author' => 'Jane Austen',
            'categories' => ['Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-5.png',
            'stock' => 4,
            'url' => '#detail-persuasion',
        ],
        [
            'title' => 'North and South',
            'author' => 'Elizabeth Gaskell',
            'categories' => ['Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-9.png',
            'stock' => 2,
            'url' => '#detail-north-and-south',
        ],
        [
            'title' => 'Marie Antoinette',
            'author' => 'Antonia Fraser',
            'categories' => ['Non-Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-8.png',
            'stock' => 3,
            'url' => '#detail-marie-antoinette',
        ],
    ];

    $bookCats = $book['categories'] ?? (isset($book['category']) ? [$book['category']] : []);
    $isNew = $book['is_new'] ?? true;
    $stock = (int) ($book['stock'] ?? 0);
    $isAvailable = $stock > 0;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — Detail Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-[#2C3E50] antialiased overflow-x-hidden">
    <div class="min-h-screen lg:h-screen lg:overflow-hidden flex flex-col lg:flex-row">
        {{-- Sidebar Kiri --}}
        <aside class="w-full lg:w-60 lg:h-full lg:overflow-y-auto shrink-0 bg-[#C7C572] text-white flex flex-col">
            <div class="w-full shrink-0">
                <img
                    src="{{ asset('images/Pita.png') }}"
                    alt="Pita Hiasan Atas"
                    class="w-full h-11 object-cover"
                    onerror="this.style.display='none'"
                >
            </div>

            <div class="px-5 py-6 flex flex-col items-center lg:items-stretch gap-6">
                <a href="{{ url('/preview-landing') }}" class="text-2xl font-extrabold tracking-tight text-[#2C3E50] text-center">
                    batabutu
                </a>

                <div class="flex justify-center">
                    <img
                        src="{{ asset('images/Doodle masuk.png') }}"
                        alt="Maskot batabutu"
                        class="w-14 h-14 object-contain"
                        onerror="this.style.display='none'"
                    >
                </div>

                <nav id="detail-sidebar-nav" class="flex flex-col w-full mt-1 gap-1.5" aria-label="Navigasi Utama">
                    <a
                        href="{{ Route::has('settings') ? route('settings') : url('/preview-pengaturan') }}"
                        data-nav-key="pengaturan"
                        class="sidebar-link flex items-center gap-3.5 px-3.5 py-3 border-b border-white/40 rounded-lg text-sm font-semibold text-white transition {{ $activeNav === 'pengaturan' ? 'is-active bg-[#3E648C]' : 'hover:bg-[#3E648C]/75' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.614 7.614 0 000 1.139c.016.2-.059.352-.154.43l-.84.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c.016-.2.059-.352.154-.43l.84-.692c.435-.358.6-.94.432-1.385l-.923-1.597a1.875 1.875 0 00-2.28-.818l-1.019.382c-.115.043-.283.031-.45-.082a7.493 7.493 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                        </svg>
                        <span>Pengaturan</span>
                    </a>

                    <a
                        href="{{ url('/preview-katalog') }}#katalog-buku"
                        data-nav-key="katalog"
                        class="sidebar-link flex items-center gap-3.5 px-3.5 py-3 border-b border-white/40 rounded-lg text-sm font-semibold text-white transition {{ $activeNav === 'katalog' ? 'is-active bg-[#3E648C]' : 'hover:bg-[#3E648C]/75' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                        </svg>
                        <span>Katalog Buku</span>
                    </a>

                    <a
                        href="{{ url('/preview-katalog') }}#pinjam-buku"
                        data-nav-key="pinjam"
                        class="sidebar-link flex items-center gap-3.5 px-3.5 py-3 rounded-lg text-sm font-semibold text-white transition {{ $activeNav === 'pinjam' ? 'is-active bg-[#3E648C]' : 'hover:bg-[#3E648C]/75' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd" />
                        </svg>
                        <span>Pinjam Buku</span>
                    </a>
                </nav>
            </div>
        </aside>

        {{-- Konten Utama Kanan --}}
        <div class="flex-1 min-w-0 lg:h-full lg:overflow-y-auto bg-white scroll-smooth px-6 sm:px-12 pt-6 pb-16">
            <header class="mb-8">
                <a href="{{ url('/preview-landing') }}" class="text-xl font-extrabold text-[#2C3E50]">
                    batabutu
                </a>
            </header>

            <main id="detail-buku-main" class="max-w-5xl">
                {{-- Header Judul: Panah Kembali + Doodle di Kiri Teks "Detail Buku" --}}
                <div class="relative flex items-center justify-center min-h-12">
                    <a
                        href="{{ url('/preview-katalog') }}#katalog-buku"
                        aria-label="Kembali ke Katalog Buku"
                        class="absolute left-0 p-2 -ml-2 text-[#2C3E50] hover:text-slate-600 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>

                    <div class="flex items-center gap-4">
                        <img
                            src="{{ asset('images/doodle-detail-buku.png') }}"
                            alt="Maskot Detail Buku"
                            class="w-12 h-12 object-contain shrink-0"
                            onerror="this.style.display='none'"
                        >
                        <h1 class="text-2xl sm:text-[26px] font-bold text-[#2C3E50]">
                            Detail Buku
                        </h1>
                    </div>
                </div>

                {{-- Bagian Utama Detail: Buku di Kiri, Tahun Rilis/Stok/Sinopsis/Tombol di Kanan --}}
                <div class="flex flex-col md:flex-row items-start gap-16 md:gap-14 md:pl-9">
                    {{-- Kiri: Sampul Buku + Judul + Penulis + Kategori --}}
                    <div class="w-full md:w-56 shrink-0 flex flex-col items-center text-center">
                        <div class="w-48 md:w-56 aspect-[2/3] overflow-hidden bg-slate-100 border border-slate-200/80 shadow-xs mb-3.5">
                            <img
                                src="{{ asset($book['cover']) }}"
                                alt="{{ $book['title'] }}"
                                onerror="this.onerror=null; this.src='https://placehold.co/320x480/F8E5C2/2C3E50?text={{ urlencode($book['title']) }}';"
                                class="w-full h-full object-cover"
                            >
                        </div>

                        <h2 class="text-sm font-bold text-[#2C3E50] leading-snug">
                            {{ $book['title'] }}
                        </h2>
                        <p class="text-xs font-medium text-[#2C3E50]/85 mt-1">
                            {{ $book['author'] }}
                        </p>

                        <div class="flex flex-wrap items-center justify-center gap-1.5 text-xs font-semibold mt-1.5">
                            @if ($isNew)
                                <span class="{{ $tagStyle('Baru') }}">Baru</span>
                            @endif
                            @if ($isNew && count($bookCats) > 0)
                                <span class="text-slate-300">·</span>
                            @endif
                            @foreach ($bookCats as $idx => $cat)
                                <span class="{{ $tagStyle($cat) }}">{{ $cat }}</span>
                                @if ($idx < count($bookCats) - 1)
                                    <span class="text-slate-300">·</span>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Kanan: Tahun Rilis & Stok, Sinopsis, Tombol Pinjam / Antre --}}
                    <div class="flex-1 min-w-0 space-y-7 text-xs sm:text-sm text-[#2C3E50] pt-5 md:pt-24">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <span class="font-bold">Tahun rilis:</span>
                                <span class="font-medium">{{ $book['release_year'] }}</span>
                            </div>

                            <div class="flex items-center gap-2.5 shrink-0">
                                <span class="font-bold text-[#2C3E50]">Stok:</span>
                                <span
                                    id="detail-stock-badge"
                                    class="w-7 h-7 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-xs {{ $isAvailable ? 'bg-[#C7C572]' : 'bg-[#C96A5B]' }}"
                                >
                                    {{ $stock }}
                                </span>
                            </div>
                        </div>

                        <p class="leading-relaxed text-[#2C3E50]/90 max-w-2xl">
                            <span class="font-bold text-[#2C3E50]">Sinopsis:</span>
                            {{ $book['synopsis'] }}
                        </p>

                        <div class="pt-2">
                            @if ($isAvailable)
                                <button
                                    id="open-borrow-modal-btn"
                                    type="button"
                                    class="px-7 py-2 rounded-full bg-[#F2D399] hover:bg-[#E7C27D] text-white text-xs sm:text-sm font-semibold transition cursor-pointer"
                                >
                                    Pinjam
                                </button>
                            @else
                                <button
                                    id="open-queue-modal-btn"
                                    type="button"
                                    class="px-7 py-2 rounded-full bg-[#F2D399] hover:bg-[#E7C27D] text-white text-xs sm:text-sm font-semibold transition cursor-pointer"
                                >
                                    Antre
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Toast / Feedback Banner ("Berhasil meminjam." / "Berhasil mengantre.") --}}
                <div class="flex justify-center pt-1">
                    <div
                        id="action-feedback-toast"
                        role="status"
                        aria-live="polite"
                        class="hidden w-full max-w-md px-8 py-4 rounded-2xl bg-white border border-slate-100 shadow-[0_10px_28px_rgba(44,62,80,0.10)] text-center text-sm font-semibold text-[#2C3E50]"
                    >
                        <span id="action-feedback-text"></span>
                    </div>
                </div>

                {{-- Section Buku Lain yang Mirip --}}
                <section id="buku-lain-yang-mirip" class="mt-10 sm:mt-12 space-y-6 md:pl-4">
                    <div class="flex items-center gap-3 md:pl-4">
                        <img
                            src="{{ asset('images/doodle-populer.png') }}"
                            alt="Maskot Buku Lain yang Mirip"
                            class="w-10 h-10 object-contain shrink-0"
                            onerror="this.style.display='none'"
                        >
                        <h2 class="text-lg sm:text-xl font-bold text-[#2C3E50]">
                            Buku lain yang mirip
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-8 md:pl-4">
                        @foreach ($similarBooks as $sim)
                            @php
                                $simCats = $sim['categories'] ?? (isset($sim['category']) ? [$sim['category']] : []);
                                $simIsNew = $sim['is_new'] ?? true;
                                $simStock = (int) ($sim['stock'] ?? 0);
                            @endphp
                            <article class="group flex flex-col items-center text-center">
                                <a
                                    href="{{ $sim['url'] ?? '#' }}"
                                    class="relative w-44 sm:w-48 aspect-[3/4] rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 mb-3 block"
                                >
                                    <img
                                        src="{{ asset($sim['cover']) }}"
                                        alt="{{ $sim['title'] }}"
                                        onerror="this.onerror=null; this.src='https://placehold.co/300x400/F8E5C2/2C3E50?text={{ urlencode($sim['title']) }}';"
                                        class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-200"
                                    >
                                    <span
                                        class="absolute bottom-2.5 right-2.5 w-7 h-7 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-xs {{ $simStock > 0 ? 'bg-[#C7C572]' : 'bg-[#C96A5B]' }}"
                                    >
                                        {{ $simStock }}
                                    </span>
                                </a>

                                <h3 class="text-xs sm:text-sm font-bold text-[#2C3E50] line-clamp-1">
                                    {{ $sim['title'] }}
                                </h3>
                                <p class="text-[11px] sm:text-xs font-medium text-[#2C3E50]/80 line-clamp-1 mt-0.5">
                                    {{ $sim['author'] }}
                                </p>

                                <div class="flex flex-wrap items-center justify-center gap-1.5 text-[11px] sm:text-xs font-semibold mt-1">
                                    @if ($simIsNew)
                                        <span class="{{ $tagStyle('Baru') }}">Baru</span>
                                    @endif
                                    @foreach ($simCats as $cat)
                                        <span class="{{ $tagStyle($cat) }}">{{ $cat }}</span>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </main>
        </div>
    </div>

    {{-- Modal Konfirmasi: Pinjam Buku? --}}
    <div
        id="borrow-confirm-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="borrow-modal-title"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/15 px-4"
    >
        <div class="w-full max-w-md rounded-2xl bg-white border border-slate-100 shadow-[0_14px_36px_rgba(44,62,80,0.14)] overflow-hidden">
            <div class="p-6 space-y-3 text-left">
                <h3 id="borrow-modal-title" class="text-sm sm:text-base font-bold text-[#2C3E50]">
                    Pinjam buku?
                </h3>
                <div class="space-y-1 text-xs sm:text-sm font-medium text-[#3E4C59]">
                    <p>Tanggal peminjaman: {{ $book['borrow_date'] ?? '18/12/2026' }}</p>
                    <p>Jatuh tempo: {{ $book['due_date'] ?? '23/12/2026' }}.</p>
                </div>
            </div>

            <form method="POST" action="{{ $book['borrow_action'] ?? '#' }}" id="borrow-confirm-form" class="divide-y divide-slate-200/80 border-t border-slate-200/80">
                @csrf
                <button
                    type="button"
                    data-close-modal="borrow-confirm-modal"
                    class="w-full py-3.5 text-center text-xs sm:text-sm font-semibold text-[#C96A5B] bg-[#EFEFEF]/80 hover:bg-[#E5E5E5] transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="w-full py-3.5 text-center text-xs sm:text-sm font-semibold text-[#2C3E50] bg-[#EFEFEF]/80 hover:bg-[#E5E5E5] transition cursor-pointer"
                >
                    Pinjam
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi: Masuk Antrean? --}}
    <div
        id="queue-confirm-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="queue-modal-title"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/15 px-4"
    >
        <div class="w-full max-w-md rounded-2xl bg-white border border-slate-100 shadow-[0_14px_36px_rgba(44,62,80,0.14)] overflow-hidden">
            <div class="p-6 space-y-3 text-left">
                <h3 id="queue-modal-title" class="text-sm sm:text-base font-bold text-[#2C3E50]">
                    Masuk antrean?
                </h3>
                <p class="text-xs sm:text-sm font-medium text-[#3E4C59]">
                    Buku sedang dipinjam oleh pengguna lain.
                </p>
                <div class="space-y-1 text-xs sm:text-sm font-medium text-[#3E4C59]">
                    <p>Tersedia kembali: {{ $book['available_again'] }}</p>
                    <p>Tanggal pengembalian: {{ $book['return_date'] }}</p>
                </div>
            </div>

            <form method="POST" action="{{ $book['queue_action'] ?? '#' }}" id="queue-confirm-form" class="divide-y divide-slate-200/80 border-t border-slate-200/80">
                @csrf
                <button
                    type="button"
                    data-close-modal="queue-confirm-modal"
                    class="w-full py-3.5 text-center text-xs sm:text-sm font-semibold text-[#C96A5B] bg-[#EFEFEF]/80 hover:bg-[#E5E5E5] transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="w-full py-3.5 text-center text-xs sm:text-sm font-semibold text-[#2C3E50] bg-[#EFEFEF]/80 hover:bg-[#E5E5E5] transition cursor-pointer"
                >
                    Antre
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('#detail-sidebar-nav .sidebar-link');
            navLinks.forEach((link) => {
                link.addEventListener('click', () => {
                    navLinks.forEach((item) => item.classList.remove('is-active', 'bg-[#3E648C]'));
                    link.classList.add('is-active', 'bg-[#3E648C]');
                });
            });

            const borrowModal = document.getElementById('borrow-confirm-modal');
            const queueModal = document.getElementById('queue-confirm-modal');
            const openBorrowBtn = document.getElementById('open-borrow-modal-btn');
            const openQueueBtn = document.getElementById('open-queue-modal-btn');
            const toastBox = document.getElementById('action-feedback-toast');
            const toastText = document.getElementById('action-feedback-text');

            function openModal(modalEl) {
                if (!modalEl) return;
                modalEl.classList.remove('hidden');
                modalEl.classList.add('flex');
            }

            function closeModal(modalEl) {
                if (!modalEl) return;
                modalEl.classList.add('hidden');
                modalEl.classList.remove('flex');
            }

            let feedbackTimer = null;

            function hideFeedbackToast() {
                if (!toastBox) return;
                toastBox.classList.add('hidden');
            }

            function showFeedbackToast(message, durationMs = 1500) {
                if (!toastBox || !toastText) return;
                toastText.textContent = message;
                toastBox.classList.remove('hidden');
                toastBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                if (feedbackTimer) {
                    clearTimeout(feedbackTimer);
                }

                if (durationMs > 0) {
                    feedbackTimer = setTimeout(() => {
                        hideFeedbackToast();
                    }, durationMs);
                }
            }

            const initialFeedback = @json($feedbackMessage ?? session('success') ?? null);
            if (initialFeedback) {
                showFeedbackToast(initialFeedback);
            }

            openBorrowBtn?.addEventListener('click', () => openModal(borrowModal));
            openQueueBtn?.addEventListener('click', () => openModal(queueModal));

            document.querySelectorAll('[data-close-modal]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    closeModal(document.getElementById(btn.dataset.closeModal));
                });
            });

            [borrowModal, queueModal].forEach((modalEl) => {
                modalEl?.addEventListener('click', (e) => {
                    if (e.target === modalEl) closeModal(modalEl);
                });
            });

            // Pratinjau UI feedback saat submit di mode preview (jika action masih '#...')
            document.getElementById('borrow-confirm-form')?.addEventListener('submit', (e) => {
                const action = e.currentTarget.getAttribute('action') || '';
                if (action.startsWith('#')) {
                    e.preventDefault();
                    closeModal(borrowModal);
                    showFeedbackToast('Berhasil meminjam.');
                }
            });

            document.getElementById('queue-confirm-form')?.addEventListener('submit', (e) => {
                const action = e.currentTarget.getAttribute('action') || '';
                if (action.startsWith('#')) {
                    e.preventDefault();
                    closeModal(queueModal);
                    showFeedbackToast('Berhasil mengantre.');
                }
            });
        });
    </script>
</body>
</html>