@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-display font-bold" style="color: var(--dp-text-primary);">Profil Saya</h1>
        <p class="text-sm" style="color: var(--dp-text-secondary);">Kelola informasi akun dan password Anda.</p>
    </div>

    @if(session('status'))
        <div class="mb-6 p-4 rounded-xl font-medium flex items-center gap-3"
            style="background: var(--dp-gold-tint); color: var(--dp-bg-primary); border: 1px solid var(--dp-border-gold);">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl font-medium"
            style="background: var(--dp-danger-tint); color: var(--dp-danger); border: 1px solid var(--dp-danger);">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-xl rounded-2xl p-6" style="background: var(--dp-bg-surface); border: 0.5px solid var(--dp-border);">
        <div class="mb-6 pb-6" style="border-bottom: 1px solid var(--dp-border);">
            <div class="text-sm font-semibold" style="color: var(--dp-text-primary);">{{ Auth::user()->name }}</div>
            <div class="text-sm" style="color: var(--dp-text-secondary);">{{ Auth::user()->email }}</div>
        </div>

        <h2 class="text-lg font-display font-bold mb-4" style="color: var(--dp-text-primary);">Ganti Password</h2>

        <form action="{{ route('dashboard.profile.password.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1" style="color: var(--dp-text-primary);">Password Saat Ini</label>
                <input type="password" name="current_password" required
                    class="w-full rounded-lg px-4 py-2.5 text-sm"
                    style="background: var(--dp-bg-page); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1" style="color: var(--dp-text-primary);">Password Baru</label>
                <input type="password" name="password" required minlength="8"
                    class="w-full rounded-lg px-4 py-2.5 text-sm"
                    style="background: var(--dp-bg-page); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1" style="color: var(--dp-text-primary);">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required minlength="8"
                    class="w-full rounded-lg px-4 py-2.5 text-sm"
                    style="background: var(--dp-bg-page); border: 1px solid var(--dp-border); color: var(--dp-text-primary);">
            </div>

            <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-semibold"
                style="background: var(--dp-bg-primary); color: var(--dp-text-on-primary);">
                Simpan Password Baru
            </button>
        </form>
    </div>
@endsection
