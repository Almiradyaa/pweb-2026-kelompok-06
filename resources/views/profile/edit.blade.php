<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Profil Akun - Batabutu e-Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-xl text-indigo-600">
                <span>📚 Batabutu</span>
            </a>
            <div class="flex items-center gap-4 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-indigo-600 transition">Dashboard</a>
                <a href="{{ route('katalog') }}" class="text-slate-600 hover:text-indigo-600 transition">Katalog</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Profil Pengguna</h1>
            <p class="text-sm text-slate-500 mt-1">
                Perbarui informasi identitas akun dan keamanan kata sandi Anda.
            </p>
        </div>

        <!-- Card 1: Informasi Profil (Nama & Email) -->
        <section class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Informasi Akun</h2>
                <p class="text-sm text-slate-500">Perbarui nama tampilan dan alamat email terdaftar.</p>
            </div>

            @if (session('status') === 'profile-updated')
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-700 font-medium">
                    Perubahan nama dan email profil berhasil disimpan.
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    >
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-xs text-slate-400">
                        Peran Akun: <strong class="uppercase text-slate-600">{{ $user->role ?? 'Anggota' }}</strong>
                    </span>
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition"
                    >
                        Simpan Profil
                    </button>
                </div>
            </form>
        </section>

        <!-- Card 2: Ubah Password -->
        <section class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Ubah Password</h2>
                <p class="text-sm text-slate-500">Pastikan akun Anda menggunakan password minimal 8 karakter yang kuat.</p>
            </div>

            @if (session('status') === 'password-updated')
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-700 font-medium">
                    Password akun Anda berhasil diperbarui.
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Password Saat Ini</label>
                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        required
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    >
                    @error('current_password')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    >
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl shadow-sm transition"
                    >
                        Perbarui Password
                    </button>
                </div>
            </form>
        </section>
    </main>

</body>
</html>