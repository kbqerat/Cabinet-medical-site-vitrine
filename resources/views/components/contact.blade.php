<section id="contact" class="py-24 bg-[#f8faff] relative overflow-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="absolute -right-40 top-1/4 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-70"></div>
        <div class="absolute -left-40 bottom-1/4 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                <div class="w-6 h-px bg-blue-400"></div>
                Contact
                <div class="w-6 h-px bg-blue-400"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                Parlons de
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">votre cabinet</span>
            </h2>
            <p class="text-gray-400 text-sm max-w-sm mx-auto">Notre équipe vous répond en moins de 2h pendant les heures ouvrables.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start max-w-5xl mx-auto">

            {{-- Infos gauche --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Carte réponse rapide --}}
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 text-white">
                    <div class="w-11 h-11 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base mb-1">Réponse rapide garantie</h3>
                    <p class="text-blue-200 text-xs leading-relaxed">Nous vous revenons sous 2h en semaine. Pour les urgences, appelez-nous directement.</p>
                    <div class="mt-4 pt-4 border-t border-white/10 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <span class="text-xs text-blue-100">Équipe disponible · Lun–Ven 9h–18h</span>
                    </div>
                </div>

                {{-- Moyens de contact --}}
                <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm space-y-4">
                    @foreach([
                        [
                            'icon'  => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'label' => 'Email',
                            'value' => 'contact@mediassist.ma',
                            'color' => 'bg-blue-50 text-blue-600',
                        ],
                        [
                            'icon'  => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                            'label' => 'Téléphone',
                            'value' => '+212 5 XX XX XX XX',
                            'color' => 'bg-emerald-50 text-emerald-600',
                        ],
                        [
                            'icon'  => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                            'label' => 'Adresse',
                            'value' => 'Casablanca, Maroc',
                            'color' => 'bg-rose-50 text-rose-600',
                        ],
                    ] as $info)
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 {{ $info['color'] }} rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $info['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ $info['label'] }}</div>
                            <div class="text-sm font-semibold text-gray-800">{{ $info['value'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Réseaux sociaux --}}
                <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Suivez-nous</p>
                    <div class="flex items-center gap-2">
                        @foreach([
                            ['label' => 'LinkedIn', 'icon' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],
                            ['label' => 'Twitter',  'icon' => 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z'],
                            ['label' => 'Facebook', 'icon' => 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                        ] as $social)
                        <a href="#" class="w-9 h-9 bg-gray-100 hover:bg-blue-100 hover:text-blue-600 text-gray-500 rounded-xl flex items-center justify-center transition-all duration-200 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $social['icon'] }}"/>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Formulaire --}}
            <div class="lg:col-span-3 bg-white border border-gray-100 rounded-3xl p-7 shadow-sm">

                <h3 class="text-base font-bold text-gray-900 mb-1">Envoyez-nous un message</h3>
                <p class="text-xs text-gray-400 mb-6">Remplissez le formulaire et nous vous contacterons rapidement.</p>

                <form class="space-y-4">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nom complet</label>
                            <input type="text"
                                   placeholder="Dr. Alami Hassan"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email professionnel</label>
                            <input type="email"
                                   placeholder="contact@cabinet.ma"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Téléphone</label>
                            <input type="tel"
                                   placeholder="+212 6XX XXX XXX"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Spécialité</label>
                            <select class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                                <option value="" class="text-gray-300">Sélectionner...</option>
                                <option>Médecine générale</option>
                                <option>Cardiologie</option>
                                <option>Pédiatrie</option>
                                <option>Gynécologie</option>
                                <option>Dermatologie</option>
                                <option>Dentisterie</option>
                                <option>Autre</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Objet</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Demande de démo', 'Question tarifs', 'Support technique', 'Partenariat', 'Autre'] as $sujet)
                            <label class="cursor-pointer">
                                <input type="radio" name="sujet" value="{{ $sujet }}" class="sr-only peer" {{ $sujet === 'Demande de démo' ? 'checked' : '' }}>
                                <span class="inline-block text-xs font-medium px-3 py-1.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-500
                                             peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600
                                             hover:border-blue-300 hover:text-blue-600 transition-all duration-150 select-none">
                                    {{ $sujet }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Message</label>
                        <textarea rows="4"
                                  placeholder="Décrivez votre cabinet et vos besoins..."
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all duration-200 resize-none"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-2xl text-sm font-bold shadow-sm hover:shadow-blue-400/30 hover:scale-[1.01] active:scale-100 transition-all duration-300 group flex items-center justify-center gap-2">
                        <span class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Envoyer le message
                        </span>
                    </button>

                    <p class="text-center text-[11px] text-gray-400">
                        En soumettant ce formulaire, vous acceptez notre
                        <a href="#" class="text-blue-500 hover:underline">politique de confidentialité</a>.
                    </p>

                </form>
            </div>

        </div>
    </div>
</section>
