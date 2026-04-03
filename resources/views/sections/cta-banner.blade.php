<section class="relative py-28 overflow-hidden bg-[#0a0f1e]">

    {{-- Fond --}}
    <div class="absolute inset-0 pointer-events-none">
        {{-- Grille de points --}}
        <div class="absolute inset-0 opacity-[0.04]"
             style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

        {{-- Halos colorés --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-80 h-80 bg-indigo-600/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 right-1/4 -translate-y-1/2 w-72 h-72 bg-violet-600/10 rounded-full blur-3xl"></div>

        {{-- Ligne ECG déco --}}
        <div class="absolute bottom-8 left-0 right-0 opacity-10">
            <svg class="w-full h-8" viewBox="0 0 1200 32" fill="none" preserveAspectRatio="none">
                <path d="M0,16 L300,16 L320,16 L328,4 L336,28 L344,4 L352,22 L360,16 L600,16 L620,16 L628,2 L636,30 L644,2 L652,20 L660,16 L900,16 L920,16 L928,5 L936,27 L944,5 L952,19 L960,16 L1200,16"
                      stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        {{-- Traits lumineux haut/bas --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-indigo-500/20 to-transparent"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-5 lg:px-8 text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2.5 bg-white/10 border border-white/10 backdrop-blur-sm text-white/80 text-xs font-semibold px-4 py-2 rounded-full mb-8">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
            </span>
            500+ cabinets actifs au Maroc
        </div>

        {{-- Titre --}}
        <h2 class="text-4xl sm:text-5xl font-extrabold text-white leading-[1.1] tracking-tight mb-6">
            Votre cabinet mérite<br>
            <span class="bg-gradient-to-r from-blue-400 via-indigo-400 to-violet-400 bg-clip-text text-transparent">
                mieux que des tableaux Excel.
            </span>
        </h2>

        <p class="text-gray-400 text-base max-w-xl mx-auto mb-10 leading-relaxed">
            Rejoignez les médecins marocains qui ont digitalisé leur cabinet et récupéré des heures de leur journée.
        </p>

        {{-- CTAs --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
            <a href="#pricing" data-scroll
               class="relative group w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-3.5 rounded-2xl text-sm font-bold shadow-sm shadow-blue-500/20 hover:shadow-blue-500/30 hover:scale-[1.02] active:scale-100 transition-all duration-300 overflow-hidden">
                <span class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                <span class="relative z-10 flex items-center gap-2">
                    Démarrer gratuitement — 14 jours
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </span>
            </a>
            <a href="#contact" data-scroll
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/20 hover:border-white/40 text-white/80 hover:text-white px-8 py-3.5 rounded-2xl text-sm font-semibold backdrop-blur-sm hover:bg-white/5 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Parler à un conseiller
            </a>
        </div>

        {{-- Garanties --}}
        <div class="flex flex-wrap items-center justify-center gap-5 sm:gap-8">
            @foreach([
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Sans carte bancaire'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'text' => 'Données sécurisées'],
                ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'text' => 'Support 24/7'],
                ['icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z', 'text' => 'Résiliation libre'],
            ] as $g)
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $g['icon'] }}"/>
                </svg>
                {{ $g['text'] }}
            </div>
            @endforeach
        </div>

    </div>
</section>
