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

            <div class="w-full overflow-x-auto pb-12">
                <div class="min-w-[1024px] mx-auto px-4 pt-8 org-tree">
                    @php
                        // 1. KETUA
                        $ketua = $pengurusTree->first(fn($n) => \Illuminate\Support\Str::contains($n->jabatan, 'Ketua') && !\Illuminate\Support\Str::contains($n->jabatan, 'Wakil'));
                        if (!$ketua) $ketua = $pengurusTree->first();

                        if ($ketua) {
                            $subordinates = $pengurusTree->filter(fn($n) => $n->id !== $ketua->id);
                            
                            // 2. SEKRETARIS & BENDAHARA (Main Only)
                            $mainSek = $subordinates->filter(fn($c) => \Illuminate\Support\Str::contains($c->jabatan, 'Sekretaris') && !\Illuminate\Support\Str::contains($c->jabatan, 'Wakil'))->first();
                            $mainBen = $subordinates->filter(fn($c) => \Illuminate\Support\Str::contains($c->jabatan, 'Bendahara') && !\Illuminate\Support\Str::contains($c->jabatan, 'Wakil'))->first();

                            // 3. WAKIL SEKRETARIS & WAKIL BENDAHARA
                            $wakilSek = $subordinates->filter(fn($c) => \Illuminate\Support\Str::contains($c->jabatan, 'Wakil Sekretaris'))->sortBy('urutan_tampil');
                            $wakilBen = $subordinates->filter(fn($c) => \Illuminate\Support\Str::contains($c->jabatan, 'Wakil Bendahara'))->sortBy('urutan_tampil');

                            // 4. WAKIL KETUA
                            $waka = $subordinates->filter(fn($c) => \Illuminate\Support\Str::contains($c->jabatan, 'Wakil Ketua'))->sortBy('urutan_tampil');

                            // Identify used IDs
                            $usedIds = collect([$ketua->id]);
                            if($mainSek) $usedIds->push($mainSek->id);
                            if($mainBen) $usedIds->push($mainBen->id);
                            $usedIds = $usedIds->merge($wakilSek->pluck('id'))
                                               ->merge($wakilBen->pluck('id'))
                                               ->merge($waka->pluck('id'));

                            // 5. DEPARTEMEN / LEMBAGA (Group remaining by department or list leftovers)
                            $leftovers = $subordinates->whereNotIn('id', $usedIds)->sortBy('urutan_tampil');
                            
                            // Group by Departemen Name/ID if available, otherwise just list them
                            // Assumption: 'urutan_tampil' helps sort them correctly
                        }
                    @endphp

                    @if($ketua)
                    <ul>
                        <li>
                            <div class="org-card" @click="activePerson = {{ json_encode(['name' => $ketua->kader->nama_lengkap, 'role' => $ketua->jabatan, 'image' => $ketua->kader->foto_path ? asset('storage/' . $ketua->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($ketua->kader->nama_lengkap) . '&background=059669&color=fff', 'quote' => $ketua->kader->quote]) }}; modalOpen = true">
                                <img src="{{ $ketua->kader->foto_path ? asset('storage/' . $ketua->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($ketua->kader->nama_lengkap) . '&background=059669&color=fff' }}" class="org-photo">
                                <div class="org-name">{{ $ketua->kader->nama_lengkap }}</div>
                                <div class="org-role">{{ $ketua->jabatan }}</div>
                            </div>

                            <!-- LEVEL 2: SEKRETARIS --- [ WAKAS NODE ] --- BENDAHARA -->
                            <ul>
                                <!-- LEFT WING: SEKRETARIS -->
                                @if($mainSek)
                                <li>
                                    <div class="org-card" @click="activePerson = {{ json_encode(['name' => $mainSek->kader->nama_lengkap, 'role' => $mainSek->jabatan, 'image' => $mainSek->kader->foto_path ? asset('storage/' . $mainSek->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($mainSek->kader->nama_lengkap) . '&background=059669&color=fff', 'quote' => $mainSek->kader->quote]) }}; modalOpen = true">
                                        <img src="{{ $mainSek->kader->foto_path ? asset('storage/' . $mainSek->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($mainSek->kader->nama_lengkap) . '&background=059669&color=fff' }}" class="org-photo">
                                        <div class="org-name">{{ \Illuminate\Support\Str::words($mainSek->kader->nama_lengkap, 2) }}</div>
                                        <div class="org-role">Sekretaris</div>
                                    </div>
                                    @if($wakilSek->count() > 0)
                                        <div class="deputy-stack">
                                            @foreach($wakilSek as $ws)
                                                <div class="deputy-item">
                                                    <div class="org-card" style="transform: scale(0.9); opacity: 0.9;" @click="activePerson = {{ json_encode(['name' => $ws->kader->nama_lengkap, 'role' => $ws->jabatan, 'image' => $ws->kader->foto_path ? asset('storage/' . $ws->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($ws->kader->nama_lengkap) . '&background=059669&color=fff', 'quote' => $ws->kader->quote]) }}; modalOpen = true">
                                                        <div class="org-name">{{ \Illuminate\Support\Str::words($ws->kader->nama_lengkap, 2) }}</div>
                                                        <div class="org-role text-[10px]">W. Sekretaris</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                                @endif

                                <!-- CENTER: WAKIL KETUA GROUP -->
                                <li>
                                     <!-- Placeholder connector node to center the Waket group -->
                                     <div class="w-[1px] h-[20px] bg-slate-300 mx-auto mb-4"></div>
                                     
                                     <!-- Container for Waket that spans width -->
                                     <div class="relative flex justify-center gap-4">
                                         <!-- Draw line above Waket group -->
                                         <div class="absolute -top-4 left-4 right-4 h-[2px] border-t-2 border-slate-300"></div>
                                         <div class="absolute -top-4 left-1/2 -translate-x-1/2 h-[4px] bg-slate-300 w-[2px]"></div>

                                         @foreach($waka as $wk)
                                            <div class="flex flex-col items-center relative pt-4">
                                                <!-- Connector up to the horizontal bar -->
                                                <div class="absolute top-0 left-1/2 -translate-x-1/2 h-[16px] w-[2px] bg-slate-300"></div>
                                                
                                                <div class="org-card" @click="activePerson = {{ json_encode(['name' => $wk->kader->nama_lengkap, 'role' => $wk->jabatan, 'image' => $wk->kader->foto_path ? asset('storage/' . $wk->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($wk->kader->nama_lengkap) . '&background=059669&color=fff', 'quote' => $wk->kader->quote]) }}; modalOpen = true">
                                                    <img src="{{ $wk->kader->foto_path ? asset('storage/' . $wk->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($wk->kader->nama_lengkap) . '&background=059669&color=fff' }}" class="org-photo">
                                                    <div class="org-name">{{ \Illuminate\Support\Str::words($wk->kader->nama_lengkap, 2) }}</div>
                                                    <div class="org-role">Wakil Ketua</div>
                                                </div>
                                            </div>
                                         @endforeach
                                     </div>

                                     <!-- LEMBAGA / DEPARTOMEN (Below Wakil Ketua) -->
                                     @if($leftovers->count() > 0)
                                        <div class="mt-12 relative pt-8 border-t border-slate-200 dark:border-white/10 w-full">
                                            <div class="absolute -top-[20px] left-1/2 -translate-x-1/2 h-[20px] w-[2px] bg-slate-300"></div>
                                            <h3 class="text-center font-bold text-emerald-800 dark:text-emerald-400 mb-6 uppercase tracking-widest text-sm">Lembaga & Departemen</h3>
                                            
                                            <div class="flex flex-wrap justify-center gap-6">
                                                @foreach($leftovers as $l)
                                                     <div class="org-card" style="border-color: #f59e0b;" @click="activePerson = {{ json_encode(['name' => $l->kader->nama_lengkap, 'role' => $l->jabatan, 'image' => $l->kader->foto_path ? asset('storage/' . $l->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($l->kader->nama_lengkap) . '&background=f59e0b&color=fff', 'quote' => $l->kader->quote]) }}; modalOpen = true">
                                                        <img src="{{ $l->kader->foto_path ? asset('storage/' . $l->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($l->kader->nama_lengkap) . '&background=f59e0b&color=fff' }}" class="org-photo" style="border-color: #fef3c7;">
                                                        <div class="org-name">{{ \Illuminate\Support\Str::words($l->kader->nama_lengkap, 2) }}</div>
                                                        <div class="org-role text-amber-700 dark:text-amber-500">{{ \Illuminate\Support\Str::limit($l->jabatan, 20) }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                     @endif
                                </li>

                                <!-- RIGHT WING: BENDAHARA -->
                                @if($mainBen)
                                <li>
                                    <div class="org-card" @click="activePerson = {{ json_encode(['name' => $mainBen->kader->nama_lengkap, 'role' => $mainBen->jabatan, 'image' => $mainBen->kader->foto_path ? asset('storage/' . $mainBen->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($mainBen->kader->nama_lengkap) . '&background=059669&color=fff', 'quote' => $mainBen->kader->quote]) }}; modalOpen = true">
                                        <img src="{{ $mainBen->kader->foto_path ? asset('storage/' . $mainBen->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($mainBen->kader->nama_lengkap) . '&background=059669&color=fff' }}" class="org-photo">
                                        <div class="org-name">{{ \Illuminate\Support\Str::words($mainBen->kader->nama_lengkap, 2) }}</div>
                                        <div class="org-role">Bendahara</div>
                                    </div>
                                    @if($wakilBen->count() > 0)
                                        <div class="deputy-stack">
                                            @foreach($wakilBen as $wb)
                                                <div class="deputy-item">
                                                    <div class="org-card" style="transform: scale(0.9); opacity: 0.9;" @click="activePerson = {{ json_encode(['name' => $wb->kader->nama_lengkap, 'role' => $wb->jabatan, 'image' => $wb->kader->foto_path ? asset('storage/' . $wb->kader->foto_path) : 'https://ui-avatars.com/api/?name=' . urlencode($wb->kader->nama_lengkap) . '&background=059669&color=fff', 'quote' => $wb->kader->quote]) }}; modalOpen = true">
                                                        <div class="org-name">{{ \Illuminate\Support\Str::words($wb->kader->nama_lengkap, 2) }}</div>
                                                        <div class="org-role text-[10px]">W. Bendahara</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>!-- Mobile list removed to use horizontally scrollable desktop tree -->

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