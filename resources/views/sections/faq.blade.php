<section id="faq" class="py-24 bg-white relative overflow-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="absolute -right-32 top-1/3 w-80 h-80 bg-blue-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -left-32 bottom-1/3 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                <div class="w-6 h-px bg-blue-400"></div>
                FAQ
                <div class="w-6 h-px bg-blue-400"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                Vous avez des questions ?
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">On a les réponses.</span>
            </h2>
            <p class="text-gray-400 text-sm max-w-md mx-auto">Tout ce que vous devez savoir avant de démarrer. Vous ne trouvez pas votre réponse ?
                <a href="#contact" data-scroll class="text-blue-600 font-semibold hover:underline">Contactez-nous.</a>
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-start">

            {{-- Catégories --}}
            <div x-data="{ cat: 0 }" class="lg:col-span-12">

                {{-- Tabs catégories --}}
                <div class="flex flex-wrap gap-2 mb-8 justify-center">
                    @foreach(['Général', 'Tarifs & Paiement', 'Technique', 'Données & Sécurité'] as $ci => $cat)
                    <button @click="cat = {{ $ci }}"
                            :class="cat === {{ $ci }}
                                ? 'bg-blue-600 text-white shadow-sm shadow-blue-200'
                                : 'bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700'"
                            class="px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200">
                        {{ $cat }}
                    </button>
                    @endforeach
                </div>

                @php
                $categories = [
                    // Général
                    [
                        [
                            'q' => 'À qui s\'adresse MediAssist ?',
                            'a' => 'MediAssist est conçu pour tous les professionnels de santé au Maroc : médecins généralistes, spécialistes, dentistes, kinésithérapeutes et toute structure médicale souhaitant digitaliser sa gestion quotidienne.',
                        ],
                        [
                            'q' => 'Puis-je essayer avant d\'acheter ?',
                            'a' => 'Oui, nous offrons un essai gratuit de 14 jours sur tous les plans cloud, sans carte bancaire requise. Vous accédez à toutes les fonctionnalités sans limitation pendant la période d\'essai.',
                        ],
                        [
                            'q' => 'L\'application est-elle disponible en arabe ?',
                            'a' => 'L\'interface est actuellement disponible en français. La version arabe est en cours de développement et sera disponible prochainement.',
                        ],
                        [
                            'q' => 'Combien de temps faut-il pour être opérationnel ?',
                            'a' => 'La configuration initiale prend moins de 15 minutes. Notre équipe vous accompagne lors de l\'onboarding pour importer vos données existantes et paramétrer votre espace.',
                        ],
                        [
                            'q' => 'L\'application mobile est-elle incluse ?',
                            'a' => 'L\'app mobile iOS et Android est incluse dans les plans Pro et Clinique. Pour la licence, elle est disponible en option. Elle vous permet de consulter l\'agenda et les dossiers patients en déplacement.',
                        ],
                    ],
                    // Tarifs & Paiement
                    [
                        [
                            'q' => 'Quelle est la différence entre la licence et l\'abonnement ?',
                            'a' => 'La licence est un paiement unique (4 900 MAD) qui installe le logiciel sur votre propre serveur. L\'abonnement cloud est mensuel, hébergé par nos soins, avec mises à jour et support automatiquement inclus.',
                        ],
                        [
                            'q' => 'Puis-je changer de plan à tout moment ?',
                            'a' => 'Oui, vous pouvez upgrader ou downgrader votre plan à tout moment depuis votre espace client. Le changement prend effet immédiatement, avec un ajustement au prorata pour la période en cours.',
                        ],
                        [
                            'q' => 'Quels moyens de paiement acceptez-vous ?',
                            'a' => 'Nous acceptons les cartes bancaires (Visa, Mastercard), les virements bancaires et le paiement par chèque pour les abonnements annuels. Le paiement en espèces est disponible pour la licence unique.',
                        ],
                        [
                            'q' => 'Y a-t-il des frais cachés ?',
                            'a' => 'Non. Le prix affiché inclut tout : hébergement, mises à jour, support et accès mobile. Aucune surprise sur votre facture mensuelle.',
                        ],
                        [
                            'q' => 'La résiliation est-elle possible à tout moment ?',
                            'a' => 'Oui, sans engagement ni frais de résiliation. Vous pouvez annuler à tout moment depuis votre espace client. Vos données vous sont restituées dans les 30 jours suivant la résiliation.',
                        ],
                    ],
                    // Technique
                    [
                        [
                            'q' => 'Quel équipement est nécessaire pour utiliser MediAssist ?',
                            'a' => 'Aucune installation requise pour la version cloud. Un simple navigateur web (Chrome, Firefox, Safari) et une connexion internet suffisent. L\'application fonctionne sur ordinateur, tablette et smartphone.',
                        ],
                        [
                            'q' => 'Que se passe-t-il si je n\'ai pas internet ?',
                            'a' => 'Pour la version cloud, une connexion internet est requise. Pour la version licence installée sur votre serveur, une connexion locale suffit. Un mode hors-ligne partiel est prévu dans une prochaine mise à jour.',
                        ],
                        [
                            'q' => 'Puis-je importer mes données existantes ?',
                            'a' => 'Oui, nous supportons l\'import de données depuis Excel, CSV et plusieurs logiciels médicaux courants. Notre équipe technique vous accompagne gratuitement lors de la migration.',
                        ],
                        [
                            'q' => 'Les mises à jour sont-elles automatiques ?',
                            'a' => 'Pour l\'abonnement cloud, oui — les mises à jour se font automatiquement sans interruption de service. Pour la licence, les mises à jour sont incluses pendant 1 an, puis disponibles en option.',
                        ],
                    ],
                    // Données & Sécurité
                    [
                        [
                            'q' => 'Où sont hébergées mes données ?',
                            'a' => 'Vos données sont hébergées sur des serveurs sécurisés au Maroc, conformément à la réglementation locale sur la protection des données de santé. Aucune donnée ne quitte le territoire marocain.',
                        ],
                        [
                            'q' => 'Mes données sont-elles chiffrées ?',
                            'a' => 'Oui, toutes les données sont chiffrées en transit (TLS 1.3) et au repos (AES-256). Les dossiers médicaux bénéficient d\'un chiffrement de bout en bout.',
                        ],
                        [
                            'q' => 'Qui a accès à mes données patients ?',
                            'a' => 'Uniquement vous et les membres de votre équipe que vous autorisez. Nos équipes techniques n\'accèdent jamais aux données médicales. Vous contrôlez intégralement les droits d\'accès.',
                        ],
                        [
                            'q' => 'Des sauvegardes sont-elles effectuées régulièrement ?',
                            'a' => 'Oui, des sauvegardes automatiques sont effectuées toutes les heures sur les plans cloud. Vous pouvez également exporter manuellement vos données à tout moment depuis votre espace.',
                        ],
                    ],
                ];
                @endphp

                {{-- Accordéon par catégorie --}}
                @foreach($categories as $ci => $faqs)
                <div x-show="cat === {{ $ci }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="max-w-3xl mx-auto">

                    <div x-data="{ open: 0 }" class="space-y-3">
                        @foreach($faqs as $fi => $faq)
                        <div @click="open = open === {{ $fi }} ? null : {{ $fi }}"
                             class="bg-white border rounded-2xl overflow-hidden cursor-pointer transition-all duration-200 shadow-sm"
                             :class="open === {{ $fi }} ? 'border-blue-200 shadow-blue-100/50' : 'border-gray-100 hover:border-gray-200'">

                            {{-- Question --}}
                            <div class="flex items-center justify-between px-6 py-4 gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-7 h-7 rounded-xl flex items-center justify-center shrink-0 transition-colors duration-200"
                                         :class="open === {{ $fi }} ? 'bg-blue-600' : 'bg-gray-100'">
                                        <span class="text-[10px] font-black transition-colors duration-200"
                                              :class="open === {{ $fi }} ? 'text-white' : 'text-gray-400'">
                                            {{ str_pad($fi + 1, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                    <h4 class="text-sm font-semibold transition-colors duration-200"
                                        :class="open === {{ $fi }} ? 'text-blue-700' : 'text-gray-800'">
                                        {{ $faq['q'] }}
                                    </h4>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center shrink-0 transition-all duration-200"
                                     :class="open === {{ $fi }} ? 'bg-blue-100 rotate-45' : ''">
                                    <svg class="w-3 h-3 transition-colors duration-200"
                                         :class="open === {{ $fi }} ? 'text-blue-600' : 'text-gray-400'"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Réponse --}}
                            <div x-show="open === {{ $fi }}"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="px-6 pb-5">
                                <div class="pl-11 text-sm text-gray-500 leading-relaxed border-t border-gray-50 pt-3">
                                    {{ $faq['a'] }}
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
                @endforeach

            </div>

        </div>

        {{-- CTA bas --}}
        <div class="mt-14 text-center">
            <p class="text-sm text-gray-400 mb-4">Vous avez d'autres questions ?</p>
            <a href="#contact" data-scroll
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-2xl text-sm font-semibold shadow-md hover:shadow-blue-400/30 hover:scale-[1.02] transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Parler à un conseiller
            </a>
        </div>

    </div>
</section>
