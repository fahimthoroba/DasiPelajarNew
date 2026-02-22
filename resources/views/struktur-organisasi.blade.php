<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struktur Organisasi - PC {{ $orgName }} Kediri</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                    }
                }
            }
        }
    </script>
            <style>
                /* --- FIXED HIERARCHICAL CSS --- */
                .org-tree ul {
                    padding-top: 20px;
                    position: relative;
                    transition: all 0.5s;
                    display: flex;
                    justify-content: center;
                }

                .org-tree li {
                    float: left;
                    text-align: center;
                    list-style-type: none;
                    position: relative;
                    padding: 20px 10px 0 10px;
                    transition: all 0.5s;
                }

                /* Connectors */
                .org-tree li::before,
                .org-tree li::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    right: 50%;
                    border-top: 2px solid #cbd5e1;
                    width: 50%;
                    height: 20px;
                }

                .org-tree li::after {
                    right: auto;
                    left: 50%;
                    border-left: 2px solid #cbd5e1;
                }

                .org-tree li:only-child::after,
                .org-tree li:only-child::before {
                    display: none;
                }
                
                .org-tree li:only-child { 
                    padding-top: 0;
                }

                .org-tree li:first-child::before,
                .org-tree li:last-child::after {
                    border: 0 none;
                }

                .org-tree li:last-child::before {
                    border-right: 2px solid #cbd5e1;
                    border-radius: 0 5px 0 0;
                }

                .org-tree li:first-child::after {
                    border-radius: 5px 0 0 0;
                }

                /* Downward line from parent */
                .org-tree ul ul::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 50%;
                    border-left: 2px solid #cbd5e1;
                    width: 0;
                    height: 20px;
                }

                /* Vertical Stack (For Deputies) */
                .deputy-stack {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    position: relative;
                    margin-top: 20px;
                }
                
                .deputy-stack::before {
                    content: '';
                    position: absolute;
                    top: -20px;
                    left: 50%;
                    width: 0;
                    height: 20px;
                    border-left: 2px solid #cbd5e1;
                }

                .deputy-item {
                    position: relative;
                    padding-top: 10px;
                }
                
                .deputy-item::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 50%;
                    width: 0;
                    height: 10px;
                    border-left: 2px solid #cbd5e1; /* Connect to item above */
                }

                /* Card Styles */
                .org-card {
                    background: white;
                    border: 1px solid #e2e8f0;
                    border-radius: 12px;
                    padding: 8px;
                    width: 140px;
                    margin: 0 auto;
                    position: relative;
                    z-index: 10;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    transition: transform 0.2s;
                    cursor: pointer;
                }

                .org-card:hover {
                    transform: translateY(-5px);
                    border-color: #10b981;
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                }

                :is(.dark .org-card) {
                    background-color: #1f2937;
                    border-color: rgba(255, 255, 255, 0.1);
                }

                .org-photo {
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 2px solid #ecfdf5;
                    margin-bottom: 4px;
                }

                :is(.dark .org-photo) {
                    border-color: rgba(255, 255, 255, 0.1);
                }

                .org-name {
                    font-size: 0.75rem;
                    font-weight: 700;
                    line-height: 1.1;
                    margin-bottom: 2px;
                    color: #0f172a;
                    text-align: center;
                }

                :is(.dark .org-name) {
                    color: #f1f5f9;
                }

                .org-role {
                    font-size: 0.65rem;
                    text-transform: uppercase;
                    font-weight: 600;
                    color: #059669;
                    text-align: center;
                }

                /* Dark Mode Connectors */
                :is(.dark .org-tree li::before),
                :is(.dark .org-tree li::after),
                :is(.dark .org-tree ul ul::before),
                :is(.dark .org-tree li:last-child::before),
                :is(.dark .org-tree li:first-child::after),
                :is(.dark .deputy-stack::before),
                :is(.dark .deputy-item::before) {
                    border-color: rgba(255, 255, 255, 0.2);
                }
            </style>

    <main class="bg-slate-50 dark:bg-[#020617] min-h-screen">
        <!-- Navigation / Header -->
        <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 dark:bg-[#020617]/80 backdrop-blur-md border-b border-gray-100 dark:border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 transition-transform">
                            D
                        </div>
                        <span class="font-display font-bold text-xl text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            Dasi<span class="text-emerald-600 dark:text-emerald-500">Pelajar</span>
                        </span>
                    </a>
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-500 transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </nav>

        <div class="pt-32 pb-12 px-4 max-w-7xl mx-auto text-center">
            <h1 class="font-display font-black text-4xl md:text-5xl text-gray-900 dark:text-white mb-4">
                Struktur Organisasi <span class="{{ $tab === 'ippnu' ? 'text-amber-500' : 'text-emerald-600' }}">{{ $orgName }}</span>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg mb-8">Masa Khidmat {{ $periode }}</p>

            <!-- TABS -->
            <div class="inline-flex bg-white dark:bg-slate-800 p-1 rounded-full shadow-lg border border-gray-100 dark:border-white/5 mb-8">
                <a href="?tab=ipnu" 
                   class="px-8 py-2 rounded-full text-sm font-bold transition-all {{ $tab === 'ipnu' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-500 hover:text-emerald-600 dark:text-gray-400' }}">
                   PC IPNU
                </a>
                <a href="?tab=ippnu" 
                   class="px-8 py-2 rounded-full text-sm font-bold transition-all {{ $tab === 'ippnu' ? 'bg-amber-500 text-white shadow-md' : 'text-gray-500 hover:text-amber-500 dark:text-gray-400' }}">
                   PC IPPNU
                </a>
            </div>
        </div>

        <div class="w-full overflow-x-auto pb-12">
            <div class="min-w-[1024px] mx-auto px-4 pt-8 org-tree">
                @php
                    // --- THEME SETUP ---
                    $isIppnu = ($tab === 'ippnu');
                    $theme = $isIppnu ? 'amber' : 'emerald';
                    $themeColor = $isIppnu ? '#f59e0b' : '#10b981';
                    $themeLight = $isIppnu ? '#fffbeb' : '#ecfdf5';
                    $themeBorder = $isIppnu ? '#fcd34d' : '#a7f3d0';

                    // --- RECURSIVE DATA LOGIC ---
                    // 1. Group all by parent_id for O(1) lookup
                    $childrenMap = $pengurusTree->groupBy('parent_id');

                    // 2. Find Root (Ketua) - Usually has parent_id NULL or distinct role 'Ketua'
                    $root = $pengurusTree->first(fn($n) => $n->jabatan === 'Ketua');
                    
                    // Helper to get children
                    $getChildren = fn($parentId) => $childrenMap->get($parentId) ?? collect();
                @endphp

                <style>
                    .theme-border { border-color: {{ $themeColor }}; }
                    .theme-bg-light { background-color: {{ $themeLight }}; }
                    .theme-text { color: {{ $themeColor }}; }
                    .org-card:hover { border-color: {{ $themeColor }}; }
                    .org-role { color: {{ $themeColor }}; }
                    .org-photo { border-color: {{ $themeLight }}; }
                </style>

                @if($root)
                <ul>
                    <li>
                        <!-- ROOT (KETUA) -->
                        <div class="org-card mx-auto" @click="activePerson = {{ json_encode(['name' => $root->kader->nama_lengkap, 'role' => $root->jabatan, 'image' => $root->kader->foto_path ? asset('storage/' . $root->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($root->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $root->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                            <img src="{{ $root->kader->foto_path ? asset('storage/' . $root->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($root->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff' }}" class="org-photo" style="border-color: {{ $themeLight }}">
                            <div class="org-name">{{ $root->kader->nama_lengkap }}</div>
                            <div class="org-role" style="color: {{ $themeColor }}">{{ $root->jabatan }}</div>
                        </div>

                        <!-- TIER 1 CHILDREN (Sek, Ben, Waket, Lembaga Head) -->
                        @php
                            $rootChildren = $getChildren($root->id);
                            
                            // Categorize Children for Layout
                            $sekretarisGroup = $rootChildren->filter(fn($c) => str_contains($c->jabatan, 'Sekretaris'));
                            $bendaharaGroup = $rootChildren->filter(fn($c) => str_contains($c->jabatan, 'Bendahara'));
                            
                            // Remaining are Departments & Lembaga
                            $others = $rootChildren->reject(fn($c) => str_contains($c->jabatan, 'Sekretaris') || str_contains($c->jabatan, 'Bendahara'));
                            
                            $lembagaHeads = $others->filter(fn($c) => 
                                ($c->departemenData && strtolower($c->departemenData->Status ?? '') === 'lembaga') ||
                                in_array($c->jabatan, ['Direktur', 'Komandan'])
                            );
                            
                            $deptHeads = $others->diff($lembagaHeads);
                        @endphp

                        @if($rootChildren->count() > 0)
                        <ul>
                            <li>
                                <!-- CONTAINER FOR SEK & BEN -->
                                <div class="flex justify-center gap-12 mb-8 relative px-4">
                                    <!-- SEKRETARIS BRANCH -->
                                    @foreach($sekretarisGroup as $sek)
                                        <div class="flex flex-col items-center">
                                            <div class="org-card" @click="activePerson = {{ json_encode(['name' => $sek->kader->nama_lengkap, 'role' => $sek->jabatan, 'image' => $sek->kader->foto_path ? asset('storage/' . $sek->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($sek->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $sek->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                <img src="{{ $sek->kader->foto_path ? asset('storage/' . $sek->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($sek->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff' }}" class="org-photo" style="border-color: {{ $themeLight }}">
                                                <div class="org-name">{{ \Illuminate\Support\Str::words($sek->kader->nama_lengkap, 2) }}</div>
                                                <div class="org-role" style="color: {{ $themeColor }}">{{ $sek->jabatan }}</div>
                                            </div>
                                            
                                            <!-- Sub-Sekretaris (Wakil) -->
                                            @php $subSek = $getChildren($sek->id); @endphp
                                            @if($subSek->count() > 0)
                                                <div class="deputy-stack">
                                                    @foreach($subSek as $sub)
                                                        <div class="deputy-item">
                                                            <div class="org-card" style="transform: scale(0.9);" @click="activePerson = {{ json_encode(['name' => $sub->kader->nama_lengkap, 'role' => $sub->jabatan, 'image' => $sub->kader->foto_path ? asset('storage/' . $sub->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($sub->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $sub->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                                <div class="org-name">{{ \Illuminate\Support\Str::words($sub->kader->nama_lengkap, 2) }}</div>
                                                                <div class="org-role text-[10px]" style="color: {{ $themeColor }}">{{ $sub->jabatan }}</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach

                                    <!-- BENDAHARA BRANCH -->
                                    @foreach($bendaharaGroup as $ben)
                                        <div class="flex flex-col items-center">
                                            <div class="org-card" @click="activePerson = {{ json_encode(['name' => $ben->kader->nama_lengkap, 'role' => $ben->jabatan, 'image' => $ben->kader->foto_path ? asset('storage/' . $ben->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($ben->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $ben->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                <img src="{{ $ben->kader->foto_path ? asset('storage/' . $ben->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($ben->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff' }}" class="org-photo" style="border-color: {{ $themeLight }}">
                                                <div class="org-name">{{ \Illuminate\Support\Str::words($ben->kader->nama_lengkap, 2) }}</div>
                                                <div class="org-role" style="color: {{ $themeColor }}">{{ $ben->jabatan }}</div>
                                            </div>

                                            <!-- Sub-Bendahara (Wakil) -->
                                            @php $subBen = $getChildren($ben->id); @endphp
                                            @if($subBen->count() > 0)
                                                <div class="deputy-stack">
                                                    @foreach($subBen as $sub)
                                                        <div class="deputy-item">
                                                            <div class="org-card" style="transform: scale(0.9);" @click="activePerson = {{ json_encode(['name' => $sub->kader->nama_lengkap, 'role' => $sub->jabatan, 'image' => $sub->kader->foto_path ? asset('storage/' . $sub->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($sub->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $sub->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                                <div class="org-name">{{ \Illuminate\Support\Str::words($sub->kader->nama_lengkap, 2) }}</div>
                                                                <div class="org-role text-[10px]" style="color: {{ $themeColor }}">{{ $sub->jabatan }}</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- NEXT TIER: DEPARTMENTS & LEMBAGA -->
                                @if($deptHeads->count() > 0 || $lembagaHeads->count() > 0)
                                <ul>
                                    <!-- DEPARTMENTS ROW -->
                                    <li class="w-full">
                                         <!-- Main Horizontal Line for Dept Key -->
                                         <div class="relative flex justify-center pt-8">
                                             <div class="absolute top-0 left-1/2 -translate-x-1/2 h-8 w-[2px] bg-slate-300"></div>
                                             
                                             <!-- DEPARTMENTS CONTAINER -->
                                             <div class="relative flex gap-4 pt-8 shrink-0">
                                                @if($deptHeads->count() > 1)
                                                    <div class="absolute top-8 left-10 right-10 h-[2px] border-t-2 border-slate-300"></div>
                                                    <div class="absolute top-0 left-1/2 -translate-x-1/2 h-8 w-[2px] bg-slate-300"></div>
                                                @elseif($deptHeads->count() == 1)
                                                     <div class="absolute top-0 left-1/2 -translate-x-1/2 h-8 w-[2px] bg-slate-300"></div>
                                                @endif

                                                @foreach($deptHeads as $waket)
                                                    <div class="flex flex-col items-center relative pt-4 px-2">
                                                        @if($deptHeads->count() > 1)
                                                            <div class="absolute top-0 left-1/2 -translate-x-1/2 h-4 w-[2px] bg-slate-300"></div>
                                                        @endif
                                                        
                                                        <!-- WAKET CARD -->
                                                        <div class="org-card" @click="activePerson = {{ json_encode(['name' => $waket->kader->nama_lengkap, 'role' => $waket->jabatan, 'image' => $waket->kader->foto_path ? asset('storage/' . $waket->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($waket->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $waket->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                            <img src="{{ $waket->kader->foto_path ? asset('storage/' . $waket->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($waket->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff' }}" class="org-photo" style="border-color: {{ $themeLight }}">
                                                            <div class="org-name">{{ \Illuminate\Support\Str::words($waket->kader->nama_lengkap, 2) }}</div>
                                                            <div class="org-role" style="color: {{ $themeColor }}">{{ \Illuminate\Support\Str::words($waket->jabatan, 2) }}</div>
                                                        </div>

                                                        <!-- CHILDREN OF WAKET (Koord/Members) -->
                                                        @php $waketChildren = $getChildren($waket->id); @endphp
                                                        
                                                        @if($waketChildren->count() > 0)
                                                            <div class="h-6 w-[2px] bg-slate-300"></div>
                                                            
                                                            <!-- Recursive rendering for Koord/Members -->
                                                            @foreach($waketChildren as $child)
                                                                 <!-- Koordinator or Member directly? -->
                                                                 <div class="flex flex-col items-center">
                                                                    <div class="org-card" style="border-color: {{ $themeBorder }}; width: 130px;" @click="activePerson = {{ json_encode(['name' => $child->kader->nama_lengkap, 'role' => $child->jabatan, 'image' => $child->kader->foto_path ? asset('storage/' . $child->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($child->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $child->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                                        <div class="org-name">{{ \Illuminate\Support\Str::words($child->kader->nama_lengkap, 2) }}</div>
                                                                        <div class="org-role text-[10px]" style="color: {{ $themeColor }}">{{ $child->jabatan }}</div>
                                                                    </div>
                                                                    
                                                                    <!-- Grandchildren (Members of Korodinator) -->
                                                                    @php $grandChildren = $getChildren($child->id); @endphp
                                                                    @if($grandChildren->count() > 0)
                                                                        <div class="h-4 w-[2px] bg-slate-300"></div>
                                                                        <div class="flex flex-col items-center">
                                                                            @foreach($grandChildren as $gc)
                                                                                 @if(!$loop->first)
                                                                                    <div class="h-3 w-[2px] bg-slate-300"></div>
                                                                                 @endif
                                                                                 <div class="org-card" style="transform: scale(0.85); border-style: dashed;" @click="activePerson = {{ json_encode(['name' => $gc->kader->nama_lengkap, 'role' => $gc->jabatan, 'image' => $gc->kader->foto_path ? asset('storage/' . $gc->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($gc->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $gc->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                                                    <div class="org-name">{{ \Illuminate\Support\Str::words($gc->kader->nama_lengkap, 2) }}</div>
                                                                                    <div class="org-role text-[9px]">Anggota</div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                 </div>
                                                                 <!-- Gap between multiple direct children of Waket if any -->
                                                                 @if(!$loop->last) <div class="h-4"></div> @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                             </div>
                                         </div>

                                         <!-- LEMBAGA SECTION (Separated) -->
                                         @if($lembagaHeads->count() > 0)
                                            <div class="mt-16 w-full relative pt-8">
                                                <!-- Separator -->
                                                <div class="absolute top-0 left-0 w-full border-t border-slate-200 dark:border-white/10"></div>
                                                <!-- <span class="absolute top-[-10px] left-1/2 -translate-x-1/2 bg-slate-50 dark:bg-[#020617] px-4 text-xs font-bold tracking-widest text-slate-400 uppercase">Lembaga & Badan Semi Otonom</span> -->
                                                
                                                <div class="flex flex-wrap justify-center gap-8 pt-6">
                                                    @foreach($lembagaHeads as $head)
                                                        <div class="flex flex-col items-center">
                                                            <!-- HEAD CARD -->
                                                            <div class="org-card" style="border-color: {{ $themeBorder }}; background-color: {{ $themeLight }};" @click="activePerson = {{ json_encode(['name' => $head->kader->nama_lengkap, 'role' => $head->jabatan, 'image' => $head->kader->foto_path ? asset('storage/' . $head->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($head->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $head->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                                <div class="org-name">{{ \Illuminate\Support\Str::words($head->kader->nama_lengkap, 2) }}</div>
                                                                <div class="org-role" style="color: {{ $themeColor }}">{{ $head->jabatan }}</div>
                                                            </div>
                                                            
                                                            <!-- MEMBERS -->
                                                            @php $lembagaMembers = $getChildren($head->id); @endphp
                                                            @if($lembagaMembers->count() > 0)
                                                                <div class="h-4 w-[2px] bg-slate-300"></div>
                                                                <div class="flex flex-col items-center">
                                                                    @foreach($lembagaMembers as $lm)
                                                                        @if(!$loop->first)
                                                                            <div class="h-3 w-[2px] bg-slate-300"></div>
                                                                        @endif
                                                                        <div class="org-card" style="transform: scale(0.85);" @click="activePerson = {{ json_encode(['name' => $lm->kader->nama_lengkap, 'role' => $lm->jabatan, 'image' => $lm->kader->foto_path ? asset('storage/' . $lm->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($lm->kader->nama_lengkap) . '&background=' . substr($themeColor, 1) . '&color=fff', 'quote' => $lm->kader->quote, 'roleClass' => 'bg-'.$theme.'-600']) }}; modalOpen = true">
                                                                            <div class="org-name">{{ \Illuminate\Support\Str::words($lm->kader->nama_lengkap, 2) }}</div>
                                                                            <div class="org-role text-[9px]">Anggota</div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                         @endif
                                    </li>
                                </ul>
                                @endif
                            </li>
                        </ul>
                        @endif
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </main>

    <div x-show="modalOpen" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="modalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all">
                <button @click="modalOpen = false"
                    class="absolute top-4 right-4 z-10 bg-black/50 text-white rounded-full p-1"><span
                        class="material-symbols-outlined text-lg">close</span></button>
                <div class="w-full h-80 bg-gray-100 relative">
                    <img :src="activePerson.image" class="w-full h-full object-cover">
                    <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <div class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2"
                            :class="activePerson.roleClass || 'bg-emerald-600'" x-text="activePerson.role"></div>
                        <h3 class="font-display font-black text-2xl leading-tight" x-text="activePerson.name"></h3>
                    </div>
                </div>
                <div class="p-6 bg-gray-50">
                    <p class="text-gray-600 italic text-sm" x-text="activePerson.quote || 'Belum ada quotes.'"></p>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
</body>

</html>