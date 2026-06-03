<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification identité — MediAssist</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <style>
        [x-cloak]{display:none!important}
        body { background: #f0f4f8; }
        .card-shadow { box-shadow: 0 20px 60px -10px rgba(13,33,80,.12), 0 4px 16px -4px rgba(0,0,0,.06); }
        .method-card { border: 1.5px solid #e5e7eb; transition: border-color .2s, box-shadow .2s, transform .2s; }
        .method-card:hover { transform: translateY(-2px); }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased">

{{-- Arrière-plan décoratif --}}
<div class="fixed inset-0 pointer-events-none overflow-hidden">
    <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full" style="background: radial-gradient(circle, rgba(59,130,246,.08), transparent 70%)"></div>
    <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full" style="background: radial-gradient(circle, rgba(99,102,241,.07), transparent 70%)"></div>
</div>

<div class="relative min-h-screen flex flex-col">

    {{-- Top bar --}}
    <div class="flex items-center justify-between px-6 sm:px-8 py-5 max-w-xl mx-auto w-full">
        <a href="/" class="flex items-center gap-2.5 group">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-sm" style="background: linear-gradient(135deg, #0d2150, #0f3460)">
                <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="text-base font-bold text-gray-900 tracking-tight">Medi<span style="color:#0d2150">Assist</span></span>
        </a>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-1.5 text-xs font-medium text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Déconnexion
            </button>
        </form>
    </div>

    {{-- Stepper --}}
    <div class="flex items-center justify-center gap-0 mb-7 px-4">
        @php
        $steps = [
            ['label' => 'Inscription',    'done' => true,  'active' => false],
            ['label' => 'Vérification',   'done' => false, 'active' => true],
            ['label' => 'Accès',          'done' => false, 'active' => false],
        ];
        @endphp
        @foreach($steps as $step)
        <div class="flex items-center">
            <div class="flex flex-col items-center gap-1">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold transition-all
                    {{ $step['done'] ? 'text-white' : ($step['active'] ? 'text-white' : 'bg-gray-200 text-gray-400') }}"
                     style="{{ $step['done'] ? 'background:linear-gradient(135deg,#059669,#047857)' : ($step['active'] ? 'background:linear-gradient(135deg,#0d2150,#1e40af)' : '') }}">
                    @if($step['done'])
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    @else
                    {{ $loop->iteration }}
                    @endif
                </div>
                <span class="text-[10px] font-semibold whitespace-nowrap
                    {{ $step['done'] ? 'text-emerald-600' : ($step['active'] ? 'text-gray-800' : 'text-gray-400') }}">
                    {{ $step['label'] }}
                </span>
            </div>
            @if(!$loop->last)
            <div class="w-14 sm:w-20 h-px mx-1.5 mb-3.5 transition-all"
                 style="{{ $step['done'] ? 'background:linear-gradient(to right,#059669,#d1fae5)' : 'background:#e5e7eb' }}">
            </div>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Carte principale --}}
    <div class="flex-1 flex items-start justify-center px-4 pb-14">
    <div class="w-full max-w-[500px]"
         x-data="{ method: @json($errors->any() ? 'upload' : null), uploading: false, uploaded: false }">

        <div class="bg-white rounded-3xl overflow-hidden card-shadow">

            {{-- ── Header sombre ───────────────────────────────────────── --}}
            <div class="relative overflow-hidden px-7 pt-7 pb-6"
                 style="background: linear-gradient(140deg, #06101f 0%, #0d2150 55%, #0f3460 100%)">

                {{-- Cercles décoratifs --}}
                <div class="absolute top-0 right-0 w-56 h-56 rounded-full pointer-events-none"
                     style="background: radial-gradient(circle, rgba(255,255,255,.05), transparent 65%); transform: translate(25%,-25%)"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 rounded-full pointer-events-none"
                     style="background: radial-gradient(circle, rgba(96,165,250,.06), transparent 65%); transform: translate(-30%,30%)"></div>

                <div class="relative flex items-start gap-4">
                    {{-- Icône bouclier --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                         style="background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.14); backdrop-filter:blur(8px)">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>

                    <div class="pt-0.5">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-blue-300/60 mb-1.5">
                            <span class="w-1 h-1 rounded-full bg-blue-400/70"></span>
                            Étape 2 sur 3
                        </span>
                        <h1 class="text-[1.2rem] font-bold text-white leading-snug">Vérification d'identité</h1>
                        <p class="text-sm text-blue-200/55 mt-1 leading-relaxed">
                            Confirmez votre statut de médecin pour accéder à votre espace.
                        </p>
                    </div>
                </div>

                {{-- Signaux de confiance --}}
                <div class="relative flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-5 pt-5"
                     style="border-top: 1px solid rgba(255,255,255,.08)">
                    @php
                    $trust = [
                        ['path' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'label' => 'Données chiffrées'],
                        ['path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                             'label' => 'RGPD conforme'],
                        ['path' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',                                                                'label' => 'Réponse sous 24h'],
                    ];
                    @endphp
                    @foreach($trust as $t)
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3 h-3 text-blue-400/50 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $t['path'] }}"/>
                        </svg>
                        <span class="text-[10px] font-medium text-blue-200/45 whitespace-nowrap">{{ $t['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Sélection méthode ────────────────────────────────────── --}}
            <div x-show="!method" class="px-6 py-6">

                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center mb-5">
                    Choisissez une méthode
                </p>

                <div class="space-y-3">

                    {{-- WhatsApp --}}
                    <button @click="method = 'whatsapp'"
                            class="method-card w-full group relative overflow-hidden rounded-2xl text-left bg-white hover:border-green-200 hover:shadow-lg hover:shadow-green-50">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                             style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%)"></div>
                        <div class="relative flex items-center gap-4 px-5 py-4">
                            <div class="w-13 h-13 flex-shrink-0">
                                <div class="w-13 h-13 w-12 h-12 rounded-2xl flex items-center justify-center shadow-md shadow-green-200/60 transition-transform duration-300 group-hover:scale-110"
                                     style="background: linear-gradient(135deg, #25D366, #128c4a)">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                    <p class="text-sm font-bold text-gray-900 group-hover:text-green-800 transition-colors">
                                        Nous contacter sur WhatsApp
                                    </p>
                                    <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-full leading-none">
                                        ⚡ Rapide
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    Envoyez un justificatif via WhatsApp · Réponse rapide
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-green-400 group-hover:translate-x-0.5 transition-all duration-200 flex-shrink-0"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </button>

                    {{-- Séparateur --}}
                    <div class="flex items-center gap-3 px-1">
                        <div class="flex-1 h-px bg-gray-100"></div>
                        <span class="text-[10px] font-bold text-gray-300 uppercase tracking-wider">ou</span>
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </div>

                    {{-- Upload --}}
                    <button @click="method = 'upload'"
                            class="method-card w-full group relative overflow-hidden rounded-2xl text-left bg-white hover:border-blue-200 hover:shadow-lg hover:shadow-blue-50">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                             style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%)"></div>
                        <div class="relative flex items-center gap-4 px-5 py-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md shadow-blue-200/50 transition-transform duration-300 group-hover:scale-110"
                                 style="background: linear-gradient(135deg, #0d2150, #0f3460)">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                    <p class="text-sm font-bold text-gray-900 group-hover:text-blue-800 transition-colors">
                                        Uploader mon diplôme
                                    </p>
                                    <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full leading-none">
                                        📋 24h
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    PDF, JPG ou PNG · 5 Mo max · Traitement sous 24h
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-400 group-hover:translate-x-0.5 transition-all duration-200 flex-shrink-0"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>

            {{-- ── Panel WhatsApp ───────────────────────────────────────── --}}
            <div x-show="method === 'whatsapp'" x-cloak class="px-6 py-6">

                <button @click="method = null"
                        class="flex items-center gap-1.5 text-xs font-medium text-gray-400 hover:text-gray-700 mb-5 transition-colors group">
                    <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour
                </button>

                {{-- Mockup chat WhatsApp --}}
                @php
                $doctorName  = trim(auth()->user()->first_name . ' ' . auth()->user()->last_name);
                $doctorEmail = auth()->user()->email;
                $waMsg       = "Bonjour, je suis Dr. {$doctorName} ({$doctorEmail}). Je viens de créer mon compte MediAssist et je souhaite vérifier mon profil de médecin.";
                $waUrl       = 'https://wa.me/212721667521?text=' . urlencode($waMsg);
                @endphp

                <div class="rounded-2xl overflow-hidden mb-5 shadow-md shadow-gray-200/60">
                    {{-- Barre de titre WhatsApp --}}
                    <div class="flex items-center gap-3 px-4 py-3" style="background:#075e54">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0"
                             style="background: linear-gradient(135deg,#25D366,#128c4a)">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white leading-tight">MediAssist</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                <p class="text-[10px] text-green-300/80">Répond généralement en quelques heures</p>
                            </div>
                        </div>
                    </div>
                    {{-- Fond chat --}}
                    <div class="px-4 py-4" style="background:#e5ddd5">
                        {{-- Bulle message --}}
                        <div class="flex justify-end">
                            <div class="bg-[#dcf8c6] rounded-2xl rounded-br-sm px-4 py-2.5 max-w-[88%] shadow-sm"
                                 style="border-radius: 16px 16px 4px 16px">
                                <p class="text-xs text-gray-800 leading-relaxed">{{ $waMsg }}</p>
                                <div class="flex items-center justify-end gap-1 mt-1.5">
                                    <span class="text-[9px] text-gray-400/80">maintenant</span>
                                    <svg class="w-3 h-3 text-[#4fc3f7]" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M13.435 1.566L5.48 9.523 2.565 6.61 1.15 8.024l4.33 4.33 9.37-9.37z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ $waUrl }}" target="_blank"
                   class="flex items-center justify-center gap-2.5 w-full font-bold text-sm py-3.5 rounded-2xl text-white mb-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-green-200/50"
                   style="background: linear-gradient(135deg, #25D366, #128c4a); box-shadow: 0 4px 14px rgba(37,211,102,.3)">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Ouvrir WhatsApp
                </a>

                <form action="/inscription/verification/whatsapp" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full text-sm font-semibold text-gray-500 hover:text-gray-800 py-3 rounded-2xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all">
                        J'ai envoyé mon message &rarr;
                    </button>
                </form>
            </div>

            {{-- ── Panel upload diplôme ─────────────────────────────────── --}}
            <div x-show="method === 'upload'" x-cloak class="px-6 py-6">

                <button @click="method = null"
                        class="flex items-center gap-1.5 text-xs font-medium text-gray-400 hover:text-gray-700 mb-5 transition-colors group">
                    <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour
                </button>

                @if($errors->any())
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-2xl px-4 py-3 mb-5">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                </div>
                @endif

                <form action="/inscription/verification/upload" method="POST" enctype="multipart/form-data"
                      @submit="uploading = true">
                    @csrf

                    {{-- Zone de dépôt --}}
                    <div x-show="!uploaded"
                         x-on:dragover.prevent="$el.dataset.over = '1'; $el.style.borderColor='#93c5fd'; $el.style.background='#eff6ff'"
                         x-on:dragleave.prevent="delete $el.dataset.over; $el.style.borderColor=''; $el.style.background=''"
                         x-on:drop.prevent="
                             delete $el.dataset.over; $el.style.borderColor=''; $el.style.background='';
                             const f = $event.dataTransfer.files[0];
                             if(f){ $refs.fileInput.files = $event.dataTransfer.files; uploaded = true; $refs.fileName.textContent = f.name; }
                         "
                         @click="$refs.fileInput.click()"
                         class="relative border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center cursor-pointer transition-all duration-200 hover:border-blue-300 mb-4 overflow-hidden group"
                         style="background:#fafbff">

                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                             style="background: radial-gradient(ellipse at center, rgba(219,234,254,.5) 0%, transparent 70%)"></div>

                        <div class="relative">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                                 style="background: linear-gradient(135deg, #eff6ff, #dbeafe)">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-gray-700 mb-0.5">Glissez votre fichier ici</p>
                            <p class="text-xs text-gray-400 mb-4">
                                ou <span class="text-blue-600 font-semibold">parcourir</span> depuis votre appareil
                            </p>
                            <div class="flex items-center justify-center gap-2">
                                @foreach(['PDF', 'JPG', 'PNG'] as $fmt)
                                <span class="text-[10px] font-bold text-gray-400 bg-white border border-gray-200 px-2.5 py-1 rounded-lg shadow-sm">{{ $fmt }}</span>
                                @endforeach
                                <span class="text-[10px] font-medium text-gray-300">·</span>
                                <span class="text-[10px] font-medium text-gray-400">5 Mo max</span>
                            </div>
                        </div>

                        <input x-ref="fileInput" type="file" name="diploma" accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                               @change="uploaded = $event.target.files.length > 0; $refs.fileName.textContent = $event.target.files[0]?.name ?? ''">
                    </div>

                    {{-- Fichier sélectionné --}}
                    <div x-show="uploaded" x-cloak
                         class="flex items-center gap-3 rounded-2xl px-4 py-3.5 mb-4 border border-blue-100"
                         style="background: linear-gradient(135deg, #eff6ff, #dbeafe)">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: linear-gradient(135deg, #0d2150, #1e40af)">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span x-ref="fileName" class="text-sm font-semibold text-blue-800 flex-1 truncate"></span>
                        <button type="button" @click="uploaded = false; $refs.fileInput.value = ''"
                                class="text-xs font-semibold text-blue-500 hover:text-blue-800 transition-colors px-2.5 py-1 rounded-lg hover:bg-blue-100">
                            Changer
                        </button>
                    </div>

                    <button type="submit"
                            :disabled="!uploaded || uploading"
                            class="w-full flex items-center justify-center gap-2.5 font-bold text-sm py-3.5 rounded-2xl text-white transition-all duration-200
                                   disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none disabled:hover:translate-y-0
                                   hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-200/50"
                            style="background: linear-gradient(135deg, #0d2150, #0f3460); box-shadow: 0 4px 14px rgba(13,33,80,.25)">
                        <template x-if="uploading">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </template>
                        <span x-text="uploading ? 'Envoi en cours…' : 'Soumettre mon diplôme'"></span>
                    </button>
                </form>
            </div>

        </div>

        {{-- Note confidentialité --}}
        <div class="flex items-center justify-center gap-2 mt-5">
            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <p class="text-xs text-gray-400">Vos données sont traitées de manière confidentielle et sécurisée.</p>
        </div>

    </div>
    </div>

</div>

</body>
</html>
