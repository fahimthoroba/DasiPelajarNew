@php
    // Shared Department Card Component
    // Props: $dept, $cat (IPNU/IPPNU), $pengurus, $kaders
    
    // 1. Determine Titles & Roles FIRST
    $isLembaga = strtolower($dept->Status ?? $dept->status ?? '') === 'lembaga';
    
    if ($isLembaga) {
        $isCommander = in_array($dept->nama_departemen, ['CBP', 'KPP']);
        $headTitle = $isCommander ? 'Komandan' : 'Direktur';
        $headValue = $headTitle;
    } else {
        $headTitle = 'Wakil Ketua (Membawahi)';
        $headValue = 'Wakil Ketua';
    }

    // 2. Filter officers for this specific dept AND this specific category
    // Use dynamic $headValue to find the head (Wakil Ketua / Direktur / Komandan)
    $waket = $pengurus->first(fn($p) => $p->jabatan === $headValue && $p->departemen_id == $dept->id && $p->kategori === $cat); 
    $wasek = $pengurus->first(fn($p) => $p->jabatan === 'Wakil Sekretaris' && $p->departemen_id == $dept->id && $p->kategori === $cat);
    $waben = $pengurus->first(fn($p) => $p->jabatan === 'Wakil Bendahara' && $p->departemen_id == $dept->id && $p->kategori === $cat);
    $koord = $pengurus->first(fn($p) => $p->jabatan === 'Koordinator' && $p->departemen_id == $dept->id && $p->kategori === $cat);
    
    $anggota = $pengurus->filter(fn($p) => $p->jabatan === 'Anggota' && $p->departemen_id == $dept->id && $p->kategori === $cat);
    $deptKey = 'dept_' . $dept->id . '_' . $cat; // Unique Key per Dept/Cat combo
@endphp

<div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm space-y-6">
     
    <h3 class="text-lg font-bold text-slate-800 dark:text-white border-b pb-2 flex items-center gap-2">
        <span class="material-symbols-outlined text-slate-400">grid_view</span>
        {{ $dept->nama_departemen }}
        @if(isset($dept->kategori) && $dept->kategori == 'Joint') <span class="text-xs bg-slate-100 px-2 py-0.5 rounded text-slate-500">Joint</span> @endif
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- HEAD -->
        <div>
            <label class="badge-role bg-purple-100 text-purple-800">{{ $headTitle }}</label>
            <input type="hidden" name="pengurus[{{ $deptKey }}_waket][jabatan]" value="{{ $headValue }}">
            <input type="hidden" name="pengurus[{{ $deptKey }}_waket][departemen_id]" value="{{ $dept->id }}">
            <input type="hidden" name="pengurus[{{ $deptKey }}_waket][kategori]" value="{{ $cat }}">
            
            @if($waket) <input type="hidden" name="pengurus[{{ $deptKey }}_waket][id]" value="{{ $waket->id }}"> @endif
            <div class="space-y-2 mt-1">
                <input type="text" name="pengurus[{{ $deptKey }}_waket][kader_nama]" 
                       value="{{ $waket?->kader->nama_lengkap }}" 
                       list="kaderList" 
                       class="input-field" placeholder="Ketik nama...">
                <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                    <div><input type="text" name="pengurus[{{ $deptKey }}_waket][phone]" value="{{ $waket?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP/User..."></div>
                    <div><input type="date" name="pengurus[{{ $deptKey }}_waket][dob]" value="{{ $waket?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Pass (Tgl Lahir)"></div>
                </div>
            </div>
        </div>
        
        @if(!$isLembaga)
             <!-- KOORDINATOR -->
            <div>
                <label class="badge-role bg-indigo-100 text-indigo-800">Koordinator Dept</label>
                <input type="hidden" name="pengurus[{{ $deptKey }}_koord][jabatan]" value="Koordinator">
                <input type="hidden" name="pengurus[{{ $deptKey }}_koord][departemen_id]" value="{{ $dept->id }}">
                <input type="hidden" name="pengurus[{{ $deptKey }}_koord][kategori]" value="{{ $cat }}">
                 @if($koord) <input type="hidden" name="pengurus[{{ $deptKey }}_koord][id]" value="{{ $koord->id }}"> @endif
                <div class="space-y-2 mt-1">
                    <input type="text" name="pengurus[{{ $deptKey }}_koord][kader_nama]" 
                           value="{{ $koord?->kader->nama_lengkap }}" 
                           list="kaderList" 
                           class="input-field" placeholder="Ketik nama...">
                    <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                        <div><input type="text" name="pengurus[{{ $deptKey }}_koord][phone]" value="{{ $koord?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP/User..."></div>
                        <div><input type="date" name="pengurus[{{ $deptKey }}_koord][dob]" value="{{ $koord?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Pass (Tgl Lahir)"></div>
                    </div>
                </div>
            </div>

             <!-- WAKIL SEKRETARIS -->
            <div>
                <label class="badge-role bg-slate-100 text-slate-800">Wakil Sekretaris (Dept)</label>
                 <input type="hidden" name="pengurus[{{ $deptKey }}_wasek][jabatan]" value="Wakil Sekretaris">
                <input type="hidden" name="pengurus[{{ $deptKey }}_wasek][departemen_id]" value="{{ $dept->id }}">
                <input type="hidden" name="pengurus[{{ $deptKey }}_wasek][kategori]" value="{{ $cat }}">
                 @if($wasek) <input type="hidden" name="pengurus[{{ $deptKey }}_wasek][id]" value="{{ $wasek->id }}"> @endif
                <div class="space-y-2 mt-1">
                    <input type="text" name="pengurus[{{ $deptKey }}_wasek][kader_nama]" 
                           value="{{ $wasek?->kader->nama_lengkap }}" 
                           list="kaderList" 
                           class="input-field" placeholder="Ketik nama...">
                    <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                        <div><input type="text" name="pengurus[{{ $deptKey }}_wasek][phone]" value="{{ $wasek?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP/User..."></div>
                        <div><input type="date" name="pengurus[{{ $deptKey }}_wasek][dob]" value="{{ $wasek?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Pass (Tgl Lahir)"></div>
                    </div>
                </div>
            </div>

            <!-- WAKIL BENDAHARA -->
            <div>
                <label class="badge-role bg-slate-100 text-slate-800">Wakil Bendahara (Dept)</label>
                 <input type="hidden" name="pengurus[{{ $deptKey }}_waben][jabatan]" value="Wakil Bendahara">
                <input type="hidden" name="pengurus[{{ $deptKey }}_waben][departemen_id]" value="{{ $dept->id }}">
                <input type="hidden" name="pengurus[{{ $deptKey }}_waben][kategori]" value="{{ $cat }}">
                 @if($waben) <input type="hidden" name="pengurus[{{ $deptKey }}_waben][id]" value="{{ $waben->id }}"> @endif
                <div class="space-y-2 mt-1">
                    <input type="text" name="pengurus[{{ $deptKey }}_waben][kader_nama]" 
                           value="{{ $waben?->kader->nama_lengkap }}" 
                           list="kaderList" 
                           class="input-field" placeholder="Ketik nama...">
                    <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                        <div><input type="text" name="pengurus[{{ $deptKey }}_waben][phone]" value="{{ $waben?->kader->no_hp }}" class="input-field text-xs !py-1" placeholder="No HP/User..."></div>
                        <div><input type="date" name="pengurus[{{ $deptKey }}_waben][dob]" value="{{ $waben?->kader->tanggal_lahir }}" class="input-field text-xs !py-1" title="Pass (Tgl Lahir)"></div>
                    </div>
                </div>
            </div>
        @else
             <!-- LEMBAGA MESSAGE -->
             <!-- <div>
                <div class="p-4 bg-slate-50 rounded-lg text-sm text-slate-500">
                    Lembaga hanya memiliki Komandan/Direktur dan Anggota/Divisi. <br>
                    Silahkan input anggota dibagian bawah.
                </div>
             </div> -->
        @endif
    </div>

    <!-- ANGGOTA DYNAMIC SECTION -->
    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-white/5" 
         x-data="{ members: {{ $anggota->map(fn($a) => ['id' => $a->id, 'nama' => $a->kader->nama_lengkap, 'phone' => $a->kader->no_hp, 'dob' => $a->kader->tanggal_lahir])->values()->toJson() }} }">
        <label class="badge-role bg-slate-50 text-slate-600 mb-2 block">Anggota / Divisi</label>
        
        <template x-for="(member, index) in members" :key="index">
            <div class="flex items-start gap-2 mb-3">
                <div class="flex-1 space-y-2">
                    <input type="hidden" :name="'pengurus[{{ $deptKey }}_anggota]['+index+'][jabatan]'" value="Anggota">
                    <input type="hidden" :name="'pengurus[{{ $deptKey }}_anggota]['+index+'][departemen_id]'" value="{{ $dept->id }}">
                    <input type="hidden" :name="'pengurus[{{ $deptKey }}_anggota]['+index+'][kategori]'" value="{{ $cat }}">
                    <input type="hidden" :name="'pengurus[{{ $deptKey }}_anggota]['+index+'][id]'" :value="member.id">
                    
                    <input type="text" :name="'pengurus[{{ $deptKey }}_anggota]['+index+'][kader_nama]'" 
                           class="input-field w-full" 
                           x-model="member.nama" 
                           list="kaderList" placeholder="Nama Anggota...">
                    
                    <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800 p-2 rounded-lg border border-slate-100 dark:border-slate-700">
                        <div>
                            <input type="text" :name="'pengurus[{{ $deptKey }}_anggota]['+index+'][phone]'" 
                                   class="input-field text-xs !py-1 w-full" 
                                   x-model="member.phone" 
                                   placeholder="No HP/Username...">
                        </div>
                        <div>
                            <input type="date" :name="'pengurus[{{ $deptKey }}_anggota]['+index+'][dob]'" 
                                   class="input-field text-xs !py-1 w-full" 
                                   x-model="member.dob" 
                                   title="Password (Tgl Lahir)">
                        </div>
                    </div>
                </div>
                       
                <button type="button" @click="members.splice(index, 1)" class="p-2 text-red-500 hover:bg-red-50 rounded mt-1">
                    <span class="material-symbols-outlined">remove_circle</span>
                </button>
            </div>
        </template>

        <button type="button" @click="members.push({id: null, nama: '', phone: '', dob: ''})" 
                class="text-sm {{ $cat === 'IPNU' ? 'text-emerald-600' : 'text-amber-600' }} font-bold flex items-center gap-1 mt-2 hover:underline">
            <span class="material-symbols-outlined text-lg">add_circle</span> Tambah Anggota
        </button>
    </div>
</div>
