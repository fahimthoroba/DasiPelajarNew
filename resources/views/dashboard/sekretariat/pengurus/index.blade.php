@extends('layouts.dashboard')

@section('title', 'Manajemen Pengurus PC')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6" x-data="{ activeTab: 'IPNU' }">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Formatur Pengurus {{ $organisasi->nama }}</h1>
                <div class="text-sm text-slate-500">
                    Mode Bulk Editor - {{ $sk_aktif->judul_sk ?? 'SK Belum Dipilih' }}
                </div>
            </div>
            
            <!-- CLIENT-SIDE TABS -->
            <div class="bg-white dark:bg-gray-800 p-1 rounded-lg border border-slate-200 dark:border-white/10 flex">
                <button @click="activeTab = 'IPNU'" 
                   :class="activeTab === 'IPNU' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-white/5'"
                   class="px-4 py-2 rounded-md text-sm font-bold transition-colors">
                   IPNU
                </button>
                <button @click="activeTab = 'IPPNU'" 
                   :class="activeTab === 'IPPNU' ? 'bg-amber-500 text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-white/5'"
                   class="px-4 py-2 rounded-md text-sm font-bold transition-colors">
                   IPPNU
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ========================== -->
        <!-- FORM IPNU -->
        <!-- ========================== -->
        <form action="{{ route('dashboard.sekretariat.pengurus.bulk-store') }}" method="POST" 
              class="space-y-8" x-show="activeTab === 'IPNU'" x-data="pengurusForm()">
            @csrf
            <input type="hidden" name="kategori" value="IPNU">
            <input type="hidden" name="organisasi_id" value="{{ $organisasi->id }}">
            <input type="hidden" name="sk_id" value="{{ $sk_aktif->id }}">

            <!-- SK SELECTION (IPNU) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Dasar Surat Keputusan (SK) - IPNU</label>
                <div class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-slate-700 font-medium">
                    {{ $sk_aktif->nomor_sk }} ({{ $sk_aktif->judul_sk }})
                </div>
            </div>

            <!-- CORE OFFICERS (IPNU) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white border-b pb-2">Pengurus Harian Inti (IPNU)</h3>
                @php
                    $cat = 'IPNU';
                    $ketua = $pengurus->first(fn($p) => $p->jabatan === 'Ketua' && $p->kategori === $cat);
                    $sek = $pengurus->first(fn($p) => $p->jabatan === 'Sekretaris' && $p->kategori === $cat && !$p->departemen_id);
                    $ben = $pengurus->first(fn($p) => $p->jabatan === 'Bendahara' && $p->kategori === $cat && !$p->departemen_id);
                    $pKey = 'ipnu';
                @endphp
                <div>
                    <label class="badge-role bg-emerald-100 text-emerald-800">Ketua</label>
                    <input type="hidden" name="pengurus[{{ $pKey }}_ketua][jabatan]" value="Ketua">
                    <input type="hidden" name="pengurus[{{ $pKey }}_ketua][kategori]" value="{{ $cat }}">
                    @if($ketua) <input type="hidden" name="pengurus[{{ $pKey }}_ketua][id]" value="{{ $ketua->id }}"> @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-1">
                        <div class="md:col-span-1 border-r pr-3 border-transparent md:border-slate-200">
                            <input type="text" name="pengurus[{{ $pKey }}_ketua][kader_nama]" value="{{ $ketua?->kader->nama_lengkap }}" list="kaderList" class="input-field" placeholder="Nama Ketua...">
                        </div>
                        <div class="md:col-span-2 grid grid-cols-2 gap-3 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">No. HP (Username)</label>
                                <input type="text" name="pengurus[{{ $pKey }}_ketua][phone]" value="{{ $ketua?->kader->no_hp }}" class="input-field text-sm !py-1.5" placeholder="0812345...">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Tgl Lahir (Password)</label>
                                <input type="date" name="pengurus[{{ $pKey }}_ketua][dob]" value="{{ $ketua?->kader->tanggal_lahir }}" class="input-field text-sm !py-1.5">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="badge-role bg-blue-100 text-blue-800">Sekretaris</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][jabatan]" value="Sekretaris">
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][kategori]" value="{{ $cat }}">
                        @if($sek) <input type="hidden" name="pengurus[{{ $pKey }}_sek][id]" value="{{ $sek->id }}"> @endif
                        <div class="space-y-2 mt-1">
                            <input type="text" name="pengurus[{{ $pKey }}_sek][kader_nama]" value="{{ $sek?->kader->nama_lengkap }}" list="kaderList" class="input-field" placeholder="Nama Sekretaris...">
                            <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                                <div><input type="text" name="pengurus[{{ $pKey }}_sek][phone]" value="{{ $sek?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP..."></div>
                                <div><input type="date" name="pengurus[{{ $pKey }}_sek][dob]" value="{{ $sek?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Tgl Lahir"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="badge-role bg-amber-100 text-amber-800">Bendahara</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][jabatan]" value="Bendahara">
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][kategori]" value="{{ $cat }}">
                        @if($ben) <input type="hidden" name="pengurus[{{ $pKey }}_ben][id]" value="{{ $ben->id }}"> @endif
                        <div class="space-y-2 mt-1">
                            <input type="text" name="pengurus[{{ $pKey }}_ben][kader_nama]" value="{{ $ben?->kader->nama_lengkap }}" list="kaderList" class="input-field" placeholder="Nama Bendahara...">
                            <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                                <div><input type="text" name="pengurus[{{ $pKey }}_ben][phone]" value="{{ $ben?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP..."></div>
                                <div><input type="date" name="pengurus[{{ $pKey }}_ben][dob]" value="{{ $ben?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Tgl Lahir"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DEPARTMENTS (IPNU) -->
            @foreach($departemens->whereIn('kategori', ['IPNU', 'Joint']) as $dept)
                <!-- Shared component logic -->
                @include('dashboard.sekretariat.pengurus.partials.dept-card', ['dept' => $dept, 'cat' => 'IPNU', 'pengurus' => $pengurus, 'kaders' => $kaders])
            @endforeach

            <!-- BUTTONS IPNU (Static, not fixed) -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-white/10">
                <button type="button" onclick="history.back()" class="text-slate-500 font-bold px-4 py-2 hover:bg-slate-50 rounded-lg">
                    Batal
                </button>
                <button type="submit" class="bg-emerald-600 text-white px-8 py-2.5 rounded-full shadow-lg font-bold flex items-center gap-2 hover:bg-emerald-700 transition-all hover:scale-105">
                    <span class="material-symbols-outlined">save</span> Simpan Data IPNU
                </button>
            </div>
        </form>


        <!-- ========================== -->
        <!-- FORM IPPNU -->
        <!-- ========================== -->
        <form action="{{ route('dashboard.sekretariat.pengurus.bulk-store') }}" method="POST" 
              class="space-y-8" x-show="activeTab === 'IPPNU'" x-data="pengurusForm()" x-cloak>
            @csrf
            <input type="hidden" name="kategori" value="IPPNU">

            <input type="hidden" name="organisasi_id" value="{{ $organisasi->id }}">
            <input type="hidden" name="sk_id" value="{{ $sk_aktif->id }}">

            <!-- SK SELECTION (IPPNU) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Dasar Surat Keputusan (SK) - IPPNU</label>
                <div class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-slate-700 font-medium">
                    {{ $sk_aktif->nomor_sk }} ({{ $sk_aktif->judul_sk }})
                </div>
            </div>

            <!-- CORE OFFICERS (IPPNU) -->
             <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white border-b pb-2">Pengurus Harian Inti (IPPNU)</h3>
                @php
                    $cat = 'IPPNU';
                    $ketua = $pengurus->first(fn($p) => $p->jabatan === 'Ketua' && $p->kategori === $cat);
                    $sek = $pengurus->first(fn($p) => $p->jabatan === 'Sekretaris' && $p->kategori === $cat && !$p->departemen_id);
                    $ben = $pengurus->first(fn($p) => $p->jabatan === 'Bendahara' && $p->kategori === $cat && !$p->departemen_id);
                    $pKey = 'ippnu';
                @endphp
                <div>
                    <label class="badge-role bg-amber-100 text-amber-800">Ketua</label>
                    <input type="hidden" name="pengurus[{{ $pKey }}_ketua][jabatan]" value="Ketua">
                    <input type="hidden" name="pengurus[{{ $pKey }}_ketua][kategori]" value="{{ $cat }}">
                    @if($ketua) <input type="hidden" name="pengurus[{{ $pKey }}_ketua][id]" value="{{ $ketua->id }}"> @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-1">
                        <div class="md:col-span-1 border-r pr-3 border-transparent md:border-slate-200">
                            <input type="text" name="pengurus[{{ $pKey }}_ketua][kader_nama]" value="{{ $ketua?->kader->nama_lengkap }}" list="kaderList" class="input-field" placeholder="Nama Ketua...">
                        </div>
                        <div class="md:col-span-2 grid grid-cols-2 gap-3 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">No. HP (Username)</label>
                                <input type="text" name="pengurus[{{ $pKey }}_ketua][phone]" value="{{ $ketua?->kader->no_hp }}" class="input-field text-sm !py-1.5" placeholder="0812345...">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Tgl Lahir (Password)</label>
                                <input type="date" name="pengurus[{{ $pKey }}_ketua][dob]" value="{{ $ketua?->kader->tanggal_lahir }}" class="input-field text-sm !py-1.5">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="badge-role bg-blue-100 text-blue-800">Sekretaris</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][jabatan]" value="Sekretaris">
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][kategori]" value="{{ $cat }}">
                        @if($sek) <input type="hidden" name="pengurus[{{ $pKey }}_sek][id]" value="{{ $sek->id }}"> @endif
                        <div class="space-y-2 mt-1">
                            <input type="text" name="pengurus[{{ $pKey }}_sek][kader_nama]" value="{{ $sek?->kader->nama_lengkap }}" list="kaderList" class="input-field" placeholder="Nama Sekretaris...">
                            <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                                <div><input type="text" name="pengurus[{{ $pKey }}_sek][phone]" value="{{ $sek?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP..."></div>
                                <div><input type="date" name="pengurus[{{ $pKey }}_sek][dob]" value="{{ $sek?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Tgl Lahir"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="badge-role bg-amber-100 text-amber-800">Bendahara</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][jabatan]" value="Bendahara">
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][kategori]" value="{{ $cat }}">
                        @if($ben) <input type="hidden" name="pengurus[{{ $pKey }}_ben][id]" value="{{ $ben->id }}"> @endif
                        <div class="space-y-2 mt-1">
                            <input type="text" name="pengurus[{{ $pKey }}_ben][kader_nama]" value="{{ $ben?->kader->nama_lengkap }}" list="kaderList" class="input-field" placeholder="Nama Bendahara...">
                            <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                                <div><input type="text" name="pengurus[{{ $pKey }}_ben][phone]" value="{{ $ben?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP..."></div>
                                <div><input type="date" name="pengurus[{{ $pKey }}_ben][dob]" value="{{ $ben?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Tgl Lahir"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- DEPARTMENTS (IPPNU) -->
            @foreach($departemens->whereIn('kategori', ['IPPNU', 'Joint']) as $dept)
                @include('dashboard.sekretariat.pengurus.partials.dept-card', ['dept' => $dept, 'cat' => 'IPPNU', 'pengurus' => $pengurus, 'kaders' => $kaders])
            @endforeach

            <!-- BUTTONS IPPNU (Static) -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-white/10">
                <button type="button" onclick="history.back()" class="text-slate-500 font-bold px-4 py-2 hover:bg-slate-50 rounded-lg">
                    Batal
                </button>
                <button type="submit" class="bg-amber-500 text-white px-8 py-2.5 rounded-full shadow-lg font-bold flex items-center gap-2 hover:bg-amber-600 transition-all hover:scale-105">
                    <span class="material-symbols-outlined">save</span> Simpan Data IPPNU
                </button>
            </div>
        </form>

        <!-- DATALIST -->
        <datalist id="kaderList">
            @foreach($kaders as $k)
                <option value="{{ $k->nama_lengkap }}">
            @endforeach
        </datalist>
    </div>

    <!-- Styles -->
    <style>
        .badge-role {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        .input-field {
            width: 100%;
            background-color: #f8fafc; /* slate-50 */
            border: 1px solid #e2e8f0; /* slate-200 */
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .dark .input-field {
            background-color: #1e293b; /* slate-800 */
            border-color: #334155; /* slate-700 */
            color: white;
        }
        .input-field:focus {
            outline: none;
            border-color: #10b981; /* emerald-500 */
            ring: 2px solid #10b981;
        }
        [x-cloak] { display: none !important; }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
             Alpine.data('pengurusForm', () => ({
                init() { console.log('Form Init'); }
            }))
        })
    </script>
@endsection
