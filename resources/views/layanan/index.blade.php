<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan & Download - PC IPNU IPPNU Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@400;700;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: { 900: '#022C22', 800: '#064E3B', 400: '#34D399' },
                        amber: { 900: '#78350F', 700: '#B45309', 400: '#FBBF24' },
                        surface: { light: '#F8F8F8' }
                    },
                    fontFamily: {
                        display: ['Outfit', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    @include('partials.theme-init')
</head>

<body
    class="bg-surface-light dark:bg-[#051111] font-body text-gray-800 dark:text-gray-100 antialiased transition-colors duration-300">
    <!-- Navbar -->
    @include('partials.navbar')

    <main class="pt-32 pb-24 px-4 sm:px-6relative min-h-screen">
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <!-- Abstract Background similar to news detail -->
            <div
                class="absolute top-20 left-1/2 w-96 h-96 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-full blur-3xl -translate-x-1/2 pointer-events-none">
            </div>

            <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 mb-8 animate-bounce">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
            </div>
            <h2 class="font-display font-black text-4xl text-gray-900 dark:text-white mb-4">Layanan Digital</h2>
            <p class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl mx-auto mb-12">Halaman ini sedang dalam
                pengembangan. Segera hadir
                layanan download surat, database anggota, dan administrasi online.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left max-w-4xl mx-auto">
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-white/10 hover:border-emerald-200 dark:hover:border-emerald-500/50 hover:shadow-lg transition-all">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-2">Database</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Akses data kader dan struktur.</p>
                    <span
                        class="text-xs bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 px-2 py-1 rounded font-bold">Coming
                        Soon</span>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-white/10 hover:border-emerald-200 dark:hover:border-emerald-500/50 hover:shadow-lg transition-all">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-2">E-Administrasi</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Buat surat otomatis.</p>
                    <span
                        class="text-xs bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 px-2 py-1 rounded font-bold">Coming
                        Soon</span>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-white/10 hover:border-emerald-200 dark:hover:border-emerald-500/50 hover:shadow-lg transition-all">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-2">Arsip Dokumen</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Download Peraturan & Juklak.</p>
                    <span
                        class="text-xs bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 px-2 py-1 rounded font-bold">Coming
                        Soon</span>
                </div>
            </div>
        </div>
    </main>
    @include('partials.footer')
</body>

</html>