@php
    $popularBooks = $popularBooks ?? [
        ['title' => 'Beautiful Boy', 'author' => 'David Sheff', 'category' => 'Non-Fiksi', 'cover' => 'images\book-1.png', 'stock' => 2],
        ['title' => 'Persuasion', 'author' => 'Jane Austen', 'category' => 'Fiksi', 'cover' => 'images/book-2.png', 'stock' => 3],
        ['title' => 'Animal Farm', 'author' => 'George Orwell', 'category' => 'Fiksi', 'cover' => 'images/book-3.png', 'stock' => 1],
        ['title' => 'Trois petites lumières', 'author' => 'Maria Ramos', 'category' => 'Anak', 'cover' => 'images/book-4.png', 'stock' => 4],
    ];

    $catalogBooks = $catalogBooks ?? [
        ['title' => 'Trois petites lumières', 'author' => 'Maria Ramos', 'category' => 'Anak', 'cover' => 'images/book-4.png', 'stock' => 3],
        ['title' => 'Diary of a Wimpy Kid', 'author' => 'Jeff Kinney', 'category' => 'Fiksi', 'cover' => 'images/book-5.png', 'stock' => 2],
        ['title' => 'Sense and Sensibility', 'author' => 'Jane Austen', 'category' => 'Fiksi', 'cover' => 'images/book-6.png', 'stock' => 1],
        ['title' => 'Beautiful Boy', 'author' => 'David Sheff', 'category' => 'Non-Fiksi', 'cover' => 'images/book-1.png', 'stock' => 0],
        ['title' => 'Persuasion', 'author' => 'Jane Austen', 'category' => 'Fiksi', 'cover' => 'images/book-2.png', 'stock' => 2],
        ['title' => 'Animal Farm', 'author' => 'George Orwell', 'category' => 'Fiksi', 'cover' => 'images/book-3.png', 'stock' => 1],
        ['title' => 'Dead Poets Society', 'author' => 'Robin Williams', 'category' => 'Fiksi', 'cover' => 'images/book-7.png', 'stock' => 0],
        ['title' => 'Marie Antoinette', 'author' => 'Antonia Fraser', 'category' => 'Non-Fiksi', 'cover' => 'images/book-8.png', 'stock' => 2],
        ['title' => 'North and South', 'author' => 'Elizabeth Gaskell', 'category' => 'Fiksi', 'cover' => 'images/book-9.png', 'stock' => 1],
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
        {{-- Sidebar Kiri (tetap diam di desktop, hanya area kanan yang scroll) --}}
        <aside class="w-full lg:w-60 lg:h-full lg:overflow-y-auto shrink-0 bg-[#C7C572] text-[#2C3E50] px-5 py-6 flex lg:flex-col justify-between items-center lg:items-start">
            <div class="w-full flex lg:flex-col items-center lg:items-start justify-between gap-6">
                <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-tight text-[#2C3E50]">
                    batabutu
                </a>

                <nav class="flex lg:flex-col items-center lg:items-stretch gap-2 lg:gap-2.5 w-auto lg:w-full">
                    <a
                        href="{{ Route::has('login') ? route('login') : url('/preview-login') }}"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-[#2C3E50] hover:bg-white/35 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Daftar/Masuk</span>
                    </a>

                    {{-- Menu Beranda (aktif/terpencet pada landing page) --}}
                    <a
                        href="{{ url('/preview-landing') }}"
                        aria-current="page"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm font-semibold bg-white/85 text-[#2C3E50] shadow-xs transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-9.5z" />
                        </svg>
                        <span>Beranda</span>
                    </a>

                    <a
                        href="#katalog-buku"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-[#2C3E50] hover:bg-white/35 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Katalog Buku</span>
                    </a>

                    <a
                        href="#pinjam-buku"
                        class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-[#2C3E50] hover:bg-white/35 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
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
                <a href="{{ url('/') }}" class="text-xl font-extrabold text-[#2C3E50]">
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
                <section class="space-y-5">
                    <div class="flex items-center gap-3">
                        <img
                            src="{{ asset('images/doodle-populer.png') }}"
                            alt="Maskot Populer"
                            class="w-9 h-9 object-contain shrink-0"
                            onerror="this.style.display='none'"
                        >
                        <h2 class="text-xl sm:text-2xl font-bold text-[#2C3E50]">
                            Populer Sekarang
                        </h2>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
                        @foreach ($popularBooks as $book)
                            <article class="group flex flex-col">
                                <div class="relative aspect-[3/4] w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 mb-3">
                                    <img
                                        src="{{ asset($book['cover']) }}"
                                        alt="{{ $book['title'] }}"
                                        class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-200"
                                    >
                                    <span
                                        class="absolute bottom-2.5 right-2.5 w-7 h-7 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-xs {{ $book['stock'] > 0 ? 'bg-[#C7C572]' : 'bg-[#C96A5B]' }}"
                                    >
                                        {{ $book['stock'] }}
                                    </span>
                                </div>
                                <h3 class="text-sm font-bold text-[#2C3E50] line-clamp-1">
                                    {{ $book['title'] }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                    {{ $book['author'] }}
                                </p>
                                <p class="text-xs font-medium text-[#C8A064] mt-0.5">
                                    {{ $book['category'] }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>

                {{-- Katalog Buku --}}
                <section id="katalog-buku" class="space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <img
                                src="{{ asset('images/doodle-katalog.png') }}"
                                alt="Maskot Katalog"
                                class="w-9 h-9 object-contain shrink-0"
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
                                    type="text"
                                    placeholder="Search"
                                    class="pl-9 pr-4 py-2 rounded-full bg-slate-100 text-xs sm:text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-[#C8A064]/50 focus:outline-none w-44 sm:w-52"
                                >
                            </div>

                            <button type="button" class="px-4 py-2 rounded-full bg-[#D9B67C] text-white text-xs sm:text-sm font-semibold cursor-pointer">
                                Semua Buku
                            </button>
                            <button type="button" class="px-4 py-2 rounded-full border border-slate-200 bg-white hover:bg-slate-50 text-xs sm:text-sm font-medium text-[#2C3E50] cursor-pointer">
                                Anak
                            </button>
                            <button type="button" class="px-4 py-2 rounded-full border border-slate-200 bg-white hover:bg-slate-50 text-xs sm:text-sm font-medium text-[#2C3E50] cursor-pointer">
                                Fiksi
                            </button>
                            <button type="button" class="px-4 py-2 rounded-full border border-slate-200 bg-white hover:bg-slate-50 text-xs sm:text-sm font-medium text-[#2C3E50] cursor-pointer">
                                Non-Fiksi
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($catalogBooks as $book)
                            <article class="group flex flex-col">
                                <div class="relative aspect-[3/4] w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 mb-3">
                                    <img
                                        src="{{ asset($book['cover']) }}"
                                        alt="{{ $book['title'] }}"
                                        class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-200"
                                    >
                                    <span
                                        class="absolute bottom-3 right-3 w-7 h-7 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-xs {{ $book['stock'] > 0 ? 'bg-[#C7C572]' : 'bg-[#C96A5B]' }}"
                                    >
                                        {{ $book['stock'] }}
                                    </span>
                                </div>
                                <h3 class="text-sm font-bold text-[#2C3E50] line-clamp-1">
                                    {{ $book['title'] }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                    {{ $book['author'] }}
                                </p>
                                <p class="text-xs font-medium text-[#C8A064] mt-0.5">
                                    {{ $book['category'] }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>

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
                    </div class="w-full flex-1 flex items-center justify-center pt-12 pb-8">
                    <p class="w-full text-center text-xs sm:text-sm text-slate-500">
                        Masuk untuk meminjam buku.
                    </p>
                </section>
            </main>
        </div>
    </div>
</body>
</html>