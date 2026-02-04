<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pengurus - DASI Pelajar</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: { 900: '#022C22', 800: '#064E3B', 600: '#059669', 500: '#10b981', 400: '#34D399', 50: '#ecfdf5' },
                        amber: { 900: '#78350F', 700: '#B45309', 400: '#FBBF24', 50: '#fffbeb' },
                        surface: { light: '#F8FAFC', card: '#FFFFFF', dark: '#0F172A' }
                    },
                    fontFamily: {
                        display: ['Outfit', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .dark .glass {
            background: rgba(15, 23, 42, 0.7);
        }
    </style>
</head>

<body
    class="font-body text-slate-800 dark:text-gray-100 antialiased bg-surface-light dark:bg-emerald-950 transition-colors duration-300 min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Ambient Background -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div
            class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-emerald-400/30 rounded-full blur-[100px] animate-blob mix-blend-multiply dark:mix-blend-normal">
        </div>
        <div
            class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-amber-300/30 rounded-full blur-[100px] animate-blob animation-delay-2000 mix-blend-multiply dark:mix-blend-normal">
        </div>
        <div
            class="absolute -bottom-[10%] left-[20%] w-[50%] h-[50%] bg-emerald-600/30 rounded-full blur-[100px] animate-blob animation-delay-4000 mix-blend-multiply dark:mix-blend-normal">
        </div>
    </div>

    <!-- Login Card -->
    <div class="relative z-10 w-full max-w-md p-6">
        <div class="glass border border-white/20 rounded-3xl shadow-2xl overflow-hidden relative">

            <!-- Branding Header -->
            <div class="px-8 pt-10 pb-6 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/20 mb-6">
                    <!-- <span class="font-display font-black text-3xl">D</span> -->
                    <img src="{{ asset('img/logo-dark.png') }}?v=2" alt="Logo" class="w-12 h-12">

                </div>
                <h2 class="font-display font-bold text-2xl text-gray-900 dark:text-white mb-2">Selamat Datang</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Silakan login untuk mengakses Dashboard.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('login.post') }}" method="POST" class="px-8 pb-10 space-y-5">
                @csrf

                @if($errors->any())
                    <div
                        class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs font-medium flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">error</span>
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email"
                        class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Email
                        Address</label>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </span>
                        <input type="email" name="email" id="email" required autofocus
                            class="block w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all"
                            placeholder="nama@dasipelajar.or.id">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <label for="password"
                            class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Password</label>
                    </div>
                    <div class="relative group">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                            <span class="material-symbols-outlined text-xl">lock</span>
                        </span>
                        <input type="password" name="password" id="password" required
                            class="block w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded text-emerald-600 border-gray-300 focus:ring-emerald-500 transition-colors">
                        <span
                            class="text-gray-600 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Ingat
                            Saya</span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-600/30 transform transition-all active:scale-[0.98]">
                    <span>Sign In</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>

            </form>

            <!-- Footer -->
            <div
                class="bg-gray-50 dark:bg-gray-800/50 px-8 py-4 text-center border-t border-gray-100 dark:border-white/5">
                <p class="text-xs text-gray-400">
                    &copy; 2025 DasiPelajar. PC IPNU IPPNU Kediri.
                </p>
            </div>
        </div>
    </div>

</body>

</html>