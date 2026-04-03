<footer class="bg-[#0a0f1e] relative overflow-hidden">

    {{-- Déco --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 opacity-[0.03]"
             style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/20 to-transparent"></div>
        <div class="absolute -left-40 top-0 w-96 h-96 bg-blue-600/5 rounded-full blur-3xl"></div>
        <div class="absolute -right-40 bottom-0 w-96 h-96 bg-indigo-600/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Corps principal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pt-16 pb-12">

            {{-- Brand --}}
            <div class="lg:col-span-2 space-y-5">
                <a href="/" class="flex items-center gap-3 group w-fit">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[17px] font-bold tracking-tight text-white">Medi<span class="text-blue-400">Assist</span></span>
                        <p class="text-[10px] text-gray-500 font-medium tracking-wide -mt-0.5">Cabinet Médical</p>
                    </div>
                </a>

                <p class="text-sm text-gray-500 leading-relaxed max-w-xs">
                    La solution de gestion de cabinet médical pensée pour les professionnels de santé marocains.
                </p>

                {{-- Badges --}}
                <div class="flex flex-wrap gap-2">
                    @foreach(['RGPD', 'Données au Maroc', 'Chiffrement AES-256'] as $badge)
                    <span class="text-[11px] font-semibold text-gray-500 border border-gray-800 px-2.5 py-1 rounded-lg">
                        {{ $badge }}
                    </span>
                    @endforeach
                </div>

                {{-- Réseaux --}}
                <div class="flex items-center gap-2">
                    @foreach([
                        ['icon' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],
                        ['icon' => 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z'],
                        ['icon' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                    ] as $s)
                    <a href="#" class="w-8 h-8 bg-white/5 hover:bg-blue-600/20 border border-white/5 hover:border-blue-500/30 rounded-xl flex items-center justify-center text-gray-500 hover:text-blue-400 transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                        </svg>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Produit --}}
            <div>
                <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-5">Produit</h4>
                <ul class="space-y-3">
                    @foreach([
                        ['href' => '#features',     'label' => 'Fonctionnalités'],
                        ['href' => '#how-it-works', 'label' => 'Comment ça marche'],
                        ['href' => '#screenshots',  'label' => 'Aperçu'],
                        ['href' => '#pricing',      'label' => 'Tarifs'],
                        ['href' => '#faq',          'label' => 'FAQ'],
                    ] as $link)
                    <li>
                        <a href="{{ $link['href'] }}" data-scroll
                           class="text-sm text-gray-500 hover:text-white transition-colors duration-200 flex items-center gap-2 group">
                            <span class="w-0 group-hover:w-3 h-px bg-blue-400 transition-all duration-200 rounded-full"></span>
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Espaces --}}
            <div>
                <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-5">Connexion</h4>
                <ul class="space-y-3">
                    @foreach([
                        ['href' => '/login/doctor', 'label' => 'Espace médecin'],
                        ['href' => '/login/admin',  'label' => 'Espace admin'],
                        ['href' => '#contact',      'label' => 'Demander une démo'],
                    ] as $link)
                    <li>
                        <a href="{{ $link['href'] }}"
                           class="text-sm text-gray-500 hover:text-white transition-colors duration-200 flex items-center gap-2 group">
                            <span class="w-0 group-hover:w-3 h-px bg-blue-400 transition-all duration-200 rounded-full"></span>
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-5">Contact</h4>
                <ul class="space-y-3.5">
                    @foreach([
                        ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'text' => 'contact@mediassist.ma'],
                        ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'text' => '+212 5 XX XX XX XX'],
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'text' => 'Casablanca, Maroc'],
                    ] as $c)
                    <li class="flex items-start gap-2.5">
                        <div class="w-7 h-7 bg-white/5 border border-white/5 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $c['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500 leading-tight">{{ $c['text'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>

        {{-- Bas de page --}}
        <div class="border-t border-white/5 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-600">© 2026 MediAssist. Tous droits réservés.</p>
            <div class="flex flex-wrap items-center gap-5">
                @foreach([
                    ['label' => 'Politique de confidentialité', 'href' => '/confidentialite'],
                    ['label' => "Conditions d'utilisation",     'href' => '/cgu'],
                    ['label' => 'Mentions légales',             'href' => '/mentions-legales'],
                ] as $legal)
                <a href="{{ $legal['href'] }}" class="text-xs text-gray-600 hover:text-gray-400 transition-colors duration-200">{{ $legal['label'] }}</a>
                @endforeach
            </div>
        </div>

    </div>
</footer>
