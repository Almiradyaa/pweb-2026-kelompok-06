@php
    $status = $status ?? 'antre'; // 'antre' | 'dipinjam'
    $activeNav = $activeNav ?? 'pinjam'; // 'pengaturan' | 'katalog' | 'pinjam'

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
        'synopsis' => 'Setelah kehilangan harta warisan, keluarga Dashwood pindah ke Barton Cottage. Elinor menghadapi cinta yang rumit dengan Edward Ferrars, sementara Marianne patah hati karena ditinggalkan John Willoughby. Setelah melewati berbagai konflik dan kekecewaan, Elinor menikahi Edward, sedangkan Marianne menikahi Kolonel Brandon.',
        // Data khusus status Antre
        'available_again' => '01-01-2027',
        'queue_expired_at' => '06-01-2026',
        // Data khusus status Dipinjam
        'borrowed_at' => '19-12-2026',
        'expired_at' => '24-12-2026',
        'remaining_days' => '1 hari',
        'read_url' => '#baca-buku',
    ];

    $bookCats = $book['categories'] ?? (isset($book['category']) ? [$book['category']] : []);
    $isNew = $book['is_new'] ?? true;
    $isBorrowed = $status === 'dipinjam';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — {{ $isBorrowed ? 'Dipinjam' : 'Antre' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-[#2C3E50] antialiased overflow-x-hidden">
    <div class="min-h-screen flex flex-col lg:flex-row">
        {{-- Sidebar Kiri --}}
        <aside class="w-full lg:w-60 shrink-0 bg-[#C7C572] text-white flex flex-col">
            <div class="w-full">
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

                <nav id="sidebar-nav" class="flex flex-col w-full mt-1 gap-1.5" aria-label="Navigasi Utama">
                    <a
                        href="{{ Route::has('settings') ? route('settings') : url('/preview-pengaturan') }}"
                        data-nav-key="pengaturan"
                        class="sidebar-link flex items-center gap-3 px-3.5 py-3 border-b border-white/40 rounded-lg text-sm font-semibold text-white transition {{ $activeNav === 'pengaturan' ? 'is-active bg-[#3E648C]' : 'hover:bg-[#3E648C]/75' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.614 7.614 0 000 1.139c.016.2-.059.352-.154.43l-.84.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c.016-.2.059-.352.154-.43l.84-.692c.435-.358.6-.94.432-1.385l-.923-1.597a1.875 1.875 0 00-2.28-.818l-1.019.382c-.115.043-.283.031-.45-.082a7.493 7.493 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                        </svg>
                        <span>Pengaturan</span>
                    </a>

                    <a
                        href="{{ url('/preview-katalog') }}#katalog-buku"
                        data-nav-key="katalog"
                        class="sidebar-link flex items-center gap-3 px-3.5 py-3 border-b border-white/40 rounded-lg text-sm font-semibold text-white transition {{ $activeNav === 'katalog' ? 'is-active bg-[#3E648C]' : 'hover:bg-[#3E648C]/75' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                        </svg>
                        <span>Katalog Buku</span>
                    </a>

                    <a
                        href="{{ url('/preview-katalog') }}#pinjam-buku"
                        data-nav-key="pinjam"
                        class="sidebar-link flex items-center gap-3 px-3.5 py-3 rounded-lg text-sm font-semibold text-white transition {{ $activeNav === 'pinjam' ? 'is-active bg-[#3E648C]' : 'hover:bg-[#3E648C]/75' }}"
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
        <div class="flex-1 min-w-0 bg-white px-6 sm:px-12 pt-6 pb-16">
            <header class="mb-8">
                <a href="{{ url('/preview-landing') }}" class="text-xl font-extrabold text-[#2C3E50]">
                    batabutu
                </a>
            </header>

            <main id="pinjam-detail" class="max-w-5xl">
                {{-- Header Judul: Doodle di Kiri Teks Antre / Dipinjam --}}
                <div class="relative flex items-center justify-center min-h-12">
                    <a
                        href="{{ url('/preview-katalog') }}#pinjam-buku"
                        aria-label="Kembali ke Pinjam Buku"
                        class="absolute left-0 p-2 -ml-2 text-[#2C3E50] hover:text-slate-600 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>

                    <div class="flex items-center gap-4">
                        <img
                            src="{{ asset($isBorrowed ? 'images/doodle-dipinjam.png' : 'images/doodle-antre.png') }}"
                            alt="Maskot {{ $isBorrowed ? 'Dipinjam' : 'Antre' }}"
                            class="w-12 h-12 object-contain shrink-0"
                            onerror="this.style.display='none'"
                        >
                        <h1 class="text-2xl sm:text-[26px] font-bold text-[#E6CD78]">
                            {{ $isBorrowed ? 'Dipinjam' : 'Antre' }}
                        </h1>
                    </div>
                </div>

                {{-- Baris Utama: Buku di Kiri, Tahun Rilis & Sinopsis di Samping Kanan --}}
                <div class="mt-6 sm:mt-14 flex flex-col md:flex-row items-start gap-10 md:gap-14 md:pl-9">
                    {{-- Kiri: Sampul Buku Lebih Besar Sedikit + Judul + Penulis + Kategori --}}
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

                    {{-- Kanan: Tahun Rilis & Sinopsis Turun ke Bawah, Lalu Baris Tanggal Sejajar --}}
                    <div class="flex-1 min-w-0 space-y-7 text-xs sm:text-sm text-[#2C3E50] pt-5 md:pt-24">
                        <div>
                            <span class="font-bold">Tahun rilis:</span>
                            <span class="font-medium">{{ $book['release_year'] }}</span>
                        </div>

                        <p class="leading-relaxed text-[#2C3E50]/90 max-w-2xl">
                            <span class="font-bold text-[#2C3E50]">Sinopsis:</span>
                            {{ $book['synopsis'] }}
                        </p>

                        @if ($isBorrowed)
                            <div class="pt-3 flex flex-wrap items-start gap-6 sm:gap-10">
                                <a
                                    href="{{ $book['read_url'] ?? '#' }}"
                                    class="px-7 py-2.5 rounded-full bg-[#B9DFEC] hover:bg-[#A6D4E4] text-white text-xs sm:text-sm font-semibold transition shrink-0"
                                >
                                    Baca
                                </a>

                                <div class="flex flex-wrap items-start gap-8 sm:gap-12 pt-1.5">
                                    <div class="text-xs sm:text-sm font-semibold text-[#3E4C59]">
                                        Tanggal Peminjaman: <span class="font-bold">{{ $book['borrowed_at'] }}</span>
                                    </div>

                                    <div class="space-y-1.5 text-xs sm:text-sm">
                                        <div class="font-semibold text-[#3E4C59]">
                                            Kedaluwarsa: <span class="font-bold">{{ $book['expired_at'] }}</span>
                                        </div>
                                        <div class="font-semibold text-[#C8645B]">
                                            Sisa masa: <span class="font-bold">{{ $book['remaining_days'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="pt-3 flex flex-wrap items-center gap-6 sm:gap-8">
                                <button
                                    type="button"
                                    disabled
                                    class="px-6 py-2.5 rounded-full bg-[#E5E5E5] text-white text-xs sm:text-sm font-semibold cursor-not-allowed"
                                >
                                    Belum Tersedia
                                </button>

                                <div class="text-xs sm:text-sm font-semibold text-[#3E4C59]">
                                    Tersedia Kembali: <span class="font-bold">{{ $book['available_again'] }}</span>
                                </div>

                                <div class="text-xs sm:text-sm font-semibold text-[#3E4C59]">
                                    Kedaluwarsa: <span class="font-bold">{{ $book['queue_expired_at'] }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.sidebar-link');

            function setActiveNav(targetLink) {
                navLinks.forEach((link) => {
                    link.classList.remove('is-active', 'bg-[#3E648C]');
                });
                targetLink.classList.add('is-active', 'bg-[#3E648C]');
            }

            navLinks.forEach((link) => {
                link.addEventListener('click', () => {
                    setActiveNav(link);
                });
            });
        });
    </script>
</body>
</html>