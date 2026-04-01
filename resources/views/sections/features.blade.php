<section id="features" class="py-24 bg-[#f8faff]">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                <div class="w-6 h-px bg-blue-400"></div>
                Fonctionnalités
                <div class="w-6 h-px bg-blue-400"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">
                Tout ce dont votre cabinet<br class="hidden sm:block">
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">a besoin, réuni.</span>
            </h2>
        </div>

        @php
        $features = [
            ['title' => 'Gestion des patients',  'desc' => 'Fiches complètes, historique médical et antécédents centralisés.',          'color' => 'from-blue-500 to-blue-600',    'light' => 'bg-blue-50',    'dot' => 'bg-blue-500',    'text' => 'text-blue-600',    'ring' => 'ring-blue-200',    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'stat' => '2 400+ patients'],
            ['title' => 'Agenda & Rendez-vous',   'desc' => 'Calendrier intelligent avec rappels SMS et gestion des annulations.',        'color' => 'from-indigo-500 to-violet-600', 'light' => 'bg-indigo-50',  'dot' => 'bg-indigo-500',  'text' => 'text-indigo-600',  'ring' => 'ring-indigo-200',  'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',                                                                                                                                                                                                                                                         'stat' => '0 conflit'],
            ['title' => 'Ordonnances PDF',         'desc' => 'Générez et imprimez des ordonnances conformes en moins de 30 secondes.',    'color' => 'from-cyan-500 to-blue-500',    'light' => 'bg-cyan-50',    'dot' => 'bg-cyan-500',    'text' => 'text-cyan-600',    'ring' => 'ring-cyan-200',    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',                                                                                                                                                                                                                        'stat' => '< 30 sec'],
            ['title' => 'Analyses médicales',      'desc' => 'Suivi des analyses biologiques et résultats par patient en temps réel.',    'color' => 'from-emerald-500 to-teal-500', 'light' => 'bg-emerald-50', 'dot' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-200', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'stat' => '100% traçabilité'],
            ['title' => 'Comptes rendus',           'desc' => 'Rédigez et archivez vos consultations avec modèles personnalisables.',      'color' => 'from-amber-500 to-orange-500', 'light' => 'bg-amber-50',   'dot' => 'bg-amber-500',   'text' => 'text-amber-600',   'ring' => 'ring-amber-200',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',                                                                                                                                                                             'stat' => '50+ modèles'],
            ['title' => 'Facturation',              'desc' => 'Factures automatiques, suivi paiements et export comptable intégré.',       'color' => 'from-rose-500 to-pink-500',    'light' => 'bg-rose-50',    'dot' => 'bg-rose-500',    'text' => 'text-rose-600',    'ring' => 'ring-rose-200',    'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',                                                                                                                                                                                           'stat' => '0 impayé oublié'],
        ];
        @endphp

        {{-- Slider --}}
        <div x-data="{
                page: 0,
                perPage: 3,
                total: 6,
                get maxPage() { return this.total - this.perPage },
                next() { if (this.page < this.maxPage) this.page++ },
                prev() { if (this.page > 0) this.page-- },
                autoplay: null,
                startAuto() {
                    this.autoplay = setInterval(() => {
                        this.page < this.maxPage ? this.page++ : this.page = 0;
                    }, 3500)
                },
                stopAuto() { clearInterval(this.autoplay) }
             }"
             x-init="
                perPage = window.innerWidth < 640 ? 1 : window.innerWidth < 1024 ? 2 : 3;
                window.addEventListener('resize', () => {
                    perPage = window.innerWidth < 640 ? 1 : window.innerWidth < 1024 ? 2 : 3;
                    if (page > total - perPage) page = total - perPage;
                });
                startAuto();
             "
             @mouseenter="stopAuto()"
             @mouseleave="startAuto()">

            {{-- Cards grid --}}
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] gap-4"
                     :style="`transform: translateX(calc(-${page} * (100% / ${perPage} + 16px / ${perPage})))`">

                    @foreach($features as $i => $f)
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex-shrink-0 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-300"
                         :style="`width: calc(100% / ${perPage} - ${(perPage - 1) * 16 / perPage}px)`">

                        {{-- Icon + index --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $f['color'] }} flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $f['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="text-[11px] font-bold tracking-widest text-gray-200">0{{ $i + 1 }}</span>
                        </div>

                        {{-- Text --}}
                        <h3 class="text-sm font-bold text-gray-900 mb-1.5">{{ $f['title'] }}</h3>
                        <p class="text-xs text-gray-400 leading-relaxed mb-4">{{ $f['desc'] }}</p>

                        {{-- Stat --}}
                        <div class="{{ $f['light'] }} rounded-xl px-3 py-2 flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full {{ $f['dot'] }} shrink-0"></div>
                            <span class="text-xs font-semibold {{ $f['text'] }}">{{ $f['stat'] }}</span>
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>

            {{-- Contrôles --}}
            <div class="mt-8 flex items-center justify-between">

                {{-- Dots --}}
                <div class="flex items-center gap-1.5">
                    @for($i = 0; $i <= count($features) - 3; $i++)
                    <button @click="page = {{ $i }}"
                            :class="page === {{ $i }} ? 'w-5 bg-blue-600' : 'w-1.5 bg-gray-300 hover:bg-gray-400'"
                            class="h-1.5 rounded-full transition-all duration-300">
                    </button>
                    @endfor
                </div>

                {{-- Flèches --}}
                <div class="flex items-center gap-2">
                    <button @click="prev()"
                            :class="page === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:border-blue-300 hover:bg-blue-50 cursor-pointer'"
                            class="w-9 h-9 rounded-xl border border-gray-200 bg-white flex items-center justify-center transition-all duration-200 group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button @click="next()"
                            :class="page >= maxPage ? 'opacity-30 cursor-not-allowed' : 'hover:border-blue-300 hover:bg-blue-50 cursor-pointer'"
                            class="w-9 h-9 rounded-xl border border-gray-200 bg-white flex items-center justify-center transition-all duration-200 group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

            </div>

        </div>

    </div>
</section>
