<section id="faq" class="py-24 bg-gray-50">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-medium text-sm uppercase tracking-wide">FAQ</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2">Questions fréquentes</h2>
        </div>
        <div class="space-y-4">
            @php
            $faqs = [
                ['q' => 'Quelle est la différence entre la licence et l\'abonnement ?', 'a' => 'La licence est un paiement unique qui vous donne accès au logiciel installé sur votre propre serveur. L\'abonnement cloud vous donne accès à une version hébergée avec mises à jour automatiques et app mobile incluse.'],
                ['q' => 'Mes données sont-elles sécurisées ?', 'a' => 'Oui, toutes les données sont chiffrées et stockées de manière sécurisée. Nous sommes conformes aux standards de sécurité médicale.'],
                ['q' => 'Puis-je essayer avant d\'acheter ?', 'a' => 'Oui, nous offrons un essai gratuit de 14 jours sans carte bancaire pour l\'abonnement cloud.'],
                ['q' => 'L\'application mobile est-elle incluse ?', 'a' => 'L\'app mobile est incluse dans l\'abonnement cloud. Pour la licence, elle est disponible en option.'],
            ];
            @endphp
            @foreach($faqs as $faq)
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h4 class="font-semibold text-gray-900 mb-2">{{ $faq['q'] }}</h4>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $faq['a'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
