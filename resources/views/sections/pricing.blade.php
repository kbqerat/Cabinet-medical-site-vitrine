<section id="pricing" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-medium text-sm uppercase tracking-wide">Tarifs</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2">Un plan pour chaque besoin</h2>
            <p class="text-gray-500 mt-4 max-w-xl mx-auto">Choisissez entre une licence permanente ou un abonnement cloud avec mises à jour incluses.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">

            {{-- Licence --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 mb-2">Licence unique</div>
                <div class="text-4xl font-bold text-gray-900 mb-1">4 900 MAD</div>
                <div class="text-gray-400 text-sm mb-6">Paiement unique — à vie</div>
                <ul class="space-y-3 mb-8">
                    @foreach(['Installation sur votre serveur', 'Accès illimité', '1 cabinet', 'Mises à jour pendant 1 an', 'Support par email'] as $item)
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="text-green-500">✓</span> {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <a href="#contact" class="block text-center border-2 border-blue-600 text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition">
                    Acheter la licence
                </a>
            </div>

            {{-- SaaS --}}
            <div class="bg-blue-600 rounded-2xl p-8 shadow-lg relative">
                <span class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full">Populaire</span>
                <div class="text-sm font-medium text-blue-200 mb-2">Abonnement Cloud</div>
                <div class="text-4xl font-bold text-white mb-1">490 MAD</div>
                <div class="text-blue-200 text-sm mb-6">par mois — sans engagement</div>
                <ul class="space-y-3 mb-8">
                    @foreach(['Hébergement inclus', 'Mises à jour automatiques', 'App mobile incluse', 'Multi-utilisateurs', 'Support prioritaire 24/7'] as $item)
                    <li class="flex items-center gap-2 text-sm text-white">
                        <span class="text-yellow-400">✓</span> {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <a href="#contact" class="block text-center bg-white text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition">
                    Commencer l'essai gratuit
                </a>
            </div>

        </div>
    </div>
</section>
