<section id="pricing" class="py-24 bg-white relative overflow-hidden">

    {{-- Déco --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="absolute -left-40 top-1/2 -translate-y-1/2 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-70"></div>
        <div class="absolute -right-40 top-1/3 w-96 h-96 bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                <div class="w-6 h-px bg-blue-400"></div>
                Tarifs
                <div class="w-6 h-px bg-blue-400"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                Un plan pour
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">chaque cabinet</span>
            </h2>
            <p class="text-gray-400 text-sm max-w-md mx-auto">Essai gratuit 14 jours · Sans carte bancaire · Résiliation à tout moment</p>
        </div>

        {{-- Toggle mensuel/annuel --}}
        <div x-data="{ annual: false }" class="flex flex-col items-center gap-10">

            <div class="flex items-center gap-3">
                <span class="text-sm font-medium" :class="!annual ? 'text-gray-900' : 'text-gray-400'">Mensuel</span>
                <button @click="annual = !annual"
                        :class="annual ? 'bg-blue-600' : 'bg-gray-200'"
                        class="relative w-11 h-6 rounded-full transition-colors duration-300">
                    <div :class="annual ? 'translate-x-5' : 'translate-x-1'"
                         class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-300"></div>
                </button>
                <span class="text-sm font-medium" :class="annual ? 'text-gray-900' : 'text-gray-400'">
                    Annuel
                    <span class="ml-1.5 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">-20%</span>
                </span>
            </div>

            {{-- Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 w-full max-w-4xl mx-auto">

                @php
                $plans = [
                    [
                        'name'    => 'Starter',
                        'desc'    => 'Pour les médecins solo qui débutent',
                        'monthly' => '290',
                        'annual'  => '232',
                        'color'   => 'text-blue-600',
                        'bg'      => 'bg-blue-50',
                        'btn'     => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50',
                        'popular' => false,
                        'features' => [
                            ['ok' => true,  'text' => '1 médecin'],
                            ['ok' => true,  'text' => 'Jusqu\'à 300 patients'],
                            ['ok' => true,  'text' => 'Agenda & RDV'],
                            ['ok' => true,  'text' => 'Ordonnances PDF'],
                            ['ok' => false, 'text' => 'Multi-utilisateurs'],
                            ['ok' => false, 'text' => 'App mobile'],
                            ['ok' => false, 'text' => 'Support prioritaire'],
                        ],
                    ],
                    [
                        'name'    => 'Pro',
                        'desc'    => 'Le plus populaire pour les cabinets actifs',
                        'monthly' => '490',
                        'annual'  => '392',
                        'color'   => 'text-white',
                        'bg'      => 'bg-white/20',
                        'btn'     => 'bg-white text-blue-600 hover:bg-blue-50',
                        'popular' => true,
                        'features' => [
                            ['ok' => true, 'text' => '1 à 3 médecins'],
                            ['ok' => true, 'text' => 'Patients illimités'],
                            ['ok' => true, 'text' => 'Agenda & RDV avancé'],
                            ['ok' => true, 'text' => 'Ordonnances & analyses'],
                            ['ok' => true, 'text' => 'Multi-utilisateurs'],
                            ['ok' => true, 'text' => 'App mobile incluse'],
                            ['ok' => false,'text' => 'Support prioritaire'],
                        ],
                    ],
                    [
                        'name'    => 'Licence',
                        'desc'    => 'Paiement unique, hébergé chez vous',
                        'monthly' => '4900',
                        'annual'  => '4900',
                        'suffix'  => 'MAD · paiement unique',
                        'color'   => 'text-gray-700',
                        'bg'      => 'bg-gray-50',
                        'btn'     => 'border-2 border-gray-300 text-gray-700 hover:bg-gray-50',
                        'popular' => false,
                        'features' => [
                            ['ok' => true,  'text' => '1 cabinet'],
                            ['ok' => true,  'text' => 'Installation sur votre serveur'],
                            ['ok' => true,  'text' => 'Accès illimité à vie'],
                            ['ok' => true,  'text' => 'MAJ incluses 1 an'],
                            ['ok' => true,  'text' => 'Code source fourni'],
                            ['ok' => false, 'text' => 'App mobile'],
                            ['ok' => false, 'text' => 'Hébergement cloud'],
                        ],
                    ],
                ];
                @endphp

                @foreach($plans as $plan)
                <div class="relative flex flex-col rounded-3xl overflow-hidden transition-all duration-300
                    {{ $plan['popular']
                        ? 'bg-gradient-to-b from-blue-600 to-indigo-700 shadow-2xl shadow-blue-500/20 scale-[1.03] z-10'
                        : 'bg-white border border-gray-100 shadow-sm hover:shadow-md' }}">

                    @if($plan['popular'])
                    <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">
                        ⭐ Populaire
                    </div>
                    @endif

                    <div class="p-6 flex flex-col flex-1">

                        {{-- Name & desc --}}
                        <div class="mb-5">
                            <div class="text-xs font-bold uppercase tracking-widest mb-1
                                {{ $plan['popular'] ? 'text-blue-200' : 'text-gray-400' }}">
                                {{ $plan['name'] }}
                            </div>
                            <p class="text-xs leading-relaxed
                                {{ $plan['popular'] ? 'text-blue-100' : 'text-gray-400' }}">
                                {{ $plan['desc'] }}
                            </p>
                        </div>

                        {{-- Prix --}}
                        <div class="mb-6">
                            <div class="flex items-end gap-1">
                                <span class="text-3xl font-extrabold tracking-tight
                                    {{ $plan['popular'] ? 'text-white' : 'text-gray-900' }}">
                                    <span x-text="annual ? '{{ $plan['annual'] }}' : '{{ $plan['monthly'] }}'"></span>
                                </span>
                                <span class="text-sm font-medium mb-1
                                    {{ $plan['popular'] ? 'text-blue-200' : 'text-gray-400' }}">
                                    MAD
                                </span>
                            </div>
                            <p class="text-xs mt-0.5 {{ $plan['popular'] ? 'text-blue-200' : 'text-gray-400' }}">
                                @isset($plan['suffix'])
                                    {{ $plan['suffix'] }}
                                @else
                                    <span x-text="annual ? 'par mois · facturé annuellement' : 'par mois · sans engagement'"></span>
                                @endisset
                            </p>
                        </div>

                        {{-- Features --}}
                        <ul class="space-y-2.5 mb-7 flex-1">
                            @foreach($plan['features'] as $f)
                            <li class="flex items-center gap-2.5 text-xs
                                {{ $plan['popular'] ? ($f['ok'] ? 'text-white' : 'text-blue-300/50') : ($f['ok'] ? 'text-gray-600' : 'text-gray-300') }}">
                                @if($f['ok'])
                                <div class="w-4 h-4 rounded-full flex items-center justify-center shrink-0
                                    {{ $plan['popular'] ? 'bg-white/20' : $plan['bg'] }}">
                                    <svg class="w-2.5 h-2.5 {{ $plan['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                @else
                                <div class="w-4 h-4 rounded-full flex items-center justify-center shrink-0 bg-gray-100">
                                    <svg class="w-2.5 h-2.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                @endif
                                {{ $f['text'] }}
                            </li>
                            @endforeach
                        </ul>

                        {{-- CTA --}}
                        <a href="#contact" data-scroll
                           class="block text-center text-sm font-semibold px-5 py-2.5 rounded-2xl transition-all duration-200 {{ $plan['btn'] }}">
                            {{ $plan['popular'] ? 'Commencer l\'essai gratuit' : 'Choisir ce plan' }}
                        </a>

                    </div>
                </div>
                @endforeach

            </div>

            {{-- Bas de page --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 text-xs text-gray-400">
                @foreach(['Essai gratuit 14 jours', 'Sans carte bancaire', 'Support inclus dans tous les plans', 'Données hébergées au Maroc'] as $item)
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $item }}
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
