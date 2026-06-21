<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pengurus - DASI Pelajar</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('partials.theme-init')

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }

        /* Animated pattern on branding panel */
        .login-pattern {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(186,158,111,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(186,158,111,0.06) 0%, transparent 40%),
                radial-gradient(circle at 60% 80%, rgba(186,158,111,0.05) 0%, transparent 45%);
        }

        /* Subtle floating animation */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .float-anim { animation: float-slow 6s ease-in-out infinite; }
        .float-anim-delay { animation: float-slow 6s ease-in-out 2s infinite; }

        /* Glass card */
        .login-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .dark .login-glass {
            background: rgba(15,42,30,0.85);
        }

        /* Input focus ring */
        .dp-input:focus {
            border-color: var(--dp-gold);
            box-shadow: 0 0 0 3px var(--dp-gold-tint);
            outline: none;
        }
    </style>
</head>

<body class="antialiased min-h-screen" style="background: var(--dp-bg-page); color: var(--dp-text-primary);">

    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- ====== LEFT PANEL — Branding (hidden mobile, visible lg+) ====== --}}
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden flex-col justify-between"
             style="background: var(--dp-bg-primary);">

            {{-- Pattern overlay --}}
            <div class="absolute inset-0 login-pattern"></div>

            {{-- Decorative circles --}}
            <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full float-anim" style="background: rgba(186,158,111,0.06);"></div>
            <div class="absolute -bottom-32 -right-16 w-96 h-96 rounded-full float-anim-delay" style="background: rgba(186,158,111,0.04);"></div>
            <div class="absolute top-1/3 right-1/4 w-48 h-48 rounded-full float-anim" style="background: rgba(186,158,111,0.05);"></div>

            {{-- Content --}}
            <div class="relative z-10 flex flex-col justify-center flex-1 px-12 xl:px-20">

                {{-- Logo + Brand --}}
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg" style="background: var(--dp-gold);">
                            <img src="{{ asset('img/logo-dark.png') }}" alt="Logo" class="w-10 h-10">
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold tracking-tight" style="color: var(--dp-text-on-primary);">
                                DASI<span style="color: var(--dp-gold);">PELAJAR</span>
                            </h1>
                            <p class="text-xs tracking-widest uppercase" style="color: var(--dp-gold-light); opacity: 0.7;">
                                PC IPNU IPPNU Kediri
                            </p>
                        </div>
                    </div>

                    <h2 class="font-display text-4xl xl:text-5xl font-bold leading-tight mb-6" style="color: var(--dp-text-on-primary);">
                        Digitalisasi<br>
                        <span style="color: var(--dp-gold);">Administrasi</span><br>
                        & Sistem Informasi
                    </h2>

                    <p class="text-base leading-relaxed max-w-md" style="color: rgba(244,244,244,0.6);">
                        Platform operasional organisasi untuk menertibkan dan mengendalikan pergerakan pelajar NU se-Kabupaten Kediri.
                    </p>
                </div>

                {{-- Stats row --}}
                <div class="flex gap-8">
                    <div>
                        <div class="font-display text-3xl font-bold" style="color: var(--dp-gold);">26</div>
                        <div class="text-xs uppercase tracking-wider mt-1" style="color: rgba(244,244,244,0.5);">PAC</div>
                    </div>
                    <div class="w-px" style="background: rgba(186,158,111,0.2);"></div>
                    <div>
                        <div class="font-display text-3xl font-bold" style="color: var(--dp-gold);">343</div>
                        <div class="text-xs uppercase tracking-wider mt-1" style="color: rgba(244,244,244,0.5);">Ranting</div>
                    </div>
                    <div class="w-px" style="background: rgba(186,158,111,0.2);"></div>
                    <div>
                        <div class="font-display text-3xl font-bold" style="color: var(--dp-gold);">2</div>
                        <div class="text-xs uppercase tracking-wider mt-1" style="color: rgba(244,244,244,0.5);">Organisasi</div>
                    </div>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="relative z-10 px-12 xl:px-20 py-6 flex items-center justify-between" style="border-top: 1px solid rgba(186,158,111,0.15);">
                <p class="text-xs" style="color: rgba(244,244,244,0.4);">
                    &copy; {{ date('Y') }} DASI Pelajar
                </p>
                <div class="flex gap-4">
                    <a href="/" class="text-xs hover:underline" style="color: var(--dp-gold-light); opacity: 0.6;">
                        Beranda
                    </a>
                    <a href="/berita" class="text-xs hover:underline" style="color: var(--dp-gold-light); opacity: 0.6;">
                        Berita
                    </a>
                </div>
            </div>
        </div>

        {{-- ====== RIGHT PANEL — Login Form ====== --}}
        <div class="flex-1 flex items-center justify-center px-6 py-12 lg:px-12 relative"
             style="background: var(--dp-bg-page);">

            {{-- Mobile branding (visible < lg) --}}
            <div class="absolute top-0 left-0 right-0 lg:hidden">
                <div class="px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: var(--dp-bg-primary);">
                            <img src="{{ asset('img/logo-dark.png') }}" alt="Logo" class="w-6 h-6">
                        </div>
                        <span class="text-sm font-bold tracking-tight" style="color: var(--dp-text-primary);">
                            DASI<span style="color: var(--dp-gold);">PELAJAR</span>
                        </span>
                    </div>
                    {{-- Theme toggle --}}
                    <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                            class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors"
                            style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                        <span class="material-symbols-outlined text-lg" style="color: var(--dp-text-secondary);">dark_mode</span>
                    </button>
                </div>
            </div>

            {{-- Theme toggle desktop (top right) --}}
            <div class="hidden lg:block absolute top-6 right-6">
                <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                        class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                        style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                    <span class="material-symbols-outlined text-lg" style="color: var(--dp-text-secondary);">dark_mode</span>
                </button>
            </div>

            {{-- Form card --}}
            <div class="w-full max-w-md mt-16 lg:mt-0">

                {{-- Heading --}}
                <div class="mb-8">
                    <h2 class="font-display text-3xl font-bold mb-2" style="color: var(--dp-text-primary);">
                        Selamat Datang
                    </h2>
                    <p class="text-sm" style="color: var(--dp-text-secondary);">
                        Masuk ke dashboard pengurus untuk mengelola organisasi.
                    </p>
                </div>

                {{-- Card --}}
                <div class="login-glass rounded-2xl p-8 shadow-sm" style="border: 1px solid var(--dp-border);">

                    {{-- Error --}}
                    @if($errors->any())
                        <div class="mb-6 p-3.5 rounded-xl flex items-center gap-2.5 text-sm"
                             style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid rgba(232,70,58,0.15);">
                            <span class="material-symbols-outlined text-lg">error</span>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider mb-2"
                                   style="color: var(--dp-text-secondary);">
                                Email Address
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none"
                                      style="color: var(--dp-text-secondary);">
                                    <span class="material-symbols-outlined text-xl">mail</span>
                                </span>
                                <input type="email" name="email" id="email" required autofocus
                                       value="{{ old('email') }}"
                                       class="dp-input block w-full pl-11 pr-4 py-3 rounded-xl text-sm transition-all"
                                       style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);"
                                       placeholder="nama@dasipelajar.or.id">
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider mb-2"
                                   style="color: var(--dp-text-secondary);">
                                Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none"
                                      style="color: var(--dp-text-secondary);">
                                    <span class="material-symbols-outlined text-xl">lock</span>
                                </span>
                                <input type="password" name="password" id="password" required
                                       class="dp-input block w-full pl-11 pr-4 py-3 rounded-xl text-sm transition-all"
                                       style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);"
                                       placeholder="Masukkan password">
                            </div>
                        </div>

                        {{-- Remember me --}}
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="remember"
                                       class="w-4 h-4 rounded transition-colors"
                                       style="accent-color: #08332c;">
                                <span class="text-sm" style="color: var(--dp-text-secondary);">Ingat Saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold transition-colors" style="color: var(--dp-gold);">
                                Lupa password?
                            </a>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 font-semibold py-3.5 rounded-xl shadow-lg transition-all active:scale-[0.98]"
                                style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                                onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                                onmouseout="this.style.background='var(--dp-bg-primary)'">
                            <span>Masuk ke Dashboard</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </form>
                </div>

                {{-- Bottom info --}}
                <div class="mt-6 text-center">
                    <p class="text-xs" style="color: var(--dp-text-secondary); opacity: 0.7;">
                        Akses terbatas untuk pengurus PC IPNU IPPNU Kediri.
                    </p>
                    <a href="/" class="inline-flex items-center gap-1 mt-3 text-xs font-semibold transition-colors"
                       style="color: var(--dp-gold);">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Kembali ke Beranda
                    </a>
                </div>

                {{-- Footer mobile --}}
                <div class="lg:hidden mt-10 text-center">
                    <p class="text-xs" style="color: var(--dp-text-secondary); opacity: 0.5;">
                        &copy; {{ date('Y') }} DASI Pelajar. PC IPNU IPPNU Kediri.
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
