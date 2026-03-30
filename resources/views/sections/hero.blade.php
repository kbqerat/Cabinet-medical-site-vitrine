<section class="relative lg:min-h-screen flex items-center overflow-hidden bg-[#f8faff] pt-16 lg:pt-[70px] pb-10 lg:pb-0">

    {{-- Fond décoratif --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[700px] h-[700px] bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 rounded-full opacity-60 blur-3xl"></div>
        <div class="absolute bottom-0 -left-32 w-[500px] h-[500px] bg-gradient-to-tr from-cyan-100 to-blue-50 rounded-full opacity-50 blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.025]"
             style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(to right, #3b82f6 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="absolute top-24 left-1/4 w-2 h-2 bg-blue-400 rounded-full opacity-40 hidden sm:block"></div>
        <div class="absolute bottom-32 right-1/4 w-2 h-2 bg-blue-300 rounded-full opacity-40 hidden sm:block"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 py-8 lg:py-16 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 xl:gap-24 items-center w-full">

            {{-- ── COLONNE GAUCHE ── --}}
            <div class="space-y-5 lg:space-y-8">

                {{-- Badge animé --}}
                <div class="inline-flex items-center gap-2.5 bg-white border border-blue-100 text-blue-700 text-xs sm:text-sm font-medium px-3.5 py-1.5 rounded-full shadow-sm shadow-blue-100/50">
                    <span class="relative flex h-2 w-2 sm:h-2.5 sm:w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 sm:h-2.5 sm:w-2.5 bg-blue-500"></span>
                    </span>
                    Logiciel de cabinet médical
                </div>

                {{-- Titre --}}
                <h1 class="text-[2.1rem] sm:text-5xl xl:text-6xl font-extrabold text-gray-900 leading-[1.15] tracking-tight">
                    Gérez votre cabinet<br>
                    <span class="relative inline-block mt-1">
                        <span class="relative z-10 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            sans effort.
                        </span>
                        <svg class="absolute -bottom-1.5 left-0 w-full" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M2 8.5C60 3.5 150 1 298 9" stroke="url(#underline-grad)" stroke-width="3.5" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="underline-grad" x1="0" y1="0" x2="298" y2="0" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3b82f6"/>
                                    <stop offset="1" stop-color="#6366f1"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                </h1>

                {{-- Description --}}
                <p class="text-base sm:text-lg text-gray-500 leading-relaxed max-w-lg">
                    MediAssist centralise <strong class="text-gray-700 font-semibold">patients, rendez-vous, ordonnances</strong> et analyses dans une seule interface moderne — conçue pour les médecins marocains.
                </p>

                {{-- CTAs --}}
                <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 sm:gap-4">
                    <a href="#pricing" data-scroll
                       class="relative inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-2xl font-semibold text-sm sm:text-base shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-[1.02] active:scale-100 transition-all duration-300 overflow-hidden group">
                        <span class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        <span class="relative z-10 flex items-center gap-2">
                            Démarrer gratuitement
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                    </a>
                    <a href="#features" data-scroll
                       class="inline-flex items-center justify-center sm:justify-start gap-2 text-gray-600 hover:text-blue-600 font-medium text-sm sm:text-base transition-colors duration-200 group">
                        Voir les fonctionnalités
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                {{-- Preuves sociales --}}
                <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            @foreach(['bg-blue-500', 'bg-indigo-500', 'bg-purple-500', 'bg-cyan-500'] as $color)
                            <div class="w-7 h-7 sm:w-8 sm:h-8 {{ $color }} rounded-full border-2 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-xs sm:text-sm">
                            <span class="font-bold text-gray-900">500+</span>
                            <span class="text-gray-500"> médecins</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="flex gap-0.5">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-gray-900">4.9</span>
                        <span class="text-xs sm:text-sm text-gray-500">/ 5</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs sm:text-sm">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="text-gray-500">Conforme <span class="font-semibold text-gray-700">RGPD</span></span>
                    </div>
                </div>

            </div>

            {{-- ── COLONNE DROITE — Dashboard mockup ── --}}
            <div class="relative mt-2 lg:mt-0 lg:flex lg:justify-end">

                {{-- Badges flottants — masqués sur très petit écran --}}
                <div class="absolute -top-4 -left-2 sm:-left-4 lg:-left-8 z-20 bg-white rounded-2xl shadow-xl shadow-gray-200/60 px-3 py-2.5 sm:px-4 sm:py-3 flex items-center gap-2.5 border border-gray-100/80 hidden sm:flex">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-800">RDV confirmé</div>
                        <div class="text-[11px] text-gray-400">Hassan Alami · 10h00</div>
                    </div>
                </div>

                <div class="absolute -bottom-4 -right-2 lg:-right-4 z-20 bg-white rounded-2xl shadow-xl shadow-gray-200/60 px-3 py-2.5 sm:px-4 sm:py-3 flex items-center gap-2.5 border border-gray-100/80 hidden sm:flex">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-800">12 patients</div>
                        <div class="text-[11px] text-gray-400">aujourd'hui</div>
                    </div>
                </div>

                {{-- Card principale --}}
                <div class="relative bg-white rounded-2xl sm:rounded-3xl shadow-xl sm:shadow-2xl shadow-blue-100/40 border border-gray-100 overflow-hidden w-full max-w-md mx-auto lg:mx-0">

                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-4 sm:py-5">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <div class="flex items-center gap-2.5 sm:gap-3">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-white font-semibold text-sm">Agenda du jour</div>
                                    <div class="text-blue-200 text-xs">Lundi 30 mars 2026</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                <span class="text-blue-100 text-xs font-medium">En ligne</span>
                            </div>
                        </div>

                        {{-- Stats rapides --}}
                        <div class="grid grid-cols-3 gap-2">
                            @foreach([
                                ['val' => '12', 'label' => 'Patients'],
                                ['val' => '3',  'label' => 'En attente'],
                                ['val' => '9',  'label' => 'Confirmés'],
                            ] as $stat)
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-2 sm:px-3 py-2 sm:py-2.5 text-center">
                                <div class="text-white font-bold text-base sm:text-lg leading-none">{{ $stat['val'] }}</div>
                                <div class="text-blue-200 text-[10px] sm:text-[11px] mt-0.5">{{ $stat['label'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Liste RDV --}}
                    <div class="px-4 sm:px-5 py-3 sm:py-4 space-y-2.5 sm:space-y-3">
                        <div class="flex items-center justify-between mb-0.5">
                            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Prochains rendez-vous</span>
                            <span class="text-xs text-blue-600 font-medium cursor-default">Tout voir</span>
                        </div>

                        @foreach([
                            ['init' => 'H', 'name' => 'Hassan Alami',   'time' => "Aujourd'hui · 10h00", 'color' => 'from-blue-500 to-blue-600',       'dot' => 'bg-green-400',  'badge' => 'bg-green-100 text-green-700',  'label' => 'Confirmé',  'bg' => 'bg-blue-50/60 border-blue-100/60'],
                            ['init' => 'F', 'name' => 'Fatima Benali',  'time' => "Aujourd'hui · 11h30", 'color' => 'from-purple-500 to-pink-500',      'dot' => 'bg-amber-400',  'badge' => 'bg-amber-100 text-amber-700',  'label' => 'En attente','bg' => 'bg-gray-50/80 border-gray-100'],
                            ['init' => 'Y', 'name' => 'Youssef Karimi', 'time' => 'Demain · 09h00',      'color' => 'from-emerald-500 to-teal-500',     'dot' => 'bg-blue-400',   'badge' => 'bg-blue-100 text-blue-700',    'label' => 'Planifié',  'bg' => 'bg-gray-50/80 border-gray-100'],
                        ] as $rdv)
                        <div class="flex items-center gap-3 p-2.5 sm:p-3 rounded-xl sm:rounded-2xl {{ $rdv['bg'] }} border hover:border-opacity-80 transition-colors duration-200">
                            <div class="relative shrink-0">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br {{ $rdv['color'] }} rounded-lg sm:rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-sm">{{ $rdv['init'] }}</div>
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 sm:w-3.5 sm:h-3.5 {{ $rdv['dot'] }} rounded-full border-2 border-white"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs sm:text-sm font-semibold text-gray-800 truncate">{{ $rdv['name'] }}</div>
                                <div class="text-[11px] text-gray-400 flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $rdv['time'] }}
                                </div>
                            </div>
                            <span class="shrink-0 text-[10px] sm:text-[11px] font-semibold {{ $rdv['badge'] }} px-2 py-1 rounded-full">{{ $rdv['label'] }}</span>
                        </div>
                        @endforeach

                        {{-- Barre de progression --}}
                        <div class="pt-0.5">
                            <div class="flex justify-between text-[11px] text-gray-400 mb-1.5">
                                <span>Progression de la journée</span>
                                <span class="font-semibold text-blue-600">75%</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full w-3/4 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</section>
