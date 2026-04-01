<section id="how-it-works" class="py-24 bg-white relative overflow-hidden">

    {{-- Déco fond --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="absolute -right-32 top-1/2 -translate-y-1/2 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -left-32 top-1/3 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                <div class="w-6 h-px bg-blue-400"></div>
                Démarrage
                <div class="w-6 h-px bg-blue-400"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                Opérationnel en
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">moins de 15 minutes</span>
            </h2>
            <p class="text-gray-400 text-sm max-w-md mx-auto">Aucune installation, aucun technicien. Tout se passe en ligne, à votre rythme.</p>
        </div>

        {{-- Steps --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 relative">

            {{-- Ligne de connexion desktop --}}
            <div class="absolute top-10 left-[calc(33%+24px)] right-[calc(33%+24px)] h-px border-t-2 border-dashed border-blue-100 hidden lg:block"></div>

            @php
            $steps = [
                [
                    'num'   => '01',
                    'title' => 'Choisissez votre plan',
                    'desc'  => 'Comparez nos offres et sélectionnez celle qui correspond à votre cabinet — solo, groupe ou clinique. Licence unique ou abonnement mensuel sans engagement.',
                    'color' => 'from-blue-500 to-blue-600',
                    'bg'    => 'bg-blue-50',
                    'text'  => 'text-blue-600',
                    'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    'details' => ['Essai gratuit 14 jours', 'Sans carte bancaire', 'Résiliation à tout moment'],
                ],
                [
                    'num'   => '02',
                    'title' => 'Configurez votre cabinet',
                    'desc'  => 'Renseignez les informations de votre cabinet, ajoutez vos médecins, votre secrétaire et personnalisez votre espace en quelques clics.',
                    'color' => 'from-indigo-500 to-violet-600',
                    'bg'    => 'bg-indigo-50',
                    'text'  => 'text-indigo-600',
                    'icon'  => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                    'details' => ['Import patients CSV', 'Multi-médecins', 'Logo & couleurs personnalisés'],
                ],
                [
                    'num'   => '03',
                    'title' => 'Gérez au quotidien',
                    'desc'  => 'Ajoutez vos patients, planifiez les rendez-vous, rédigez ordonnances et comptes rendus — tout depuis un seul tableau de bord intuitif.',
                    'color' => 'from-emerald-500 to-teal-500',
                    'bg'    => 'bg-emerald-50',
                    'text'  => 'text-emerald-600',
                    'icon'  => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'details' => ['Accès mobile & desktop', 'Données sauvegardées', 'Support inclus 24/7'],
                ],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="relative bg-white border border-gray-100 rounded-3xl p-7 shadow-sm hover:shadow-md transition-all duration-300 group">

                {{-- Numéro + icône --}}
                <div class="flex items-center gap-4 mb-6">
                    <div class="relative w-14 h-14 rounded-2xl bg-gradient-to-br {{ $step['color'] }} flex items-center justify-center shadow-md shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $step['icon'] }}"/>
                        </svg>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-white border-2 border-gray-100 rounded-full flex items-center justify-center shadow-sm">
                            <span class="text-[10px] font-black {{ $step['text'] }}">{{ $step['num'] }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest {{ $step['text'] }} opacity-60">Étape {{ $step['num'] }}</span>
                        <h3 class="text-base font-bold text-gray-900 leading-tight">{{ $step['title'] }}</h3>
                    </div>
                </div>

                {{-- Description --}}
                <p class="text-sm text-gray-500 leading-relaxed mb-6">{{ $step['desc'] }}</p>

                {{-- Checklist --}}
                <ul class="space-y-2">
                    @foreach($step['details'] as $detail)
                    <li class="flex items-center gap-2.5 text-xs text-gray-600">
                        <div class="w-4 h-4 rounded-full {{ $step['bg'] }} flex items-center justify-center shrink-0">
                            <svg class="w-2.5 h-2.5 {{ $step['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        {{ $detail }}
                    </li>
                    @endforeach
                </ul>

            </div>
            @endforeach

        </div>

        {{-- CTA bas --}}
        <div class="mt-14 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl px-8 py-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-white font-bold text-lg mb-1">Prêt à moderniser votre cabinet ?</p>
                <p class="text-blue-200 text-sm">Rejoignez 500+ médecins qui font confiance à MediAssist.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
                <a href="#contact" data-scroll
                   class="bg-white text-blue-600 font-semibold text-sm px-6 py-3 rounded-2xl hover:bg-blue-50 transition-colors duration-200 w-full sm:w-auto text-center">
                    Démarrer gratuitement
                </a>
                <a href="#pricing" data-scroll
                   class="text-white/80 hover:text-white text-sm font-medium transition-colors duration-200 flex items-center gap-1.5">
                    Voir les tarifs
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</section>
