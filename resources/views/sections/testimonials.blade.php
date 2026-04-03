<section id="testimonials" class="py-24 bg-[#f8faff] relative overflow-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="absolute -right-40 top-1/4 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -left-40 bottom-1/4 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                <div class="w-6 h-px bg-blue-400"></div>
                Témoignages
                <div class="w-6 h-px bg-blue-400"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                Ils ont transformé<br class="hidden sm:block">
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">leur cabinet avec nous</span>
            </h2>
            <p class="text-gray-400 text-sm max-w-md mx-auto">500+ médecins à travers le Maroc font confiance à MediAssist au quotidien.</p>

            {{-- Note globale --}}
            <div class="inline-flex items-center gap-3 mt-6 bg-white border border-gray-100 shadow-sm rounded-2xl px-5 py-3">
                <div class="flex gap-0.5">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-sm font-bold text-gray-900">4.9 / 5</span>
                <div class="w-px h-4 bg-gray-200"></div>
                <span class="text-xs text-gray-400">basé sur 380+ avis</span>
            </div>
        </div>

        @php
        $testimonials = [
            [
                'name'     => 'Dr. Hassan Alami',
                'role'     => 'Médecin généraliste',
                'city'     => 'Oujda',
                'avatar'   => 'HA',
                'color'    => 'from-blue-500 to-blue-600',
                'rating'   => 5,
                'tag'      => 'Gain de temps',
                'tagColor' => 'bg-blue-50 text-blue-600',
                'text'     => 'MediAssist a transformé mon cabinet. Je gagne plus de 2 heures par jour sur l\'administratif, du temps que je consacre enfin à mes patients.',
                'stat'     => ['val' => '+2h', 'label' => 'gagnées / jour'],
            ],
            [
                'name'     => 'Dr. Sara Bennani',
                'role'     => 'Pédiatre',
                'city'     => 'Casablanca',
                'avatar'   => 'SB',
                'color'    => 'from-purple-500 to-pink-500',
                'rating'   => 5,
                'tag'      => 'Facilité',
                'tagColor' => 'bg-purple-50 text-purple-600',
                'text'     => 'Interface très intuitive. Ma secrétaire a été opérationnelle en moins d\'une journée. Les rappels SMS automatiques ont réduit les absences de 40%.',
                'stat'     => ['val' => '-40%', 'label' => 'd\'absences'],
            ],
            [
                'name'     => 'Dr. Youssef Karimi',
                'role'     => 'Cardiologue',
                'city'     => 'Rabat',
                'avatar'   => 'YK',
                'color'    => 'from-emerald-500 to-teal-500',
                'rating'   => 5,
                'tag'      => 'Suivi patient',
                'tagColor' => 'bg-emerald-50 text-emerald-600',
                'text'     => 'Le suivi des analyses et des comptes rendus est excellent. J\'accède au dossier complet de chaque patient en quelques secondes. Je recommande vivement.',
                'stat'     => ['val' => '< 5s', 'label' => 'accès dossier'],
            ],
            [
                'name'     => 'Dr. Fatima Ouali',
                'role'     => 'Dermatologue',
                'city'     => 'Marrakech',
                'avatar'   => 'FO',
                'color'    => 'from-rose-500 to-orange-400',
                'rating'   => 5,
                'tag'      => 'Facturation',
                'tagColor' => 'bg-rose-50 text-rose-600',
                'text'     => 'La facturation automatique est une révolution. Plus aucune facture oubliée, suivi des paiements clair et exports comptables qui me font gagner un temps précieux.',
                'stat'     => ['val' => '0', 'label' => 'facture oubliée'],
            ],
            [
                'name'     => 'Dr. Khalid Tazi',
                'role'     => 'Interniste',
                'city'     => 'Fès',
                'avatar'   => 'KT',
                'color'    => 'from-indigo-500 to-violet-600',
                'rating'   => 5,
                'tag'      => 'Support',
                'tagColor' => 'bg-indigo-50 text-indigo-600',
                'text'     => 'Le support est réactif et à l\'écoute. Chaque fois que j\'ai eu une question, j\'ai eu une réponse en moins d\'une heure. Rare de trouver ce niveau de service.',
                'stat'     => ['val' => '< 1h', 'label' => 'temps de réponse'],
            ],
            [
                'name'     => 'Dr. Nadia El Fassi',
                'role'     => 'Gynécologue',
                'city'     => 'Tanger',
                'avatar'   => 'NF',
                'color'    => 'from-cyan-500 to-blue-500',
                'rating'   => 5,
                'tag'      => 'Ordonnances',
                'tagColor' => 'bg-cyan-50 text-cyan-600',
                'text'     => 'Les ordonnances en PDF en moins de 30 secondes, c\'est incroyable. Mes patients apprécient de recevoir leurs documents directement sur leur téléphone.',
                'stat'     => ['val' => '30s', 'label' => 'par ordonnance'],
            ],
        ];
        @endphp

        {{-- Grille --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 items-start">
            @foreach($testimonials as $i => $t)
            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col gap-4
                {{ $i >= 3 ? 'hidden md:flex' : '' }}">

                {{-- Top : tag + étoiles --}}
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $t['tagColor'] }}">{{ $t['tag'] }}</span>
                    <div class="flex gap-0.5">
                        @for($s = 0; $s < $t['rating']; $s++)
                        <svg class="w-3.5 h-3.5 text-amber-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                </div>

                {{-- Citation --}}
                <p class="text-sm text-gray-600 leading-relaxed">"{{ $t['text'] }}"</p>

                {{-- Stat --}}
                <div class="flex items-center gap-2 bg-gray-50 rounded-2xl px-4 py-2.5">
                    <span class="text-base font-extrabold text-gray-900">{{ $t['stat']['val'] }}</span>
                    <span class="text-xs text-gray-400">{{ $t['stat']['label'] }}</span>
                </div>

                {{-- Auteur --}}
                <div class="flex items-center gap-3 pt-1 border-t border-gray-50">
                    <div class="w-9 h-9 bg-gradient-to-br {{ $t['color'] }} rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ $t['avatar'] }}
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900">{{ $t['name'] }}</div>
                        <div class="text-xs text-gray-400">{{ $t['role'] }} · {{ $t['city'] }}</div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>
