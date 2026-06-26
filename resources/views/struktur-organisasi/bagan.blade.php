{{-- Partial: bagan struktur lengkap (Ketua → BPH → Departemen → Lembaga) --}}
{{-- Dipakai 2x: desktop (selalu tampil) dan mobile (di dalam toggle "Lihat Bagan Penuh") --}}
{{-- Variabel yang dibutuhkan: $ketua, $sekretaris, $bendahara, $departemenList, $lembagaList --}}

<div class="mx-auto px-4" style="min-width: 1100px; width: fit-content;">

    {{-- === KETUA === --}}
    <div class="flex flex-col items-center">
        <div class="org-card mx-auto" @click='activePerson = {!! personData($ketua) !!}; modalOpen = true'>
            <img src="{{ personImg($ketua) }}" class="org-photo org-photo-lg" alt="{{ $ketua->kader->nama_lengkap }}">
            <div class="org-name text-[0.8rem]">{{ $ketua->kader->nama_lengkap }}</div>
            <div class="org-role">{{ $ketua->jabatan }}</div>
        </div>

        {{-- Spine down to BPH --}}
        <div class="connector-v h-8"></div>

        {{-- === SEKRETARIS & BENDAHARA ROW === --}}
        <div class="relative flex justify-center items-start gap-24">
            {{-- Horizontal connector between Sek & Ben --}}
            <div class="connector-h absolute top-0" style="left: calc(50% - 140px); width: 280px;"></div>

            {{-- Sekretaris Branch --}}
            @if($sekretaris)
            <div class="flex flex-col items-center pt-6">
                <div class="connector-v h-6 -mt-6"></div>
                <div class="org-card" @click='activePerson = {!! personData($sekretaris) !!}; modalOpen = true'>
                    <img src="{{ personImg($sekretaris) }}" class="org-photo" alt="{{ $sekretaris->kader->nama_lengkap }}">
                    <div class="org-name">{{ \Illuminate\Support\Str::words($sekretaris->kader->nama_lengkap, 2) }}</div>
                    <div class="org-role">Sekretaris</div>
                </div>
                @if($sekretaris->wakilList->count())
                    @foreach($sekretaris->wakilList as $wasek)
                    <div class="connector-v h-3"></div>
                    <div class="org-card-sm org-card org-card-row" @click='activePerson = {!! personData($wasek) !!}; modalOpen = true'>
                        <img src="{{ personImg($wasek) }}" class="org-photo-mini" alt="{{ $wasek->kader->nama_lengkap }}">
                        <div>
                            <div class="org-name">{{ \Illuminate\Support\Str::words($wasek->kader->nama_lengkap, 2) }}</div>
                            <div class="org-role">W. Sekretaris</div>
                            @if($wasek->departemenData)
                            <div class="org-dept">{{ $wasek->departemenData->nama_departemen }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            @endif

            {{-- Bendahara Branch --}}
            @if($bendahara)
            <div class="flex flex-col items-center pt-6">
                <div class="connector-v h-6 -mt-6"></div>
                <div class="org-card" @click='activePerson = {!! personData($bendahara) !!}; modalOpen = true'>
                    <img src="{{ personImg($bendahara) }}" class="org-photo" alt="{{ $bendahara->kader->nama_lengkap }}">
                    <div class="org-name">{{ \Illuminate\Support\Str::words($bendahara->kader->nama_lengkap, 2) }}</div>
                    <div class="org-role">Bendahara</div>
                </div>
                @if($bendahara->wakilList->count())
                    @foreach($bendahara->wakilList as $wabend)
                    <div class="connector-v h-3"></div>
                    <div class="org-card-sm org-card org-card-row" @click='activePerson = {!! personData($wabend) !!}; modalOpen = true'>
                        <img src="{{ personImg($wabend) }}" class="org-photo-mini" alt="{{ $wabend->kader->nama_lengkap }}">
                        <div>
                            <div class="org-name">{{ \Illuminate\Support\Str::words($wabend->kader->nama_lengkap, 2) }}</div>
                            <div class="org-role">W. Bendahara</div>
                            @if($wabend->departemenData)
                            <div class="org-dept">{{ $wabend->departemenData->nama_departemen }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            @endif
        </div>

        {{-- Spine down to Departemen --}}
        <div class="connector-v h-10"></div>

        {{-- === DEPARTEMEN SECTION LABEL === --}}
        <div class="section-label mb-4">Departemen</div>
        <div class="connector-v h-4"></div>

        {{-- === WAKIL KETUA ROW === --}}
        @if($departemenList->count())
        <div class="relative">
            {{-- Horizontal connector spanning all Waket --}}
            @if($departemenList->count() > 1)
            <div class="connector-h absolute top-0" style="left: 70px; right: 70px;"></div>
            @endif

            <div class="flex justify-center gap-3">
                @foreach($departemenList as $waket)
                <div class="flex flex-col items-center pt-5 px-1">
                    {{-- Vertical stub from horizontal line --}}
                    <div class="connector-v h-5 -mt-5"></div>

                    {{-- Waket Card --}}
                    <div class="org-card" @click='activePerson = {!! personData($waket) !!}; modalOpen = true'>
                        <img src="{{ personImg($waket) }}" class="org-photo" alt="{{ $waket->kader->nama_lengkap }}">
                        <div class="org-name">{{ \Illuminate\Support\Str::words($waket->kader->nama_lengkap, 2) }}</div>
                        <div class="org-role">Wakil Ketua</div>
                        @if($waket->departemenData)
                        <div class="org-dept">{{ $waket->departemenData->nama_departemen }}</div>
                        @endif
                    </div>

                    {{-- Koordinator --}}
                    @if($waket->koordinator)
                    <div class="connector-v h-4"></div>
                    <div class="org-card-sm org-card org-card-row" @click='activePerson = {!! personData($waket->koordinator) !!}; modalOpen = true'>
                        <img src="{{ personImg($waket->koordinator) }}" class="org-photo-mini" alt="{{ $waket->koordinator->kader->nama_lengkap }}">
                        <div>
                            <div class="org-name">{{ \Illuminate\Support\Str::words($waket->koordinator->kader->nama_lengkap, 2) }}</div>
                            <div class="org-role">Koordinator</div>
                        </div>
                    </div>

                        {{-- Anggota under Koordinator --}}
                        @if($waket->koordinator->anggotaList->count())
                            @foreach($waket->koordinator->anggotaList as $anggota)
                            <div class="connector-v h-3"></div>
                            <div class="org-card-xs org-card org-card-row" @click='activePerson = {!! personData($anggota) !!}; modalOpen = true'>
                                <img src="{{ personImg($anggota) }}" class="org-photo-mini-xs" alt="{{ $anggota->kader->nama_lengkap }}">
                                <div>
                                    <div class="org-name">{{ \Illuminate\Support\Str::words($anggota->kader->nama_lengkap, 2) }}</div>
                                    <div class="org-role">Anggota</div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    @endif

                    {{-- Anggota directly under Waket (no Koordinator) --}}
                    @if($waket->anggotaLangsung->count())
                        @foreach($waket->anggotaLangsung as $anggota)
                        <div class="connector-v h-3"></div>
                        <div class="org-card-xs org-card org-card-row" @click='activePerson = {!! personData($anggota) !!}; modalOpen = true'>
                            <img src="{{ personImg($anggota) }}" class="org-photo-mini-xs" alt="{{ $anggota->kader->nama_lengkap }}">
                            <div>
                                <div class="org-name">{{ \Illuminate\Support\Str::words($anggota->kader->nama_lengkap, 2) }}</div>
                                <div class="org-role">Anggota</div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Spine down to Lembaga --}}
        @if($lembagaList->count())
        <div class="connector-v h-10"></div>

        {{-- === LEMBAGA SECTION LABEL === --}}
        <div class="section-label mb-4">Lembaga & Badan</div>
        <div class="connector-v h-4"></div>

        {{-- === LEMBAGA ROW === --}}
        <div class="relative">
            @if($lembagaList->count() > 1)
            <div class="connector-h absolute top-0" style="left: 70px; right: 70px;"></div>
            @endif

            <div class="flex justify-center gap-4">
                @foreach($lembagaList as $head)
                <div class="flex flex-col items-center pt-5 px-1">
                    <div class="connector-v h-5 -mt-5"></div>

                    {{-- Lembaga Head Card --}}
                    <div class="org-card org-card-lembaga" @click='activePerson = {!! personData($head) !!}; modalOpen = true'>
                        <img src="{{ personImg($head) }}" class="org-photo" alt="{{ $head->kader->nama_lengkap }}">
                        <div class="org-name">{{ \Illuminate\Support\Str::words($head->kader->nama_lengkap, 2) }}</div>
                        <div class="org-role">{{ $head->jabatan }}</div>
                        @if($head->departemenData)
                        <div class="org-dept">{{ $head->departemenData->nama_departemen }}</div>
                        @endif
                    </div>

                    {{-- Lembaga Anggota --}}
                    @if($head->anggotaList->count())
                        @foreach($head->anggotaList as $anggota)
                        <div class="connector-v h-3"></div>
                        <div class="org-card-xs org-card org-card-row" @click='activePerson = {!! personData($anggota) !!}; modalOpen = true'>
                            <img src="{{ personImg($anggota) }}" class="org-photo-mini-xs" alt="{{ $anggota->kader->nama_lengkap }}">
                            <div>
                                <div class="org-name">{{ \Illuminate\Support\Str::words($anggota->kader->nama_lengkap, 2) }}</div>
                                <div class="org-role">Anggota</div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>{{-- end flex-col items-center (main spine) --}}
</div>
