<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $form->nama_kegiatan ?? 'Pendaftaran Ditutup' }} - Dasi Pelajar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="bg-gray-50/50 min-h-screen text-gray-800 font-sans selection:bg-emerald-500 selection:text-white flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white p-8 rounded-3xl shadow-xl text-center border border-gray-100">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-50 text-red-500 rounded-full mb-6">
            <span class="material-symbols-outlined text-4xl">inventory_2</span>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-2 font-display">Status Pendaftaran</h1>
        <p class="text-gray-500 mb-8">{{ $reason }}</p>

        <a href="/" class="inline-flex items-center justify-center w-full px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-600/20">
            <span class="material-symbols-outlined mr-2">home</span>
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>
