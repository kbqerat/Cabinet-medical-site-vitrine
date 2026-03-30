<section id="testimonials" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-medium text-sm uppercase tracking-wide">Témoignages</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2">Ils nous font confiance</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $testimonials = [
                ['name' => 'Dr. Alami Hassan', 'role' => 'Médecin généraliste, Oujda', 'text' => 'MediAssist a transformé la gestion de mon cabinet. Je gagne plus de 2 heures par jour.'],
                ['name' => 'Dr. Bennani Sara', 'role' => 'Pédiatre, Casablanca', 'text' => 'Interface simple et intuitive. Mes secrétaires ont été opérationnelles en moins d\'une journée.'],
                ['name' => 'Dr. Karimi Youssef', 'role' => 'Cardiologue, Rabat', 'text' => 'Le suivi des analyses et comptes rendus est excellent. Je recommande vivement.'],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="bg-gray-50 rounded-2xl p-6">
                <div class="text-yellow-400 text-lg mb-4">★★★★★</div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">{{ $t['name'] }}</div>
                    <div class="text-gray-400 text-xs">{{ $t['role'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
