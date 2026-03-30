<section id="how-it-works" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-medium text-sm uppercase tracking-wide">Démarrage</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2">Comment ça marche ?</h2>
            <p class="text-gray-500 mt-4 max-w-xl mx-auto">En 3 étapes simples, votre cabinet est opérationnel.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $steps = [
                ['num' => '01', 'title' => 'Choisissez votre plan', 'desc' => 'Sélectionnez la licence unique ou l\'abonnement mensuel selon vos besoins.'],
                ['num' => '02', 'title' => 'Créez votre espace', 'desc' => 'Configurez votre cabinet, ajoutez vos médecins et votre secrétaire en quelques minutes.'],
                ['num' => '03', 'title' => 'Commencez à gérer', 'desc' => 'Ajoutez vos patients, planifiez vos rendez-vous et gérez tout depuis un seul endroit.'],
            ];
            @endphp
            @foreach($steps as $step)
            <div class="relative bg-white rounded-2xl p-8 shadow-sm">
                <div class="text-6xl font-bold text-blue-100 mb-4">{{ $step['num'] }}</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
