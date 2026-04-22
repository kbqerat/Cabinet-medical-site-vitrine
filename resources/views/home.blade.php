@extends('layouts.app')

@section('content')

@php
$isAdmin = session()->has('firebase_uid') && session('firebase_email') === env('ADMIN_EMAIL');
@endphp

@if($isAdmin)

{{-- ══════════════════════════════════════════════
     ACCUEIL ADMIN
══════════════════════════════════════════════ --}}
@php
$adminName = session('firebase_display_name') ?: explode('@', session('firebase_email', 'Admin'))[0];
$hour = (int) now()->format('H');
$greeting = $hour < 12 ? 'Bonjour' : ($hour < 18 ? 'Bon après-midi' : 'Bonsoir');
@endphp

<div class="min-h-screen pt-[70px]" style="background: #f5f5f9;">

    {{-- Hero admin --}}
    <div class="relative overflow-hidden" style="background: linear-gradient(135deg, #0f1729 0%, #1e1b4b 55%, #312e81 100%);">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 48px 48px;"></div>
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(129,140,248,0.2) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-14 lg:py-20">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 text-indigo-200 text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                        Portail administrateur
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-white mb-2">
                        {{ $greeting }}, <span class="text-indigo-300">{{ $adminName }}</span>
                    </h1>
                    <p class="text-indigo-200/70 text-sm">Gérez votre plateforme MediAssist depuis ce tableau de bord.</p>
                </div>
                <a href="/admin/dashboard"
                   class="inline-flex items-center gap-2.5 bg-white text-indigo-700 font-semibold text-sm px-5 py-3 rounded-2xl hover:bg-indigo-50 transition-colors shadow-lg shadow-indigo-900/20 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Ouvrir le dashboard
                </a>
            </div>
        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 space-y-5">

        {{-- Statut système + Plans --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Statut système --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Statut système</p>
                <div class="space-y-3.5">
                    @foreach([
                        ['label' => 'Base de données Firestore', 'ok' => true],
                        ['label' => 'Authentification Firebase',  'ok' => true],
                        ['label' => 'Envoi d\'emails',            'ok' => true],
                        ['label' => 'Certificats SSL',            'ok' => true],
                    ] as $service)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ $service['label'] }}</span>
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $service['ok'] ? 'bg-emerald-400' : 'bg-red-400' }} opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full {{ $service['ok'] ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            </span>
                            <span class="text-xs font-medium {{ $service['ok'] ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $service['ok'] ? 'Opérationnel' : 'Hors ligne' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Plans disponibles --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-5">Plans disponibles</p>
                @php
                    $pc = $planConfig ?? [];
                @endphp
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Starter', 'price' => ($pc['starter_price_monthly'] ?? 290).' MAD/mois', 'dot' => '#3b82f6'],
                        ['name' => 'Pro',     'price' => ($pc['pro_price_monthly']     ?? 490).' MAD/mois', 'dot' => '#6366f1'],
                        ['name' => 'Licence', 'price' => ($pc['licence_price']         ?? 4900).' MAD · unique', 'dot' => '#64748b'],
                    ] as $p)
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full shrink-0" style="background: {{ $p['dot'] }}"></span>
                            <span class="text-sm font-semibold text-gray-800">{{ $p['name'] }}</span>
                        </div>
                        <span class="text-sm text-gray-400">{{ $p['price'] }}</span>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 mt-4">Modifiables depuis la section Plans & tarifs.</p>
            </div>

        </div>

        {{-- Note discrète --}}
        <p class="text-xs text-gray-400 text-center pb-2">
            Page d'accueil publique visible par les visiteurs non connectés ·
            <form action="/logout" method="POST" class="inline">
                @csrf
                <input type="hidden" name="redirect" value="/">
                <button type="submit" class="text-indigo-500 hover:underline">Se déconnecter</button>
            </form>
            pour accéder à la version publique
        </p>

    </div>
</div>

@else

{{-- ══════════════════════════════════════════════
     PAGE D'ACCUEIL PUBLIQUE
══════════════════════════════════════════════ --}}
    @include('sections.hero')
    @include('sections.stats')
    @include('sections.features')
    @include('sections.how-it-works')
    @include('sections.screenshots')
    @include('sections.pricing', ['planConfig' => $planConfig])
    @include('sections.testimonials')
    @include('sections.faq')
    @include('sections.cta-banner')
    @include('components.contact')

@endif

@endsection
