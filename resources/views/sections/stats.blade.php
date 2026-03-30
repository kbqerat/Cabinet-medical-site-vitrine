<section class="relative py-24 overflow-hidden bg-[#0a0f1e]">

    {{-- Fond étoilé subtil --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 opacity-[0.4]"
             style="background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-indigo-500/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Tagline --}}
        <div class="text-center mb-16">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-400/70 mb-4">Impact réel · Résultats mesurables</p>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">
                Des chiffres qui parlent
            </h2>
        </div>

        {{-- ECG line décorative --}}
        <div class="relative mb-16 h-16 flex items-center">
            <svg class="w-full h-full" viewBox="0 0 1200 64" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="ecg-grad" x1="0" y1="0" x2="1200" y2="0" gradientUnits="userSpaceOnUse">
                        <stop offset="0%"   stop-color="#3b82f6" stop-opacity="0"/>
                        <stop offset="20%"  stop-color="#3b82f6" stop-opacity="0.6"/>
                        <stop offset="50%"  stop-color="#a78bfa" stop-opacity="1"/>
                        <stop offset="80%"  stop-color="#3b82f6" stop-opacity="0.6"/>
                        <stop offset="100%" stop-color="#3b82f6" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                {{-- Ligne ECG : plat → pic 1 → retour → pic 2 (pulse) → plat --}}
                <path d="
                    M0,32 L200,32
                    L220,32 L230,10 L240,54 L250,10 L260,48 L270,32
                    L440,32
                    L460,32 L465,24 L470,8  L475,52 L480,8  L485,38 L490,32
                    L660,32
                    L680,32 L685,20 L690,6  L695,56 L700,6  L705,40 L710,32
                    L880,32
                    L900,32 L905,22 L910,4  L915,58 L920,4  L925,42 L930,32
                    L1200,32
                " stroke="url(#ecg-grad)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{-- Points lumineux aux pics --}}
            <div class="absolute left-[22.5%] top-1/2 -translate-y-1/2 w-2 h-2 bg-blue-400 rounded-full shadow-[0_0_8px_3px_rgba(96,165,250,0.5)]"></div>
            <div class="absolute left-[47.5%] top-1/2 -translate-y-1/2 w-2 h-2 bg-violet-400 rounded-full shadow-[0_0_8px_3px_rgba(167,139,250,0.5)]"></div>
            <div class="absolute left-[72.5%] top-1/2 -translate-y-1/2 w-2 h-2 bg-blue-400 rounded-full shadow-[0_0_8px_3px_rgba(96,165,250,0.5)]"></div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-white/5 rounded-2xl overflow-hidden border border-white/5">

            @foreach([
                [
                    'value'   => '500',
                    'suffix'  => '+',
                    'label'   => 'Cabinets',
                    'sub'     => 'utilisateurs actifs',
                    'color'   => 'from-blue-500 to-blue-400',
                    'glow'    => 'rgba(59,130,246,0.15)',
                ],
                [
                    'value'   => '50k',
                    'suffix'  => '+',
                    'label'   => 'Patients',
                    'sub'     => 'dossiers gérés',
                    'color'   => 'from-violet-500 to-indigo-400',
                    'glow'    => 'rgba(139,92,246,0.15)',
                ],
                [
                    'value'   => '99',
                    'suffix'  => '%',
                    'label'   => 'Satisfaction',
                    'sub'     => 'clients satisfaits',
                    'color'   => 'from-cyan-500 to-blue-400',
                    'glow'    => 'rgba(6,182,212,0.15)',
                ],
                [
                    'value'   => '24/7',
                    'suffix'  => '',
                    'label'   => 'Support',
                    'sub'     => 'disponible en continu',
                    'color'   => 'from-indigo-400 to-purple-400',
                    'glow'    => 'rgba(99,102,241,0.15)',
                ],
            ] as $stat)
            <div class="group relative bg-[#0d1426] hover:bg-[#101830] transition-colors duration-300 px-8 py-10 flex flex-col gap-2"
                 style="--glow: {{ $stat['glow'] }}">
                {{-- Halo de fond --}}
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-none"
                     style="background: radial-gradient(ellipse at 50% 100%, {{ $stat['glow'] }}, transparent 70%)"></div>

                {{-- Grand chiffre fantôme --}}
                <div class="absolute -bottom-3 -right-2 text-[7rem] font-black leading-none select-none pointer-events-none
                            bg-gradient-to-br {{ $stat['color'] }} bg-clip-text text-transparent opacity-[0.04] group-hover:opacity-[0.07] transition-opacity duration-300">
                    {{ $stat['value'] }}
                </div>

                <div class="relative">
                    {{-- Valeur --}}
                    <div class="flex items-end gap-1 mb-2">
                        <span class="text-4xl sm:text-5xl font-extrabold tracking-tight bg-gradient-to-r {{ $stat['color'] }} bg-clip-text text-transparent leading-none">
                            {{ $stat['value'] }}
                        </span>
                        @if($stat['suffix'])
                        <span class="text-2xl sm:text-3xl font-bold bg-gradient-to-r {{ $stat['color'] }} bg-clip-text text-transparent leading-none mb-0.5">
                            {{ $stat['suffix'] }}
                        </span>
                        @endif
                    </div>

                    {{-- Label --}}
                    <div class="text-sm font-bold text-white/90 mb-0.5">{{ $stat['label'] }}</div>
                    <div class="text-xs text-gray-500">{{ $stat['sub'] }}</div>

                    {{-- Trait accent --}}
                    <div class="mt-5 h-[2px] w-10 rounded-full bg-gradient-to-r {{ $stat['color'] }} opacity-60 group-hover:w-16 group-hover:opacity-100 transition-all duration-500"></div>
                </div>
            </div>
            @endforeach

        </div>

    </div>
</section>
