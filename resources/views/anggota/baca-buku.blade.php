@php
    $bookTitle = $bookTitle ?? 'Baca E-Book';
    $pdfUrl = $pdfUrl ?? asset('books/sample-book.pdf');
    $initialPage = max(1, (int) ($initialPage ?? 1));
    $backUrl = $backUrl ?? url('/preview-katalog') . '#pinjam-buku';
    $tocItems = $tocItems ?? [
        ['title' => 'Halaman Awal', 'page' => 1],
        ['title' => 'Bab 1 — Pengantar', 'page' => 2],
        ['title' => 'Bab 2 — Pembahasan', 'page' => 5],
        ['title' => 'Bab 3 — Penutup', 'page' => 10],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>batabutu — {{ $bookTitle }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .cardboard-backdrop {
            background: radial-gradient(circle at 50% 42%, #D2B78B 0%, #C4A576 62%, #B69666 100%);
        }

        .book-spread-frame {
            position: relative;
            background-color: #FFFFFF;
            box-shadow:
                -10px 12px 26px rgba(45, 30, 10, 0.24),
                0 18px 40px rgba(45, 30, 10, 0.18),
                -4px 0 0 #F3F2EE,
                -5px 1px 2px rgba(0, 0, 0, 0.14),
                -8px 0 0 #E8E6E0,
                -9px 2px 3px rgba(0, 0, 0, 0.12),
                4px 0 0 #F3F2EE,
                5px 1px 2px rgba(0, 0, 0, 0.12);
        }

        .reader-pages-grid {
            display: grid;
            grid-template-columns: 1fr;
            width: 100%;
            background-color: #FFFFFF;
        }

        .reader-right-slot {
            display: none;
        }

        .reader-spine {
            display: none;
        }

        @media (min-width: 768px) {
            .reader-pages-grid.is-spread {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .reader-pages-grid.is-spread .reader-right-slot {
                display: flex;
            }

            .reader-pages-grid.is-spread .reader-spine {
                display: block;
            }
        }
    </style>
</head>
<body class="min-h-screen cardboard-backdrop text-[#2C3E50] antialiased select-none overflow-x-hidden">
    <div class="relative min-h-screen w-full flex flex-col items-center justify-between px-4 sm:px-10 py-4 sm:py-5">
        {{-- Tombol Kembali "<" Putih di Pojok Kiri Atas --}}
        <div class="w-full max-w-6xl flex items-center justify-between z-20">
            <a
                href="{{ $backUrl }}"
                aria-label="Kembali"
                class="w-10 h-10 rounded-full flex items-center justify-center text-white hover:bg-white/15 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <span id="reader-book-title" class="text-xs sm:text-sm font-bold text-white drop-shadow-2xs truncate max-w-[60%]">
                {{ $bookTitle }}
            </span>

            <span id="reader-page-counter" class="text-xs font-medium text-white min-w-16 text-right"></span>
        </div>

        {{-- Area Kertas Buku Putih di Atas Latar Karton --}}
        <main class="w-full max-w-6xl flex-1 flex items-center justify-center my-2 sm:my-3">
            <div id="reader-paper-frame" class="book-spread-frame w-full max-w-5xl bg-white border border-black/5 overflow-hidden transition-colors duration-150">
                {{-- Status Memuat / Error --}}
                <div id="reader-status" class="min-h-[420px] sm:min-h-[520px] flex flex-col items-center justify-center gap-2 px-6 text-center text-xs sm:text-sm text-slate-500">
                    <span id="reader-status-text">Memuat halaman buku...</span>
                </div>

                {{-- Container Spread 2 Halaman --}}
                <div id="reader-pages-container" class="reader-pages-grid is-spread relative items-stretch" style="display: none;">
                    {{-- Garis Lipatan Tengah & Bayangan Punggung Dalam Buku --}}
                    <div
                        id="spread-spine"
                        class="reader-spine pointer-events-none absolute inset-y-0 left-1/2 -translate-x-1/2 w-8 bg-gradient-to-r from-transparent via-black/12 to-transparent z-10"
                    ></div>

                    {{-- Halaman Kiri --}}
                    <div class="relative flex flex-col justify-between min-w-0 p-3 sm:p-5 md:border-r md:border-slate-200/80 bg-white">
                        <div class="w-full flex items-center justify-center">
                            <canvas id="page-canvas-left" class="block w-full h-auto"></canvas>
                        </div>
                        <span
                            id="page-number-left"
                            class="w-full pt-2 text-left text-[11px] font-semibold text-slate-500"
                        ></span>
                    </div>

                    {{-- Halaman Kanan --}}
                    <div id="right-page-slot" class="reader-right-slot relative flex-col justify-between min-w-0 p-3 sm:p-5 bg-white">
                        <div class="w-full flex items-center justify-center">
                            <canvas id="page-canvas-right" class="block w-full h-auto"></canvas>
                        </div>
                        <span
                            id="page-number-right"
                            class="w-full pt-2 text-right text-[11px] font-semibold text-slate-500"
                        ></span>
                    </div>
                </div>
            </div>
        </main>

        {{-- Panel Popover & Bilah Kontrol Bawah --}}
        <div class="relative w-full max-w-3xl flex flex-col items-center z-30">
            {{-- Popover Daftar Isi --}}
            <div id="panel-toc" class="reader-panel hidden mb-3 w-full max-w-md rounded-2xl bg-white/95 border border-slate-200/80 shadow-[0_12px_30px_rgba(0,0,0,0.16)] p-4 text-xs sm:text-sm">
                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                    <span class="font-bold text-[#2C3E50]">Daftar Isi</span>
                    <button type="button" data-close-panel="panel-toc" class="text-xs text-slate-400 hover:text-[#2C3E50] cursor-pointer">Tutup</button>
                </div>
                <ul id="toc-list" class="max-h-56 overflow-y-auto divide-y divide-slate-100"></ul>
            </div>

            {{-- Popover Tandai Halaman --}}
            <div id="panel-bookmark" class="reader-panel hidden mb-3 w-full max-w-md rounded-2xl bg-white/95 border border-slate-200/80 shadow-[0_12px_30px_rgba(0,0,0,0.16)] p-4 text-xs sm:text-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-[#2C3E50]">Tandai Halaman</span>
                    <button type="button" data-close-panel="panel-bookmark" class="text-xs text-slate-400 hover:text-[#2C3E50] cursor-pointer">Tutup</button>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span id="bookmark-current-info" class="text-xs text-slate-600">Halaman aktif: 1</span>
                    <button
                        id="toggle-bookmark-btn"
                        type="button"
                        class="px-3.5 py-1.5 rounded-full bg-[#C7C572] hover:bg-[#b5b363] text-white text-xs font-semibold transition cursor-pointer"
                    >
                        Tandai Halaman Ini
                    </button>
                </div>
                <div id="bookmark-list" class="flex flex-wrap gap-1.5 pt-1"></div>
            </div>

            {{-- Popover Aa (Skala & Tema Kertas) --}}
            <div id="panel-aa" class="reader-panel hidden mb-3 w-full max-w-sm rounded-2xl bg-white/95 border border-slate-200/80 shadow-[0_12px_30px_rgba(0,0,0,0.16)] p-4 text-xs sm:text-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-[#2C3E50]">Tampilan Baca (Aa)</span>
                    <button type="button" data-close-panel="panel-aa" class="text-xs text-slate-400 hover:text-[#2C3E50] cursor-pointer">Tutup</button>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-600">Ukuran Tampilan</span>
                    <div class="flex items-center gap-2">
                        <button id="zoom-out-btn" type="button" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 font-semibold cursor-pointer">A-</button>
                        <span id="zoom-level-label" class="text-xs font-semibold min-w-12 text-center">100%</span>
                        <button id="zoom-in-btn" type="button" class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 font-semibold cursor-pointer">A+</button>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-600">Warna Kertas</span>
                    <div class="flex items-center gap-2">
                        <button type="button" data-paper-tone="white" class="paper-tone-btn px-3 py-1 rounded-full border border-slate-300 bg-white text-xs cursor-pointer">Putih</button>
                        <button type="button" data-paper-tone="warm" class="paper-tone-btn px-3 py-1 rounded-full border border-amber-200 bg-[#FAF6EC] text-xs cursor-pointer">Hangat</button>
                    </div>
                </div>
            </div>

            {{-- Popover Cari Kata --}}
            <div id="panel-search" class="reader-panel hidden mb-3 w-full max-w-md rounded-2xl bg-white/95 border border-slate-200/80 shadow-[0_12px_30px_rgba(0,0,0,0.16)] p-4 text-xs sm:text-sm space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-[#2C3E50]">Cari Kata</span>
                    <button type="button" data-close-panel="panel-search" class="text-xs text-slate-400 hover:text-[#2C3E50] cursor-pointer">Tutup</button>
                </div>
                <form id="search-word-form" class="flex items-center gap-2">
                    <input
                        id="search-word-input"
                        type="text"
                        placeholder="Ketik kata yang dicari..."
                        class="flex-1 px-3.5 py-1.5 rounded-full bg-slate-100 text-xs sm:text-sm text-[#2C3E50] focus:outline-none focus:ring-2 focus:ring-[#C8A064]/50"
                    >
                    <button
                        type="submit"
                        class="px-4 py-1.5 rounded-full bg-[#D9B67C] hover:bg-[#C8A064] text-white text-xs font-semibold transition cursor-pointer"
                    >
                        Cari
                    </button>
                </form>
                <div id="search-word-results" class="max-h-40 overflow-y-auto space-y-1 text-xs text-slate-600"></div>
            </div>

            {{-- Bilah Kontrol Bawah Sesuai UI --}}
            <footer class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5">
                <button
                    id="btn-toc"
                    type="button"
                    class="px-4 py-1.5 rounded-full bg-[#F5F4F0] hover:bg-white text-[#2C3E50] text-xs font-medium shadow-[0_3px_10px_rgba(45,30,10,0.16)] border border-white/80 transition cursor-pointer"
                >
                    Daftar isi
                </button>

                <button
                    id="btn-bookmark"
                    type="button"
                    class="px-4 py-1.5 rounded-full bg-[#F5F4F0] hover:bg-white text-[#2C3E50] text-xs font-medium shadow-[0_3px_10px_rgba(45,30,10,0.16)] border border-white/80 transition cursor-pointer"
                >
                    Tandai halaman
                </button>

                <button
                    id="btn-aa"
                    type="button"
                    class="px-4 py-1.5 rounded-full bg-[#F5F4F0] hover:bg-white text-[#2C3E50] text-xs font-semibold shadow-[0_3px_10px_rgba(45,30,10,0.16)] border border-white/80 transition cursor-pointer"
                >
                    Aa
                </button>

                <div class="inline-flex items-center rounded-full bg-[#F5F4F0] shadow-[0_3px_10px_rgba(45,30,10,0.16)] border border-white/80 overflow-hidden">
                    <button
                        id="prev-page-btn"
                        type="button"
                        disabled
                        aria-label="Halaman Sebelumnya"
                        class="px-3 py-1.5 hover:bg-white disabled:opacity-40 disabled:cursor-not-allowed text-[#2C3E50] text-xs font-semibold transition cursor-pointer"
                    >
                        &lt;
                    </button>
                    <span class="h-3.5 w-px bg-slate-300/80"></span>
                    <button
                        id="next-page-btn"
                        type="button"
                        disabled
                        aria-label="Halaman Berikutnya"
                        class="px-3 py-1.5 hover:bg-white disabled:opacity-40 disabled:cursor-not-allowed text-[#2C3E50] text-xs font-semibold transition cursor-pointer"
                    >
                        &gt;
                    </button>
                </div>

                <button
                    id="btn-search"
                    type="button"
                    class="px-4 py-1.5 rounded-full bg-[#F5F4F0] hover:bg-white text-[#2C3E50] text-xs font-medium shadow-[0_3px_10px_rgba(45,30,10,0.16)] border border-white/80 transition cursor-pointer"
                >
                    Cari kata
                </button>
            </footer>
        </div>
    </div>

    <script type="module">
        import * as pdfjsLib from 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4.6.82/build/pdf.min.mjs';

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4.6.82/build/pdf.worker.min.mjs';

        const pdfUrl = @json($pdfUrl);
        const startPage = @json($initialPage);
        const fallbackToc = @json($tocItems);

        const statusBox = document.getElementById('reader-status');
        const statusText = document.getElementById('reader-status-text');
        const pagesContainer = document.getElementById('reader-pages-container');
        const paperFrame = document.getElementById('reader-paper-frame');
        const pageCounterEl = document.getElementById('reader-page-counter');

        const leftCanvas = document.getElementById('page-canvas-left');
        const rightCanvas = document.getElementById('page-canvas-right');
        const leftPageNumEl = document.getElementById('page-number-left');
        const rightPageNumEl = document.getElementById('page-number-right');

        const prevBtn = document.getElementById('prev-page-btn');
        const nextBtn = document.getElementById('next-page-btn');

        const btnToc = document.getElementById('btn-toc');
        const btnBookmark = document.getElementById('btn-bookmark');
        const btnAa = document.getElementById('btn-aa');
        const btnSearch = document.getElementById('btn-search');

        const tocListEl = document.getElementById('toc-list');
        const bookmarkCurrentInfo = document.getElementById('bookmark-current-info');
        const toggleBookmarkBtn = document.getElementById('toggle-bookmark-btn');
        const bookmarkListEl = document.getElementById('bookmark-list');
        const zoomInBtn = document.getElementById('zoom-in-btn');
        const zoomOutBtn = document.getElementById('zoom-out-btn');
        const zoomLevelLabel = document.getElementById('zoom-level-label');
        const searchForm = document.getElementById('search-word-form');
        const searchInput = document.getElementById('search-word-input');
        const searchResultsEl = document.getElementById('search-word-results');

        let pdfDoc = null;
        let totalPages = 0;
        let currentPage = 1;
        let zoomFactor = 1;
        let isRendering = false;
        let pendingPage = null;
        let bookmarkedPages = new Set();

        function isSpreadMode() {
            return window.innerWidth >= 768;
        }

        function getStepSize() {
            return isSpreadMode() ? 2 : 1;
        }

        function closeAllPanels() {
            document.querySelectorAll('.reader-panel').forEach((panel) => {
                panel.classList.add('hidden');
            });
        }

        function togglePanel(panelId) {
            const target = document.getElementById(panelId);
            if (!target) return;
            const willOpen = target.classList.contains('hidden');
            closeAllPanels();
            if (willOpen) {
                target.classList.remove('hidden');
            }
        }

        function renderBookmarkUI() {
            const isMarked = bookmarkedPages.has(currentPage);
            bookmarkCurrentInfo.textContent = `Halaman aktif: ${currentPage}`;
            toggleBookmarkBtn.textContent = isMarked ? 'Hapus Tanda' : 'Tandai Halaman Ini';
            btnBookmark.classList.toggle('ring-2', isMarked);
            btnBookmark.classList.toggle('ring-[#C7C572]', isMarked);

            bookmarkListEl.innerHTML = '';
            const sorted = Array.from(bookmarkedPages).sort((a, b) => a - b);
            if (sorted.length === 0) {
                bookmarkListEl.innerHTML = '<span class="text-xs text-slate-400">Belum ada halaman yang ditandai.</span>';
                return;
            }

            sorted.forEach((pg) => {
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.textContent = `Hal. ${pg}`;
                chip.className = 'px-2.5 py-1 rounded-full bg-slate-100 hover:bg-[#F5DEB3] text-xs font-semibold text-[#2C3E50] transition cursor-pointer';
                chip.addEventListener('click', () => {
                    renderCurrentView(pg);
                    closeAllPanels();
                });
                bookmarkListEl.appendChild(chip);
            });
        }

        async function buildTocList() {
            tocListEl.innerHTML = '';
            let entries = [];

            if (pdfDoc) {
                try {
                    const outline = await pdfDoc.getOutline();
                    if (Array.isArray(outline) && outline.length > 0) {
                        for (const item of outline.slice(0, 20)) {
                            let destPage = 1;
                            if (typeof item.dest === 'string') {
                                const destObj = await pdfDoc.getDestination(item.dest);
                                if (destObj) {
                                    const pageIndex = await pdfDoc.getPageIndex(destObj[0]);
                                    destPage = pageIndex + 1;
                                }
                            } else if (Array.isArray(item.dest) && item.dest[0]) {
                                const pageIndex = await pdfDoc.getPageIndex(item.dest[0]);
                                destPage = pageIndex + 1;
                            }
                            entries.push({ title: item.title || `Halaman ${destPage}`, page: destPage });
                        }
                    }
                } catch (_) {
                    // Pakai fallback jika PDF tidak punya outline internal
                }
            }

            if (entries.length === 0) {
                entries = fallbackToc.filter((item) => !totalPages || item.page <= totalPages);
            }

            entries.forEach((entry) => {
                const li = document.createElement('li');
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full flex items-center justify-between py-2 px-1 text-left hover:bg-slate-50 text-xs sm:text-sm text-[#2C3E50] transition cursor-pointer';
                btn.innerHTML = `<span class="truncate pr-2">${entry.title}</span><span class="text-xs text-slate-400 shrink-0">Hal. ${entry.page}</span>`;
                btn.addEventListener('click', () => {
                    renderCurrentView(entry.page);
                    closeAllPanels();
                });
                li.appendChild(btn);
                tocListEl.appendChild(li);
            });
        }

        async function renderSinglePage(pageNum, canvas, labelEl) {
            const ctx = canvas.getContext('2d');
            if (!pdfDoc || pageNum < 1 || pageNum > totalPages) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                canvas.style.width = '0px';
                canvas.style.height = '0px';
                if (labelEl) labelEl.textContent = '';
                return;
            }

            const page = await pdfDoc.getPage(pageNum);
            const slotWrapper = canvas.parentElement;
            const frameWidth = paperFrame.clientWidth || 960;
            const columnWidth = isSpreadMode()
                ? Math.max(200, Math.floor(frameWidth / 2) - 40)
                : Math.max(220, (slotWrapper?.clientWidth || frameWidth) - 24);

            const unscaledViewport = page.getViewport({ scale: 1 });
            const scale = (columnWidth / unscaledViewport.width) * zoomFactor;
            const cssWidth = Math.floor(unscaledViewport.width * scale);
            const cssHeight = Math.floor(unscaledViewport.height * scale);

            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            const renderViewport = page.getViewport({ scale: scale * dpr });

            canvas.width = Math.floor(renderViewport.width);
            canvas.height = Math.floor(renderViewport.height);
            canvas.style.width = `${cssWidth}px`;
            canvas.style.height = `${cssHeight}px`;

            await page.render({
                canvasContext: ctx,
                viewport: renderViewport,
            }).promise;

            if (labelEl) {
                labelEl.textContent = String(pageNum);
            }
        }

        function updateControls() {
            const step = getStepSize();
            const endPage = Math.min(totalPages, currentPage + step - 1);
            pageCounterEl.textContent = totalPages > 0
                ? (isSpreadMode() && endPage > currentPage ? `${currentPage}-${endPage} / ${totalPages}` : `${currentPage} / ${totalPages}`)
                : '';

            prevBtn.disabled = !pdfDoc || currentPage <= 1;
            nextBtn.disabled = !pdfDoc || endPage >= totalPages;
            renderBookmarkUI();
        }

        async function renderCurrentView(targetPage) {
            if (!pdfDoc) return;
            if (isRendering) {
                pendingPage = targetPage;
                return;
            }

            isRendering = true;
            currentPage = Math.min(Math.max(1, targetPage), totalPages);
            pagesContainer.classList.toggle('is-spread', isSpreadMode());

            try {
                await renderSinglePage(currentPage, leftCanvas, leftPageNumEl);

                if (isSpreadMode() && currentPage + 1 <= totalPages) {
                    rightCanvas.style.visibility = 'visible';
                    await renderSinglePage(currentPage + 1, rightCanvas, rightPageNumEl);
                } else {
                    rightCanvas.style.visibility = 'hidden';
                    rightCanvas.getContext('2d').clearRect(0, 0, rightCanvas.width, rightCanvas.height);
                    rightPageNumEl.textContent = '';
                }

                updateControls();
            } finally {
                isRendering = false;
                if (pendingPage !== null) {
                    const nextToRender = pendingPage;
                    pendingPage = null;
                    renderCurrentView(nextToRender);
                }
            }
        }

        async function initReader() {
            try {
                const loadingTask = pdfjsLib.getDocument(pdfUrl);
                pdfDoc = await loadingTask.promise;
                totalPages = pdfDoc.numPages;

                statusBox.style.display = 'none';
                pagesContainer.style.display = 'grid';

                await buildTocList();
                await renderCurrentView(startPage);
            } catch (error) {
                console.error(error);
                statusText.textContent = 'File PDF belum ditemukan atau gagal dimuat. Pastikan file PDF tersedia di path yang sesuai.';
            }
        }

        btnToc.addEventListener('click', () => togglePanel('panel-toc'));
        btnBookmark.addEventListener('click', () => togglePanel('panel-bookmark'));
        btnAa.addEventListener('click', () => togglePanel('panel-aa'));
        btnSearch.addEventListener('click', () => {
            togglePanel('panel-search');
            setTimeout(() => searchInput?.focus(), 50);
        });

        document.querySelectorAll('[data-close-panel]').forEach((btn) => {
            btn.addEventListener('click', () => {
                document.getElementById(btn.dataset.closePanel)?.classList.add('hidden');
            });
        });

        toggleBookmarkBtn.addEventListener('click', () => {
            if (bookmarkedPages.has(currentPage)) {
                bookmarkedPages.delete(currentPage);
            } else {
                bookmarkedPages.add(currentPage);
            }
            renderBookmarkUI();
        });

        zoomInBtn.addEventListener('click', () => {
            zoomFactor = Math.min(1.2, Number((zoomFactor + 0.05).toFixed(2)));
            zoomLevelLabel.textContent = `${Math.round(zoomFactor * 100)}%`;
            renderCurrentView(currentPage);
        });

        zoomOutBtn.addEventListener('click', () => {
            zoomFactor = Math.max(0.8, Number((zoomFactor - 0.05).toFixed(2)));
            zoomLevelLabel.textContent = `${Math.round(zoomFactor * 100)}%`;
            renderCurrentView(currentPage);
        });

        document.querySelectorAll('.paper-tone-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                const isWarm = btn.dataset.paperTone === 'warm';
                const tone = isWarm ? '#FAF6EC' : '#FFFFFF';
                paperFrame.style.backgroundColor = tone;
                pagesContainer.style.backgroundColor = tone;
            });
        });

        searchForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const query = (searchInput.value || '').trim().toLowerCase();
            searchResultsEl.innerHTML = '';
            if (!query || !pdfDoc) return;

            searchResultsEl.innerHTML = '<p class="text-slate-400">Mencari di halaman...</p>';
            const matches = [];

            for (let i = 1; i <= totalPages; i++) {
                const page = await pdfDoc.getPage(i);
                const textContent = await page.getTextContent();
                const fullText = textContent.items.map((item) => item.str || '').join(' ');
                if (fullText.toLowerCase().includes(query)) {
                    matches.push(i);
                }
            }

            searchResultsEl.innerHTML = '';
            if (matches.length === 0) {
                searchResultsEl.innerHTML = '<p class="text-slate-400">Kata tidak ditemukan.</p>';
                return;
            }

            matches.slice(0, 15).forEach((pageNum) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = `Ditemukan di Halaman ${pageNum}`;
                btn.className = 'block w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-100 font-medium text-[#2C3E50] cursor-pointer';
                btn.addEventListener('click', () => {
                    renderCurrentView(pageNum);
                    closeAllPanels();
                });
                searchResultsEl.appendChild(btn);
            });
        });

        prevBtn.addEventListener('click', () => {
            renderCurrentView(currentPage - getStepSize());
        });

        nextBtn.addEventListener('click', () => {
            renderCurrentView(currentPage + getStepSize());
        });

        document.addEventListener('keydown', (e) => {
            if (document.activeElement === searchInput) return;
            if (e.key === 'Escape') {
                closeAllPanels();
            } else if (e.key === 'ArrowLeft') {
                renderCurrentView(currentPage - getStepSize());
            } else if (e.key === 'ArrowRight') {
                renderCurrentView(currentPage + getStepSize());
            }
        });

        let resizeTimer = null;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                renderCurrentView(currentPage);
            }, 150);
        });

        initReader();
    </script>
</body>
</html>