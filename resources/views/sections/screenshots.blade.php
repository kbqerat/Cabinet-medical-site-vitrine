<section id="screenshots" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-medium text-sm uppercase tracking-wide">Aperçu</span>
            <h2 class="text-4xl font-bold text-gray-900 mt-2">Une interface moderne et intuitive</h2>
            <p class="text-gray-500 mt-4 max-w-xl mx-auto">Conçue pour les médecins, simple à prendre en main dès le premier jour.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([['bg-blue-50', 'Dashboard', '📊'], ['bg-purple-50', 'Patients', '👥'], ['bg-green-50', 'Rendez-vous', '📅']] as $screen)
            <div class="{{ $screen[0] }} rounded-2xl p-8 text-center h-48 flex flex-col items-center justify-center">
                <div class="text-5xl mb-3">{{ $screen[2] }}</div>
                <div class="font-medium text-gray-700">{{ $screen[1] }}</div>
                <div class="text-xs text-gray-400 mt-1">Capture à venir</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
