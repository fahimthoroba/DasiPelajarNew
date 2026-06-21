<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - DASI Pelajar</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('partials.theme-init')

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }

        .login-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .dark .login-glass {
            background: rgba(15,42,30,0.85);
        }

        .dp-input:focus {
            border-color: var(--dp-gold);
            box-shadow: 0 0 0 3px var(--dp-gold-tint);
            outline: none;
        }
    </style>
</head>

<body class="antialiased min-h-screen" style="background: var(--dp-bg-page); color: var(--dp-text-primary);">

    <div class="min-h-screen flex items-center justify-center px-6 py-12">

        <div class="absolute top-6 right-6">
            <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                    class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                    style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border);">
                <span class="material-symbols-outlined text-lg" style="color: var(--dp-text-secondary);">dark_mode</span>
            </button>
        </div>

        <div class="w-full max-w-md">

            <div class="mb-8">
                <h2 class="font-display text-3xl font-bold mb-2" style="color: var(--dp-text-primary);">
                    Reset Password
                </h2>
                <p class="text-sm" style="color: var(--dp-text-secondary);">
                    Masukkan password baru untuk akun Anda.
                </p>
            </div>

            <div class="login-glass rounded-2xl p-8 shadow-sm" style="border: 1px solid var(--dp-border);">

                @if($errors->any())
                    <div class="mb-6 p-3.5 rounded-xl flex items-center gap-2.5 text-sm"
                         style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid rgba(232,70,58,0.15);">
                        <span class="material-symbols-outlined text-lg">error</span>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

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
                                   value="{{ old('email', $email) }}"
                                   class="dp-input block w-full pl-11 pr-4 py-3 rounded-xl text-sm transition-all"
                                   style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);"
                                   placeholder="nama@dasipelajar.or.id">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider mb-2"
                               style="color: var(--dp-text-secondary);">
                            Password Baru
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none"
                                  style="color: var(--dp-text-secondary);">
                                <span class="material-symbols-outlined text-xl">lock</span>
                            </span>
                            <input type="password" name="password" id="password" required minlength="8"
                                   class="dp-input block w-full pl-11 pr-4 py-3 rounded-xl text-sm transition-all"
                                   style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);"
                                   placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider mb-2"
                               style="color: var(--dp-text-secondary);">
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none"
                                  style="color: var(--dp-text-secondary);">
                                <span class="material-symbols-outlined text-xl">lock</span>
                            </span>
                            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                   class="dp-input block w-full pl-11 pr-4 py-3 rounded-xl text-sm transition-all"
                                   style="background: var(--dp-bg-surface); border: 1px solid var(--dp-border-strong); color: var(--dp-text-primary);"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 font-semibold py-3.5 rounded-xl shadow-lg transition-all active:scale-[0.98]"
                            style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);"
                            onmouseover="this.style.background='var(--dp-bg-primary-hover)'"
                            onmouseout="this.style.background='var(--dp-bg-primary)'">
                        <span>Reset Password</span>
                        <span class="material-symbols-outlined text-sm">check</span>
                    </button>
                </form>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-xs font-semibold transition-colors"
                   style="color: var(--dp-gold);">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>

</body>

</html>
