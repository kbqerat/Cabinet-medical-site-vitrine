<section id="features" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-medium text-sm uppercase tracking-wide">Fonctionnalités</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2">Tout ce dont vous avez besoin</h2>
            <p class="text-gray-500 mt-4 max-w-xl mx-auto">Une suite complète d'outils pensés pour les médecins et leur équipe.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $features = [
                ['icon' => '👥', 'title' => 'Gestion des patients', 'desc' => 'Fiches complètes, historique médical, antécédents et allergies centralisés.'],
                ['icon' => '📅', 'title' => 'Rendez-vous', 'desc' => 'Calendrier intelligent, rappels automatiques, gestion des annulations.'],
                ['icon' => '💊', 'title' => 'Ordonnances', 'desc' => 'Générez et imprimez des ordonnances PDF directement depuis l\'application.'],
                ['icon' => '🔬', 'title' => 'Analyses médicales', 'desc' => 'Suivi des analyses, résultats et historique par patient.'],
                ['icon' => '📋', 'title' => 'Comptes rendus', 'desc' => 'Rédigez et archivez vos comptes rendus de consultation facilement.'],
                ['icon' => '💰', 'title' => 'Facturation', 'desc' => 'Générez des factures, suivez les paiements et gérez la mutuelle.'],
            ];
            @endphp
            @foreach($features as $feature)
            <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-md transition">
                <div class="text-4xl mb-4">{{ $feature['icon'] }}</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
