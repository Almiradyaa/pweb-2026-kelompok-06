@php
    $tagStyle = function (string $label): string {
        return match (mb_strtolower(trim($label))) {
            'baru', 'baru tiba' => 'text-[#E5BE78]',
            'anak' => 'text-[#95A652]',
            'fiksi' => 'text-[#8EB9D6]',
            'non-fiksi', 'non-fiks' => 'text-[#E39B6D]',
            default => 'text-slate-400',
        };
    };

    $booksMaster = [
            'beautiful-boy' => [
                'title' => 'Beautiful Boy',
                'author' => 'David Sheff',
                'category' => 'Non-Fiksi',
                'cover' => 'images/book-4.png',
                'stock' => 2,
            ],
            'persuasion' => [
                'title' => 'Persuasion',
                'author' => 'Jane Austen',
                'category' => 'Fiksi',
                'cover' => 'images/book-5.png',
                'stock' => 3,
            ],
            'animal-farm' => [
                'title' => 'Animal Farm',
                'author' => 'George Orwell',
                'category' => 'Fiksi',
                'cover' => 'images/book-6.png',
                'stock' => 1,
            ],
            'trois-petites-lumieres' => [
                'title' => 'Trois petites lumières',
                'author' => 'Maria Ramos',
                'category' => 'Anak',
                'cover' => 'images/book-1.png',
                'stock' => 4,
            ],
            'diary-of-a-wimpy-kid' => [
                'title' => 'Diary of a Wimpy Kid',
                'author' => 'Jeff Kinney',
                'category' => 'Anak',
                'cover' => 'images/book-2.png',
                'stock' => 2,
            ],
            'sense-and-sensibility' => [
                'title' => 'Sense and Sensibility',
                'author' => 'Jane Austen',
                'category' => 'Fiksi',
                'cover' => 'images/book-3.png',
                'stock' => 1,
            ],
            'dead-poets-society' => [
                'title' => 'Dead Poets Society',
                'author' => 'Robin Williams',
                'category' => 'Fiksi',
                'cover' => 'images/book-7.png',
                'stock' => 0,
            ],
            'marie-antoinette' => [
                'title' => 'Marie Antoinette',
                'author' => 'Antonia Fraser',
                'category' => 'Non-Fiksi',
                'cover' => 'images/book-8.png',
                'stock' => 2,
            ],
            'north-and-south' => [
                'title' => 'North and South',
                'author' => 'Elizabeth Gaskell',
                'category' => 'Fiksi',
                'cover' => 'images/book-9.png',
                'stock' => 1,
            ],
        ];

        $popularBooks = $popularBooks ?? [
            $booksMaster['beautiful-boy'],
            $booksMaster['persuasion'],
            $booksMaster['animal-farm'],
            $booksMaster['trois-petites-lumieres'],
        ];

        $catalogBooks = $catalogBooks ?? [
            $booksMaster['trois-petites-lumieres'],
            $booksMaster['diary-of-a-wimpy-kid'],
            $booksMaster['sense-and-sensibility'],
            array_merge($booksMaster['beautiful-boy'], ['stock' => 0]),
            array_merge($booksMaster['persuasion'], ['stock' => 2]),
            $booksMaster['animal-farm'],
            $booksMaster['dead-poets-society'],
            $booksMaster['marie-antoinette'],
            $booksMaster['north-and-south'],
        ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — Perpustakaan & Pinjam Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#FAF9F6] text-[#2C3E50] antialiased">
    {{-- Pita Hiasan Atas --}}
    <div class="w-full">
        <img
            src="{{ asset('images/Pita.png') }}"
            alt="Pita Hiasan Atas"
            class="w-full h-11 object-cover"
        >
    </div>

    <div class="min-h-screen lg:h-[calc(100vh-2.75rem)] lg:overflow-hidden flex flex-col lg:flex-row">
        {{-- Sidebar Kiri --}}
<aside class="w-full lg:w-60 lg:h-full lg:overflow-y-auto shrink-0 bg-[#C7C572] text-white px-5 py-6 flex lg:flex-col justify-between items-center lg:items-start">
            <div class="w-full flex lg:flex-col items-center lg:items-start justify-between gap-6">
                <a href="{{ url('/preview-landing') }}" class="text-2xl font-extrabold tracking-tight text-[#2C3E50]">
                    batabutu
                </a>

                <nav id="landing-sidebar-nav" class="flex lg:flex-col items-center lg:items-stretch gap-2 lg:gap-1.5 w-auto lg:w-full" aria-label="Navigasi Landing">
                    <a
                        href="{{ Route::has('login') ? route('login') : url('/preview-login') }}"
                        data-nav-key="auth"
                        class="sidebar-link flex items-center gap-3.5 px-3.5 py-3 border-b border-white/40 rounded-lg text-sm font-semibold text-white hover:bg-[#3E648C]/75 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.614 7.614 0 000 1.139c.016.2-.059.352-.154.43l-.84.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c.016-.2.059-.352.154-.43l.84-.692c.435-.358.6-.94.432-1.385l-.923-1.597a1.875 1.875 0 00-2.28-.818l-1.019.382c-.115.043-.283.031-.45-.082a7.493 7.493 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                        </svg>
                        <span>Daftar/Masuk</span>
                    </a>

                    {{-- Menu Beranda (aktif berwarna biru pada landing page) --}}
                    <a
                        href="{{ url('/preview-landing') }}"
                        data-nav-key="beranda"
                        aria-current="page"
                        class="sidebar-link is-active flex items-center gap-3.5 px-3.5 py-3 border-b border-white/40 rounded-lg text-sm font-semibold bg-[#3E648C] text-white shadow-xs transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.47 3.841a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.061l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.689z" />
                            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                        </svg>
                        <span>Beranda</span>
                    </a>

                    <a
                        href="#katalog-buku"
                        data-nav-key="katalog"
                        class="sidebar-link flex items-center gap-3.5 px-3.5 py-3 border-b border-white/40 rounded-lg text-sm font-semibold text-white hover:bg-[#3E648C]/75 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                        </svg>
                        <span>Katalog Buku</span>
                    </a>

                    <a
                        href="#pinjam-buku"
                        data-nav-key="pinjam"
                        class="sidebar-link flex items-center gap-3.5 px-3.5 py-3 rounded-lg text-sm font-semibold text-white hover:bg-[#3E648C]/75 transition"
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
        <div class="flex-1 lg:h-full lg:overflow-y-auto bg-white scroll-smooth">
            {{-- Topbar Pencarian & Profil --}}
            <header class="w-full px-6 md:px-10 pt-6 pb-4 flex flex-wrap items-center justify-between gap-4 border-b border-slate-100">
                <a href="{{ url('/preview-landing') }}" class="text-xl font-extrabold text-[#2C3E50]">
                    batabutu
                </a>

                <form action="#katalog-buku" method="GET" class="flex-1 max-w-xl flex items-center gap-2.5">
                    <div class="relative flex-1 flex items-center">
                        <span class="pointer-events-none absolute left-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search for books"
                            class="w-full pl-11 pr-4 py-2.5 rounded-full bg-slate-100 text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-[#C8A064]/50 focus:outline-none"
                        >
                    </div>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-full bg-[#D9B67C] hover:bg-[#C8A064] text-white text-sm font-semibold transition cursor-pointer shrink-0"
                    >
                        Search
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ Route::has('login') ? route('login') : url('/preview-login') }}"
                        class="w-10 h-10 rounded-full overflow-hidden border border-[#C8A064]/70 shrink-0 block"
                        title="Akun"
                    >
                        <img
                            src="{{ asset('images/avatar default.png') }}"
                            alt="Avatar Pengguna"
                            class="w-full h-full object-cover"
                        >
                    </a>
                </div>
            </header>

            <main class="px-6 md:px-10 py-8 space-y-14 max-w-6xl">
                {{-- Hero Section --}}
                <section class="grid grid-cols-1 md:grid-cols-12 items-center gap-8 pt-2">
                    <div class="md:col-span-7 space-y-4">
                        <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight text-[#2C3E50]">
                            Temukan buku favoritmu,<br>
                            pinjam kapan saja.
                        </h1>
                        <p class="text-sm sm:text-base text-slate-600 max-w-lg leading-relaxed">
                            Jika stok habis, kamu bisa masuk antrean dan diberi tahu saat buku tersedia.
                        </p>

                        <div class="pt-2 flex flex-wrap items-center gap-3.5">
                            <a
                                href="{{ Route::has('register') ? route('register') : url('/preview-daftar-email') }}"
                                class="px-6 py-3 rounded-full bg-[#D9B67C] hover:bg-[#C8A064] text-white text-sm font-semibold transition"
                            >
                                Daftar Gratis
                            </a>
                            <a
                                href="{{ Route::has('login') ? route('login') : url('/preview-login') }}"
                                class="px-6 py-3 rounded-full border border-[#C8A064] bg-white hover:bg-[#FAF9F6] text-[#C8A064] text-sm font-semibold transition"
                            >
                                Masuk
                            </a>
                        </div>
                    </div>

                    <div class="md:col-span-5 flex justify-center md:justify-end">
                        <div class="relative w-64 h-64 sm:w-72 sm:h-72 rounded-full bg-[#F8E5C2] flex items-center justify-center p-6">
                            <img
                                src="{{ asset('images/hero-book.png') }}"
                                alt="Ilustrasi Buku Terbuka"
                                class="w-full h-full object-contain"
                                onerror="this.style.display='none'"
                            >
                        </div>
                    </div>
                </section>

                {{-- Populer Sekarang --}}
                <section class="space-y-6">
                    <div class="flex items-center gap-3">
                        <img
                            src="{{ asset('images/doodle-populer.png') }}"
                            alt="Maskot Populer"
                            class="w-10 h-10 object-contain shrink-0"
                            onerror="this.style.display='none'"
                        >
                        <h2 class="text-xl sm:text-2xl font-bold text-[#2C3E50]">
                            Populer Sekarang
                        </h2>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-8 md:pl-4">
                        @foreach ($popularBooks as $book)
                            @php
                                $bookCats = $book['categories'] ?? (isset($book['category']) ? [$book['category']] : []);
                                $isNew = $book['is_new'] ?? true;
                            @endphp
                            <article class="group flex flex-col items-center text-center">
                                <div class="relative w-48 sm:w-52 aspect-[3/4] w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 mb-3">
                                    <img
                                        src="{{ asset($book['cover']) }}"
                                        alt="{{ $book['title'] }}"
                                        onerror="this.onerror=null; this.src='https://placehold.co/300x400/F8E5C2/2C3E50?text={{ urlencode($book['title']) }}';"
                                        class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-200"
                                    >
                                    <span
                                        class="absolute bottom-2.5 right-2.5 w-7 h-7 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-xs {{ ($book['stock'] ?? 0) > 0 ? 'bg-[#C7C572]' : 'bg-[#C96A5B]' }}"
                                    >
                                        {{ $book['stock'] ?? 0 }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-bold text-[#2C3E50] line-clamp-1">
                                    {{ $book['title'] }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                    {{ $book['author'] }}
                                </p>

                                <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold mt-1">
                                    @if ($isNew)
                                        <span class="{{ $tagStyle('Baru') }}">Baru</span>
                                    @endif
                                    @foreach ($bookCats as $cat)
                                        <span class="{{ $tagStyle($cat) }}">{{ $cat }}</span>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                {{-- Katalog Buku --}}
                <section id="katalog-buku" class="space-y-8">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <img
                                src="{{ asset('images/doodle-katalog.png') }}"
                                alt="Maskot Katalog"
                                class="w-10 h-10 object-contain shrink-0"
                                onerror="this.style.display='none'"
                            >
                            <h2 class="text-xl sm:text-2xl font-bold text-[#2C3E50]">
                                Katalog Buku
                            </h2>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <div class="relative flex items-center">
                                <span class="pointer-events-none absolute left-3.5 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input
                                    id="catalog-search-input"
                                    type="text"
                                    placeholder="Search"
                                    class="pl-9 pr-4 py-2 rounded-full bg-slate-100 text-xs sm:text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-[#C8A064]/50 focus:outline-none w-40 sm:w-48"
                                >
                            </div>

                            <button
                                type="button"
                                data-filter="Baru Tiba"
                                class="catalog-filter-btn px-4 py-2 rounded-full bg-[#F5DEB3] text-[#D89B48] text-xs sm:text-sm font-semibold transition cursor-pointer"
                            >
                                Baru Tiba
                            </button>
                            <button
                                type="button"
                                data-filter="Anak"
                                class="catalog-filter-btn px-4 py-2 rounded-full border border-[#95A652] bg-white text-[#95A652] hover:bg-[#95A652]/10 text-xs sm:text-sm font-medium transition cursor-pointer"
                            >
                                Anak
                            </button>
                            <button
                                type="button"
                                data-filter="Fiksi"
                                class="catalog-filter-btn px-4 py-2 rounded-full border border-[#8EB9D6] bg-white text-[#8EB9D6] hover:bg-[#8EB9D6]/10 text-xs sm:text-sm font-medium transition cursor-pointer"
                            >
                                Fiksi
                            </button>
                            <button
                                type="button"
                                data-filter="Non-Fiksi"
                                class="catalog-filter-btn px-4 py-2 rounded-full border border-[#2C3E50]/70 bg-white text-[#2C3E50] hover:bg-slate-50 text-xs sm:text-sm font-medium transition cursor-pointer"
                            >
                                Non-Fiksi
                            </button>
                        </div>
                    </div>

                    <div id="catalog-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-7 gap-y-10">
                        @foreach ($catalogBooks as $book)
                            @php
                                $bookCats = $book['categories'] ?? (isset($book['category']) ? [$book['category']] : []);
                                $isNew = $book['is_new'] ?? true;
                                $filterTokens = collect($bookCats)
                                    ->when($isNew, fn ($c) => $c->push('Baru Tiba'))
                                    ->map(fn ($v) => mb_strtolower(trim($v)))
                                    ->implode('|');
                            @endphp
                            <article
                                class="catalog-item group flex flex-col items-center text-center"
                                data-categories="{{ $filterTokens }}"
                                data-search="{{ mb_strtolower($book['title'] . ' ' . $book['author'] . ' ' . implode(' ', $bookCats)) }}"
                            >
                                <div class="relative w-48 sm:w-52 aspect-[3/4] w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 mb-3.5">
                                    <img
                                        src="{{ asset($book['cover']) }}"
                                        alt="{{ $book['title'] }}"
                                        onerror="this.onerror=null; this.src='https://placehold.co/300x400/F8E5C2/2C3E50?text={{ urlencode($book['title']) }}';"
                                        class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-200"
                                    >
                                    <span
                                        class="absolute bottom-3 right-3 w-7 h-7 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-xs {{ ($book['stock'] ?? 0) > 0 ? 'bg-[#C7C572]' : 'bg-[#C96A5B]' }}"
                                    >
                                        {{ $book['stock'] ?? 0 }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-bold text-[#2C3E50] line-clamp-1">
                                    {{ $book['title'] }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-1">
                                    {{ $book['author'] }}
                                </p>

                                <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold mt-1">
                                    @if ($isNew)
                                        <span class="{{ $tagStyle('Baru') }}">Baru</span>
                                    @endif
                                    @foreach ($bookCats as $cat)
                                        <span class="{{ $tagStyle($cat) }}">{{ $cat }}</span>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <p id="catalog-empty-state" class="hidden text-center text-sm text-slate-400 py-6">
                        Tidak ada buku yang cocok dengan filter atau pencarian tersebut.
                    </p>
                </section>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const filterButtons = document.querySelectorAll('.catalog-filter-btn');
                        const catalogItems = document.querySelectorAll('.catalog-item');
                        const searchInput = document.getElementById('catalog-search-input');
                        const emptyState = document.getElementById('catalog-empty-state');

                        let activeFilter = null;

                        const activeStyles = {
                            'Baru Tiba': ['bg-[#E5BE78]', 'text-white', 'border-transparent'],
                            'Anak': ['bg-[#95A652]', 'text-white', 'border-[#95A652]'],
                            'Fiksi': ['bg-[#8EB9D6]', 'text-white', 'border-[#8EB9D6]'],
                            'Non-Fiksi': ['bg-[#2C3E50]', 'text-white', 'border-[#2C3E50]'],
                        };

                        const defaultStyles = {
                            'Baru Tiba': ['bg-[#F5DEB3]', 'text-[#D89B48]', 'border-transparent'],
                            'Anak': ['bg-white', 'text-[#95A652]', 'border-[#95A652]'],
                            'Fiksi': ['bg-white', 'text-[#8EB9D6]', 'border-[#8EB9D6]'],
                            'Non-Fiksi': ['bg-white', 'text-[#2C3E50]', 'border-[#2C3E50]/70'],
                        };

                        function syncButtonStyles() {
                            filterButtons.forEach((btn) => {
                                const key = btn.dataset.filter;
                                const allPossible = [
                                    'bg-[#E5BE78]', 'bg-[#95A652]', 'bg-[#8EB9D6]', 'bg-[#2C3E50]', 'bg-[#F5DEB3]', 'bg-white',
                                    'text-white', 'text-[#D89B48]', 'text-[#95A652]', 'text-[#8EB9D6]', 'text-[#2C3E50]',
                                    'border-transparent', 'border-[#95A652]', 'border-[#8EB9D6]', 'border-[#2C3E50]', 'border-[#2C3E50]/70'
                                ];
                                btn.classList.remove(...allPossible);

                                const palette = activeFilter === key ? activeStyles[key] : defaultStyles[key];
                                if (palette) {
                                    btn.classList.add(...palette);
                                }
                            });
                        }

                        function applyCatalogFilter() {
                            const keyword = (searchInput?.value || '').trim().toLowerCase();
                            let visibleCount = 0;

                            catalogItems.forEach((item) => {
                                const categories = (item.dataset.categories || '').split('|').filter(Boolean);
                                const searchable = item.dataset.search || '';

                                const matchesCategory = !activeFilter || categories.includes(activeFilter.toLowerCase());
                                const matchesSearch = !keyword || searchable.includes(keyword);

                                const shouldShow = matchesCategory && matchesSearch;
                                item.classList.toggle('hidden', !shouldShow);
                                if (shouldShow) visibleCount++;
                            });

                            if (emptyState) {
                                emptyState.classList.toggle('hidden', visibleCount > 0);
                            }
                        }

                        filterButtons.forEach((btn) => {
                            btn.addEventListener('click', () => {
                                const clicked = btn.dataset.filter;
                                activeFilter = activeFilter === clicked ? null : clicked;
                                syncButtonStyles();
                                applyCatalogFilter();
                            });
                        });

                        searchInput?.addEventListener('input', applyCatalogFilter);

                        const navLinks = document.querySelectorAll('#landing-sidebar-nav .sidebar-link');
                        navLinks.forEach((link) => {
                            link.addEventListener('click', () => {
                                navLinks.forEach((item) => {
                                    item.classList.remove('is-active', 'bg-[#3E648C]', 'shadow-xs');
                                });
                                link.classList.add('is-active', 'bg-[#3E648C]', 'shadow-xs');
                            });
                        });
                    });
                </script>

                {{-- Pinjam Buku --}}
                <section id="pinjam-buku" class="w-full pt-8 pb-20 flex flex-col items-start text-left space-y-2">
                    <div class="flex items-center justify-start gap-2.5">
                        <img
                            src="{{ asset('images/doodle-pinjam.png') }}"
                            alt="Maskot Pinjam Buku"
                            class="w-9 h-9 object-contain shrink-0"
                            onerror="this.style.display='none'"
                        >
                        <h2 class="text-xl sm:text-2xl font-bold text-[#2C3E50]">
                            Pinjam Buku
                        </h2>
                    </div>

                    <div class="w-full flex-1 flex items-center justify-center pt-12 pb-8">
                        <p class="w-full text-center text-xs sm:text-sm text-slate-500">
                            Masuk untuk meminjam buku.
                        </p>
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>
</html>