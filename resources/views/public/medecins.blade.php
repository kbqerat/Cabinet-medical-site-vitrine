<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Annuaire des médecins vérifiés au Maroc — MediAssist</title>
    <meta name="description" content="Trouvez un médecin vérifié près de chez vous. Consultez les profils, spécialités et coordonnées de nos praticiens partout au Maroc.">
    <link rel="canonical" href="{{ url('/medecins') }}">

    {{-- Open Graph --}}
    <meta property="og:site_name"   content="MediAssist">
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="Annuaire des médecins vérifiés au Maroc — MediAssist">
    <meta property="og:description" content="Trouvez un médecin vérifié près de chez vous. Consultez les profils, spécialités et coordonnées de nos praticiens partout au Maroc.">
    <meta property="og:url"         content="{{ url('/medecins') }}">
    <meta property="og:image"       content="{{ url('/og-default.png') }}">
    <meta property="og:locale"      content="fr_MA">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="Annuaire des médecins vérifiés au Maroc — MediAssist">
    <meta name="twitter:description" content="Trouvez un médecin vérifié près de chez vous partout au Maroc.">
    <meta name="twitter:image"       content="{{ url('/og-default.png') }}">

    {{-- JSON-LD ItemList --}}
    <script type="application/ld+json">{!! json_encode([
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        'name'            => 'Annuaire des médecins MediAssist',
        'description'     => 'Liste des médecins vérifiés disponibles sur MediAssist au Maroc.',
        'url'             => url('/medecins'),
        'numberOfItems'   => count($doctors),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <style>[x-cloak]{display:none!important}</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background:#f1f5f9">

{{-- ── Navbar ───────────────────────────────────────────────────────────────── --}}
<nav style="background:linear-gradient(135deg,#06101f,#0d2150)">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-14">
        <a href="/" class="flex items-center gap-2 group">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(255,255,255,.12)">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="text-sm font-bold text-white tracking-tight">MediAssist</span>
        </a>
        <a href="/" class="flex items-center gap-1.5 text-xs font-medium text-blue-200/60 hover:text-white transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Accueil
        </a>
    </div>
</nav>

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<div class="relative overflow-hidden" style="background:linear-gradient(140deg,#06101f 0%,#0d2150 55%,#0f3460 100%)">
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full pointer-events-none" style="background:radial-gradient(circle,rgba(255,255,255,.04),transparent 65%);transform:translate(30%,-30%)"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full pointer-events-none" style="background:radial-gradient(circle,rgba(96,165,250,.05),transparent 65%);transform:translate(-30%,30%)"></div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-12 pb-14 text-center">
        <div class="inline-flex items-center gap-2 text-[11px] font-bold text-emerald-400 bg-emerald-400/10 border border-emerald-400/20 px-3 py-1.5 rounded-full mb-5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            {{ $doctors->count() }} médecin{{ $doctors->count() > 1 ? 's' : '' }} vérifié{{ $doctors->count() > 1 ? 's' : '' }}
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3 tracking-tight">
            Trouvez votre médecin
        </h1>
        <p class="text-sm text-blue-200/60 max-w-md mx-auto">
            Tous les praticiens listés ont été vérifiés par notre équipe.
        </p>
    </div>
</div>

{{-- ── Contenu principal ────────────────────────────────────────────────────── --}}
<script>
function medecinDirectory() {
    return {
        search: '',
        specialty: '',
        city: '',
        doctors: @json($doctors),
        get filtered() {
            const q = this.search.toLowerCase().trim();
            return this.doctors.filter(d => {
                const matchQ = !q
                    || d.name.toLowerCase().includes(q)
                    || d.specialty.toLowerCase().includes(q)
                    || d.city.toLowerCase().includes(q)
                    || d.cabinet_name.toLowerCase().includes(q);
                const matchS = !this.specialty || d.specialty === this.specialty;
                const matchC = !this.city || d.city === this.city;
                return matchQ && matchS && matchC;
            });
        }
    };
}
</script>
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8" x-data="medecinDirectory()">

    {{-- Barre de recherche + filtres --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">

            {{-- Recherche texte --}}
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Nom, spécialité, ville…"
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 bg-gray-50/50">
            </div>

            {{-- Filtre spécialité --}}
            <select x-model="specialty"
                    class="sm:w-48 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 bg-gray-50/50 text-gray-700">
                <option value="">Toutes les spécialités</option>
                @foreach($specialties as $s)
                <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
            </select>

            {{-- Filtre ville --}}
            <select x-model="city"
                    class="sm:w-44 px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 bg-gray-50/50 text-gray-700">
                <option value="">Toutes les villes</option>
                @foreach($cities as $c)
                <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>

        </div>

        {{-- Compteur de résultats --}}
        <div class="mt-3 flex items-center justify-between">
            <p class="text-xs text-gray-400">
                <span class="font-semibold text-gray-700" x-text="filtered.length"></span>
                <span x-text="filtered.length === 1 ? ' résultat' : ' résultats'"></span>
            </p>
            <button x-show="search || specialty || city"
                    @click="search=''; specialty=''; city=''"
                    class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors"
                    x-cloak>
                Réinitialiser les filtres
            </button>
        </div>
    </div>

    {{-- Grille de médecins --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        <template x-for="d in filtered" :key="d.slug">
            <a :href="'/dr/' + d.slug"
               class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-100 transition-all duration-200 overflow-hidden flex flex-col">

                {{-- Top colorée --}}
                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#0d2150,#0f3460,#1a5276)"></div>

                <div class="p-5 flex flex-col flex-1">
                    {{-- Photo + Infos --}}
                    <div class="flex items-start gap-4 mb-4">
                        {{-- Avatar --}}
                        <div class="flex-shrink-0">
                            <template x-if="d.photo_url">
                                <img :src="d.photo_url" :alt="d.name"
                                     class="w-14 h-14 rounded-xl object-cover"
                                     style="border:2px solid rgba(13,33,80,.1)">
                            </template>
                            <template x-if="!d.photo_url">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-lg font-bold text-white flex-shrink-0"
                                     style="background:linear-gradient(135deg,#0d2150,#0f3460)">
                                    <span x-text="d.initials"></span>
                                </div>
                            </template>
                        </div>

                        {{-- Nom + spécialité --}}
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-gray-900 group-hover:text-blue-900 transition-colors truncate" x-text="d.name"></p>
                            <template x-if="d.specialty">
                                <span class="inline-block mt-1 text-[11px] font-semibold px-2 py-0.5 rounded-full"
                                      style="background:rgba(13,33,80,.07);color:#0d2150"
                                      x-text="d.specialty"></span>
                            </template>
                            <template x-if="!d.specialty">
                                <span class="inline-block mt-1 text-[11px] text-gray-300 italic">Spécialité non renseignée</span>
                            </template>
                        </div>
                    </div>

                    {{-- Localisation --}}
                    <div class="space-y-1.5 mb-4 flex-1">
                        <template x-if="d.city || d.cabinet_name">
                            <div class="flex items-start gap-2">
                                <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-xs text-gray-500 leading-relaxed">
                                    <span x-text="[d.cabinet_name, d.city].filter(Boolean).join(' · ')"></span>
                                </span>
                            </div>
                        </template>

                        <template x-if="d.bio">
                            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed" x-text="d.bio"></p>
                        </template>
                    </div>

                    {{-- CTA --}}
                    <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            Médecin vérifié
                        </span>
                        <span class="flex items-center gap-1 text-xs font-semibold text-blue-700 group-hover:gap-2 transition-all">
                            Voir le profil
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </div>

            </a>
        </template>

    </div>

    {{-- État vide --}}
    <div x-show="filtered.length === 0" x-cloak class="text-center py-20">
        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-gray-500 mb-1">Aucun médecin trouvé</p>
        <p class="text-xs text-gray-400">Essayez de modifier vos critères de recherche.</p>
        <button @click="search=''; specialty=''; city=''"
                class="mt-4 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
            Voir tous les médecins
        </button>
    </div>

</div>

{{-- ── Footer ───────────────────────────────────────────────────────────────── --}}
<footer class="max-w-6xl mx-auto px-4 sm:px-6 pb-10 pt-4">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-6 border-t border-gray-200">
        <p class="text-xs text-gray-400">
            Propulsé par <a href="/" class="font-semibold text-gray-600 hover:text-gray-900 transition-colors">MediAssist</a>
        </p>
        <a href="/inscription"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-white px-4 py-2 rounded-xl transition-opacity hover:opacity-90"
           style="background:linear-gradient(135deg,#0d2150,#0f3460)">
            Inscrivez votre cabinet
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</footer>

</body>
</html>
