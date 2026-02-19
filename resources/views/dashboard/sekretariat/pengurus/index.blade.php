@extends('layouts.dashboard')

@section('title', 'Manajemen Pengurus PC')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6" x-data="{ activeTab: 'IPNU' }">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold font-display text-slate-800 dark:text-white">Formatur Pengurus PC</h1>
                <div class="text-sm text-slate-500">
                    Mode Bulk Editor (Terpisah)
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

            <!-- SK SELECTION (IPNU) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Dasar Surat Keputusan (SK) - IPNU</label>
                <select name="sk_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                    @foreach($sks as $sk)
                        <option value="{{ $sk->id }}" {{ $pengurus->first(fn($p) => $p->kategori === 'IPNU')?->surat_keputusan_id == $sk->id ? 'selected' : '' }}>
                            {{ $sk->nomor_sk }} ({{ $sk->tentang }})
                        </option>
                    @endforeach
                </select>
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
                    <input type="text" name="pengurus[{{ $pKey }}_ketua][kader_nama]" value="{{ $ketua?->kader->nama_lengkap }}" list="kaderList" class="input-field mt-1" placeholder="Nama Ketua...">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="badge-role bg-blue-100 text-blue-800">Sekretaris</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][jabatan]" value="Sekretaris">
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][kategori]" value="{{ $cat }}">
                        @if($sek) <input type="hidden" name="pengurus[{{ $pKey }}_sek][id]" value="{{ $sek->id }}"> @endif
                        <input type="text" name="pengurus[{{ $pKey }}_sek][kader_nama]" value="{{ $sek?->kader->nama_lengkap }}" list="kaderList" class="input-field mt-1" placeholder="Nama Sekretaris...">
                    </div>
                    <div>
                        <label class="badge-role bg-amber-100 text-amber-800">Bendahara</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][jabatan]" value="Bendahara">
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][kategori]" value="{{ $cat }}">
                        @if($ben) <input type="hidden" name="pengurus[{{ $pKey }}_ben][id]" value="{{ $ben->id }}"> @endif
                        <input type="text" name="pengurus[{{ $pKey }}_ben][kader_nama]" value="{{ $ben?->kader->nama_lengkap }}" list="kaderList" class="input-field mt-1" placeholder="Nama Bendahara...">
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

            <!-- SK SELECTION (IPPNU) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Dasar Surat Keputusan (SK) - IPPNU</label>
                <select name="sk_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5">
                    @foreach($sks as $sk)
                        <option value="{{ $sk->id }}" {{ $pengurus->first(fn($p) => $p->kategori === 'IPPNU')?->surat_keputusan_id == $sk->id ? 'selected' : '' }}>
                            {{ $sk->nomor_sk }} ({{ $sk->tentang }})
                        </option>
                    @endforeach
                </select>
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
                    <input type="text" name="pengurus[{{ $pKey }}_ketua][kader_nama]" value="{{ $ketua?->kader->nama_lengkap }}" list="kaderList" class="input-field mt-1" placeholder="Nama Ketua...">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="badge-role bg-blue-100 text-blue-800">Sekretaris</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][jabatan]" value="Sekretaris">
                        <input type="hidden" name="pengurus[{{ $pKey }}_sek][kategori]" value="{{ $cat }}">
                        @if($sek) <input type="hidden" name="pengurus[{{ $pKey }}_sek][id]" value="{{ $sek->id }}"> @endif
                        <input type="text" name="pengurus[{{ $pKey }}_sek][kader_nama]" value="{{ $sek?->kader->nama_lengkap }}" list="kaderList" class="input-field mt-1" placeholder="Nama Sekretaris...">
                    </div>
                    <div>
                        <label class="badge-role bg-amber-100 text-amber-800">Bendahara</label>
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][jabatan]" value="Bendahara">
                        <input type="hidden" name="pengurus[{{ $pKey }}_ben][kategori]" value="{{ $cat }}">
                        @if($ben) <input type="hidden" name="pengurus[{{ $pKey }}_ben][id]" value="{{ $ben->id }}"> @endif
                        <input type="text" name="pengurus[{{ $pKey }}_ben][kader_nama]" value="{{ $ben?->kader->nama_lengkap }}" list="kaderList" class="input-field mt-1" placeholder="Nama Bendahara...">
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
