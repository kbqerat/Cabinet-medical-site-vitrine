<section id="screenshots" class="py-24 bg-[#f8faff] overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                <div class="w-6 h-px bg-blue-400"></div>
                Aperçu
                <div class="w-6 h-px bg-blue-400"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                Une interface
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">moderne & intuitive</span>
            </h2>
            <p class="text-gray-400 text-sm max-w-md mx-auto">Conçue pour les médecins — simple à prendre en main dès le premier jour, sans formation.</p>
        </div>

        {{-- Tabs --}}
        <div x-data="{ tab: 0 }" class="flex flex-col items-center gap-8">

            {{-- Tab buttons --}}
            <div class="flex items-center gap-2 bg-white border border-gray-100 rounded-2xl p-1.5 shadow-sm">
                @foreach([
                    ['label' => 'Dashboard',    'icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z'],
                    ['label' => 'Patients',     'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Agenda',       'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ] as $i => $t)
                <button @click="tab = {{ $i }}"
                        :class="tab === {{ $i }} ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $t['icon'] }}"/>
                    </svg>
                    {{ $t['label'] }}
                </button>
                @endforeach
            </div>

            {{-- Mockup container --}}
            <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl shadow-blue-100/30 border border-gray-100 overflow-hidden">

                {{-- Browser bar --}}
                <div class="bg-gray-50 border-b border-gray-100 px-5 py-3 flex items-center gap-3">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <div class="flex-1 bg-white border border-gray-200 rounded-lg px-3 py-1 flex items-center gap-2 max-w-xs mx-auto">
                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span class="text-[11px] text-gray-400">app.mediassist.ma/dashboard</span>
                    </div>
                </div>

                {{-- App shell --}}
                <div class="flex h-[420px] sm:h-[480px]">

                    {{-- Sidebar --}}
                    <div class="hidden sm:flex w-14 lg:w-52 bg-[#0f1729] flex-col shrink-0">
                        {{-- Logo --}}
                        <div class="px-3 lg:px-4 py-4 flex items-center gap-2.5 border-b border-white/5">
                            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <span class="text-white text-xs font-bold hidden lg:block">MediAssist</span>
                        </div>
                        {{-- Nav items --}}
                        <nav class="flex-1 px-2 py-3 space-y-0.5">
                            @foreach([
                                ['icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z', 'label' => 'Dashboard', 'active' => 0],
                                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Patients',  'active' => 1],
                                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Agenda',    'active' => 2],
                                ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Ordonnances','active' => -1],
                                ['icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'label' => 'Facturation','active' => -1],
                            ] as $nav)
                            <div :class="{{ $nav['active'] }} === tab ? 'bg-white/10 text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5'"
                                 class="flex items-center gap-2.5 px-2.5 py-2 rounded-xl cursor-default transition-colors duration-150">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $nav['icon'] }}"/>
                                </svg>
                                <span class="text-xs font-medium hidden lg:block">{{ $nav['label'] }}</span>
                            </div>
                            @endforeach
                        </nav>
                        {{-- User --}}
                        <div class="px-2 py-3 border-t border-white/5">
                            <div class="flex items-center gap-2 px-2">
                                <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-[10px] font-bold shrink-0">DR</div>
                                <div class="hidden lg:block">
                                    <div class="text-[11px] font-semibold text-white leading-none">Dr. Alaoui</div>
                                    <div class="text-[10px] text-gray-500 mt-0.5">Médecin généraliste</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 overflow-hidden bg-[#f8faff]">

                        {{-- ── DASHBOARD ── --}}
                        <div x-show="tab === 0" class="h-full p-4 lg:p-5 overflow-auto">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-sm font-bold text-gray-800">Bonjour, Dr. Alaoui 👋</h3>
                                    <p class="text-xs text-gray-400">Lundi 30 mars 2026</p>
                                </div>
                                <div class="flex items-center gap-1.5 bg-green-100 text-green-700 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                    En ligne
                                </div>
                            </div>
                            {{-- Stats --}}
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                                @foreach([
                                    ['val' => '12',   'label' => 'RDV aujourd\'hui', 'color' => 'text-blue-600',    'bg' => 'bg-blue-50'],
                                    ['val' => '3',    'label' => 'En attente',        'color' => 'text-amber-600',   'bg' => 'bg-amber-50'],
                                    ['val' => '248',  'label' => 'Patients total',    'color' => 'text-indigo-600',  'bg' => 'bg-indigo-50'],
                                    ['val' => '94%',  'label' => 'Taux de présence',  'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50'],
                                ] as $s)
                                <div class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm">
                                    <div class="text-lg font-extrabold {{ $s['color'] }}">{{ $s['val'] }}</div>
                                    <div class="text-[11px] text-gray-400 mt-0.5">{{ $s['label'] }}</div>
                                </div>
                                @endforeach
                            </div>
                            {{-- RDV du jour --}}
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-2.5 border-b border-gray-50">
                                    <span class="text-xs font-bold text-gray-700">Prochains rendez-vous</span>
                                    <span class="text-[11px] text-blue-500 font-medium">Voir tout</span>
                                </div>
                                @foreach([
                                    ['init' => 'H', 'name' => 'Hassan Alami',   'time' => '10h00', 'color' => 'from-blue-500 to-blue-600',    'badge' => 'bg-green-100 text-green-700',  'status' => 'Confirmé'],
                                    ['init' => 'F', 'name' => 'Fatima Benali',  'time' => '11h30', 'color' => 'from-purple-500 to-pink-500',   'badge' => 'bg-amber-100 text-amber-700',  'status' => 'En attente'],
                                    ['init' => 'Y', 'name' => 'Youssef Karimi', 'time' => '14h00', 'color' => 'from-emerald-500 to-teal-500', 'badge' => 'bg-blue-100 text-blue-700',    'status' => 'Confirmé'],
                                ] as $rdv)
                                <div class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50/60 border-b border-gray-50 last:border-0 transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-br {{ $rdv['color'] }} rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0">{{ $rdv['init'] }}</div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs font-semibold text-gray-800 truncate">{{ $rdv['name'] }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $rdv['time'] }}</div>
                                    </div>
                                    <span class="text-[10px] font-semibold {{ $rdv['badge'] }} px-2 py-0.5 rounded-full shrink-0">{{ $rdv['status'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ── PATIENTS ── --}}
                        <div x-show="tab === 1" class="h-full p-4 lg:p-5 overflow-auto">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-bold text-gray-800">Patients <span class="text-gray-400 font-normal">(248)</span></h3>
                                <button class="flex items-center gap-1.5 bg-blue-600 text-white text-[11px] font-semibold px-3 py-1.5 rounded-lg">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    Nouveau
                                </button>
                            </div>
                            {{-- Search --}}
                            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-3 py-2 mb-3">
                                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span class="text-[11px] text-gray-300">Rechercher un patient...</span>
                            </div>
                            {{-- Table --}}
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                <div class="grid grid-cols-3 px-4 py-2 bg-gray-50/80 border-b border-gray-100">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Patient</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 hidden sm:block">Dernier RDV</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 text-right">Statut</span>
                                </div>
                                @foreach([
                                    ['init' => 'H', 'name' => 'Hassan Alami',    'age' => '34 ans', 'rdv' => '30 mars 2026',  'color' => 'from-blue-500 to-blue-600',    'badge' => 'bg-green-100 text-green-700',  'status' => 'Actif'],
                                    ['init' => 'F', 'name' => 'Fatima Benali',   'age' => '28 ans', 'rdv' => '29 mars 2026',  'color' => 'from-purple-500 to-pink-500',   'badge' => 'bg-green-100 text-green-700',  'status' => 'Actif'],
                                    ['init' => 'Y', 'name' => 'Youssef Karimi',  'age' => '45 ans', 'rdv' => '28 mars 2026',  'color' => 'from-emerald-500 to-teal-500', 'badge' => 'bg-green-100 text-green-700',  'status' => 'Actif'],
                                    ['init' => 'S', 'name' => 'Sara El Idrissi', 'age' => '52 ans', 'rdv' => '15 mars 2026',  'color' => 'from-rose-500 to-pink-500',    'badge' => 'bg-gray-100 text-gray-500',    'status' => 'Inactif'],
                                    ['init' => 'M', 'name' => 'Mohamed Tahiri',  'age' => '61 ans', 'rdv' => '10 mars 2026',  'color' => 'from-amber-500 to-orange-500', 'badge' => 'bg-green-100 text-green-700',  'status' => 'Actif'],
                                ] as $p)
                                <div class="grid grid-cols-3 items-center px-4 py-2.5 border-b border-gray-50 last:border-0 hover:bg-gray-50/40 transition-colors cursor-default">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="w-7 h-7 bg-gradient-to-br {{ $p['color'] }} rounded-lg flex items-center justify-center text-white text-[10px] font-bold shrink-0">{{ $p['init'] }}</div>
                                        <div class="min-w-0">
                                            <div class="text-xs font-semibold text-gray-800 truncate">{{ $p['name'] }}</div>
                                            <div class="text-[10px] text-gray-400">{{ $p['age'] }}</div>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-gray-400 hidden sm:block">{{ $p['rdv'] }}</span>
                                    <div class="flex justify-end">
                                        <span class="text-[10px] font-semibold {{ $p['badge'] }} px-2 py-0.5 rounded-full">{{ $p['status'] }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ── AGENDA ── --}}
                        <div x-show="tab === 2" class="h-full p-4 lg:p-5 overflow-auto">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-bold text-gray-800">Agenda — Mars 2026</h3>
                                <div class="flex items-center gap-1">
                                    <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center hover:bg-gray-50">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center hover:bg-gray-50">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                </div>
                            </div>
                            {{-- Jours de la semaine --}}
                            <div class="grid grid-cols-6 gap-1.5 mb-3">
                                @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'] as $d)
                                <div class="text-center text-[10px] font-bold text-gray-400 uppercase">{{ $d }}</div>
                                @endforeach
                            </div>
                            {{-- Créneaux --}}
                            <div class="grid grid-cols-6 gap-1.5">
                                @php
                                $slots = [
                                    [['H','blue'], null, ['F','purple'], null, ['Y','emerald'], null],
                                    [null, ['S','rose'], null, ['M','amber'], null, ['K','indigo']],
                                    [['A','cyan'], null, null, ['N','blue'], null, null],
                                    [null, ['R','violet'], ['T','emerald'], null, ['B','rose'], null],
                                ];
                                $days = [25,26,27,28,29,30];
                                @endphp
                                @foreach($days as $j => $day)
                                <div class="space-y-1">
                                    <div class="text-center text-[11px] font-bold {{ $day === 30 ? 'text-blue-600 bg-blue-100 rounded-lg py-0.5' : 'text-gray-500' }}">{{ $day }}</div>
                                    @foreach($slots as $row)
                                    @if($row[$j])
                                    <div class="bg-gradient-to-br
                                        @if($row[$j][1] === 'blue') from-blue-400 to-blue-500
                                        @elseif($row[$j][1] === 'purple') from-purple-400 to-purple-500
                                        @elseif($row[$j][1] === 'emerald') from-emerald-400 to-teal-500
                                        @elseif($row[$j][1] === 'rose') from-rose-400 to-pink-500
                                        @elseif($row[$j][1] === 'amber') from-amber-400 to-orange-500
                                        @elseif($row[$j][1] === 'indigo') from-indigo-400 to-violet-500
                                        @elseif($row[$j][1] === 'cyan') from-cyan-400 to-blue-400
                                        @elseif($row[$j][1] === 'violet') from-violet-400 to-purple-500
                                        @endif
                                        rounded-lg h-7 flex items-center justify-center text-white text-[10px] font-bold shadow-sm">
                                        {{ $row[$j][0] }}
                                    </div>
                                    @else
                                    <div class="rounded-lg h-7 border border-dashed border-gray-200 bg-white/60"></div>
                                    @endif
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Légende --}}
            <div class="flex flex-wrap items-center justify-center gap-6 text-xs text-gray-400">
                @foreach(['Interface 100% en français', 'Accès mobile & desktop', 'Données chiffrées & sécurisées'] as $item)
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $item }}
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
