@php
$doctorName   = 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
$pageTitle    = $doctorName
    . ($doctor->specialty ? ' — ' . $doctor->specialty : '')
    . ($doctor->city      ? ' à ' . $doctor->city      : '')
    . ' | MediAssist';
$pageDesc     = $doctor->bio
    ? str($doctor->bio)->limit(155)->__toString()
    : 'Consultez le profil de ' . $doctorName
        . ($doctor->specialty ? ', ' . $doctor->specialty : '')
        . ($doctor->city      ? ' à ' . $doctor->city      : '')
        . '. Contactez ce praticien via MediAssist.';
$canonicalUrl = url('/dr/' . $slug);
$rawPhoto     = $doctor->getRawOriginal('photo_url');
$photoUrl     = ($rawPhoto && !str_starts_with($rawPhoto, 'data:')) ? url('/photos/' . $doctor->id) : null;

$schema = [
    '@context'         => 'https://schema.org',
    '@type'            => 'Physician',
    'name'             => $doctorName,
    'url'              => $canonicalUrl,
    'description'      => $pageDesc,
    'medicalSpecialty' => $doctor->specialty ?: null,
    'address'          => [
        '@type'           => 'PostalAddress',
        'addressLocality' => $doctor->city          ?: null,
        'addressCountry'  => 'MA',
    ],
    'telephone'        => $doctor->phone            ?: null,
    'worksFor'         => $doctor->cabinet_name ? [
        '@type' => 'MedicalOrganization',
        'name'  => $doctor->cabinet_name,
    ] : null,
    'image'            => $photoUrl,
];
// Supprimer les clés null pour un JSON propre
$schema = array_filter($schema, fn($v) => $v !== null);
if (isset($schema['address'])) {
    $schema['address'] = array_filter($schema['address'], fn($v) => $v !== null);
}
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <meta property="og:site_name"   content="MediAssist">
    <meta property="og:type"        content="profile">
    <meta property="og:title"       content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url"         content="{{ $canonicalUrl }}">
    @if($photoUrl)
    <meta property="og:image"       content="{{ $photoUrl }}">
    @else
    <meta property="og:image"       content="{{ url('/og-default.png') }}">
    @endif
    <meta property="og:locale"      content="fr_MA">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image"       content="{{ $photoUrl ?? url('/og-default.png') }}">

    {{-- JSON-LD Physician --}}
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>

    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <style>[x-cloak]{display:none!important}</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background:#f1f5f9">

{{-- ── Navbar ───────────────────────────────────────────────────────────────── --}}
<nav style="background:linear-gradient(135deg,#06101f,#0d2150)">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 flex items-center justify-between h-14">
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

    <div class="relative max-w-2xl mx-auto px-4 sm:px-6 pt-14 pb-16 text-center">

        {{-- Photo --}}
        <div class="inline-block relative mb-5">
            @if($doctor->photo_url)
            <img src="{{ $doctor->photo_url }}"
                 alt="Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}"
                 class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover"
                 style="border:3px solid rgba(255,255,255,.2);box-shadow:0 8px 40px rgba(0,0,0,.35)">
            @else
            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full flex items-center justify-center text-3xl sm:text-4xl font-bold text-white"
                 style="background:rgba(255,255,255,.1);border:3px solid rgba(255,255,255,.15);box-shadow:0 8px 40px rgba(0,0,0,.3)">
                {{ strtoupper(substr($doctor->first_name ?? '', 0, 1) . substr($doctor->last_name ?? '', 0, 1)) ?: '?' }}
            </div>
            @endif
            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 whitespace-nowrap">
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full shadow-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Médecin vérifié
                </span>
            </div>
        </div>

        {{-- Nom --}}
        <h1 class="text-2xl sm:text-[1.85rem] font-bold text-white leading-tight mt-5 mb-2">
            Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
        </h1>

        {{-- Spécialité --}}
        @if($doctor->specialty)
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-semibold text-blue-200 mb-3"
             style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1)">
            <svg class="w-3.5 h-3.5 text-blue-300/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            {{ $doctor->specialty }}
        </div>
        @endif

        {{-- Cabinet · Ville --}}
        @if($doctor->cabinet_name || $doctor->city)
        <p class="text-sm text-blue-200/50 mb-8 flex items-center justify-center gap-2 flex-wrap">
            @if($doctor->cabinet_name)
            <span>{{ $doctor->cabinet_name }}</span>
            @endif
            @if($doctor->cabinet_name && $doctor->city)
            <span class="text-blue-200/20">·</span>
            @endif
            @if($doctor->city)
            <span class="inline-flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-blue-300/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $doctor->city }}
            </span>
            @endif
        </p>
        @else
        <div class="mb-8"></div>
        @endif

        {{-- CTA WhatsApp --}}
        @if($whatsappUrl)
        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2.5 font-bold text-sm px-8 py-3.5 rounded-2xl text-white transition-all duration-200 hover:-translate-y-0.5"
           style="background:linear-gradient(135deg,#25D366,#128c4a);box-shadow:0 6px 24px rgba(37,211,102,.3)">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Contacter sur WhatsApp
        </a>
        @else
        <a href="#contact"
           class="inline-flex items-center gap-2 font-bold text-sm px-8 py-3.5 rounded-2xl text-white transition-all duration-200 hover:-translate-y-0.5"
           style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15)">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Envoyer un message
        </a>
        @endif

    </div>
</div>

{{-- ── Sections ─────────────────────────────────────────────────────────────── --}}
<div class="max-w-xl mx-auto px-4 sm:px-6 py-10 space-y-4">

    {{-- Bio --}}
    @if($doctor->bio)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#eff6ff">
                <svg class="w-4 h-4" style="color:#0d2150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="text-sm font-bold text-gray-900">À propos</h2>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed">{{ $doctor->bio }}</p>
    </div>
    @endif

    {{-- Infos pratiques --}}
    @php
    $hasInfos = $doctor->cabinet_name || $doctor->city || $doctor->phone || $doctor->languages;
    $infoRows = array_values(array_filter([
        $doctor->cabinet_name ? ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'label' => 'Cabinet',   'value' => $doctor->cabinet_name, 'type' => 'text'] : null,
        $doctor->city         ? ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',               'label' => 'Ville',      'value' => $doctor->city,         'type' => 'text'] : null,
        $doctor->phone        ? ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'label' => 'Téléphone',  'value' => $doctor->phone,        'type' => 'tel']  : null,
    ]));
    @endphp
    @if($hasInfos)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#eff6ff">
                <svg class="w-4 h-4" style="color:#0d2150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-sm font-bold text-gray-900">Informations pratiques</h2>
        </div>
        <div class="space-y-0 rounded-xl border border-gray-100 overflow-hidden">
            @foreach($infoRows as $i => $row)
            <div class="flex items-center gap-3 px-4 py-3 {{ $i > 0 ? 'border-t border-gray-50' : '' }}">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#f8fafc">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $row['icon'] }}"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-400 w-20 flex-shrink-0">{{ $row['label'] }}</span>
                @if($row['type'] === 'tel')
                <a href="tel:{{ $row['value'] }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors truncate">{{ $row['value'] }}</a>
                @else
                <span class="text-sm font-medium text-gray-800 truncate">{{ $row['value'] }}</span>
                @endif
            </div>
            @endforeach
            @if($doctor->languages)
            <div class="flex items-start gap-3 px-4 py-3 {{ count($infoRows) > 0 ? 'border-t border-gray-50' : '' }}">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5" style="background:#f8fafc">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-400 w-20 flex-shrink-0 pt-1">Langues</span>
                <div class="flex flex-wrap gap-1.5">
                    @foreach(array_filter(array_map('trim', explode(',', $doctor->languages))) as $lang)
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full">{{ $lang }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Réseaux sociaux --}}
    @if($doctor->linkedin || $doctor->instagram || $doctor->facebook)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#eff6ff">
                <svg class="w-4 h-4" style="color:#0d2150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <h2 class="text-sm font-bold text-gray-900">Présence en ligne</h2>
        </div>
        <div class="space-y-2">
            @if($doctor->linkedin)
            <a href="{{ $doctor->linkedin }}" target="_blank" rel="noopener"
               class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/40 transition-all group">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#0077B5">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </div>
                <span class="text-sm font-medium text-gray-700 flex-1 group-hover:text-blue-700 transition-colors">LinkedIn</span>
                <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            @endif
            @if($doctor->instagram)
            <a href="{{ $doctor->instagram }}" target="_blank" rel="noopener"
               class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-100 hover:border-pink-200 hover:bg-pink-50/40 transition-all group">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </div>
                <span class="text-sm font-medium text-gray-700 flex-1 group-hover:text-pink-700 transition-colors">Instagram</span>
                <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            @endif
            @if($doctor->facebook)
            <a href="{{ $doctor->facebook }}" target="_blank" rel="noopener"
               class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/40 transition-all group">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#1877F2">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </div>
                <span class="text-sm font-medium text-gray-700 flex-1 group-hover:text-blue-700 transition-colors">Facebook</span>
                <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            @endif
        </div>
    </div>
    @endif

    {{-- Formulaire de contact --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" id="contact">
        <div class="flex items-center gap-2.5 mb-5">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#eff6ff">
                <svg class="w-4 h-4" style="color:#0d2150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-sm font-bold text-gray-900">Prendre contact</h2>
        </div>

        @if(session('contact_success'))
        <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-100 rounded-2xl px-5 py-4">
            <div class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-4.5 h-4.5 text-white" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-emerald-800">Message envoyé avec succès !</p>
                <p class="text-xs text-emerald-600 mt-0.5">
                    Dr. {{ $doctor->first_name }} {{ $doctor->last_name }} vous répondra dans les meilleurs délais.
                </p>
            </div>
        </div>
        @else

        @if($errors->any())
        <div class="flex items-start gap-2.5 bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-4">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-red-700">{{ $errors->first() }}</p>
        </div>
        @endif

        <form action="/dr/{{ $slug }}/contact" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                        Votre nom <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Prénom et nom"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                        Adresse e-mail <span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="votre@email.com"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-300 focus:bg-white transition-all">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                    Téléphone <span class="text-gray-300 font-normal">(optionnel)</span>
                </label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                       placeholder="+212 6 00 00 00 00"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-300 focus:bg-white transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                    Message <span class="text-red-400">*</span>
                </label>
                <textarea name="message" required rows="4"
                          placeholder="Décrivez votre demande…"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-300 focus:bg-white transition-all resize-none">{{ old('message') }}</textarea>
            </div>
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 font-bold text-sm py-3.5 rounded-2xl text-white transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-200/50"
                    style="background:linear-gradient(135deg,#0d2150,#0f3460);box-shadow:0 4px 16px rgba(13,33,80,.2)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Envoyer le message
            </button>
        </form>

        @endif
    </div>

</div>

{{-- ── Footer ───────────────────────────────────────────────────────────────── --}}
<footer class="py-8 px-4 text-center border-t border-gray-200/60 mt-4">
    <p class="text-xs text-gray-400 mb-2">
        Propulsé par
        <a href="/" class="font-semibold text-gray-600 hover:text-gray-900 transition-colors">MediAssist</a>
    </p>
    <a href="/inscription"
       class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
        Inscrivez votre cabinet sur MediAssist
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</footer>

</body>
</html>
