@extends('layouts.doctor')
@section('title', "Vue d'ensemble — MediAssist")
@section('page-title', "Vue d'ensemble")

@section('content')
@php
$plan        = $doctor['plan'] ?? 'starter';
$isPro       = $plan === 'pro';
$trialEndsAt = isset($doctor['trial_ends_at']) ? \Carbon\Carbon::parse($doctor['trial_ends_at']) : null;
$trialActive = $trialEndsAt && $trialEndsAt->isFuture();
$daysLeft    = $trialEndsAt ? max(0, (int) now()->diffInDays($trialEndsAt, false)) : 0;
$trialTotal  = 14;
$trialPct    = $trialTotal > 0 ? min(100, round(($trialTotal - $daysLeft) / $trialTotal * 100)) : 100;
$trialEndFmt = $trialEndsAt ? $trialEndsAt->locale('fr')->isoFormat('D MMMM YYYY') : '—';
$urgency     = !$isPro && $trialActive && $daysLeft <= 3;
$fullName    = trim(($doctor['first_name'] ?? '') . ' ' . ($doctor['last_name'] ?? ''));
$specialty   = $doctor['specialty'] ?? '';
$city        = $doctor['city'] ?? '';
$cabinet     = $doctor['cabinet_name'] ?? '';
$initials    = strtoupper(substr($doctor['first_name'] ?? auth()->user()->email, 0, 1) . substr($doctor['last_name'] ?? '', 0, 1));
$hour        = (int) now()->format('H');
$greeting    = $hour < 12 ? 'Bonjour' : ($hour < 18 ? 'Bon après-midi' : 'Bonsoir');

// Complétion du profil (nécessaire avant les stats cards)
$profileSteps = [
    ['label' => 'Nom complet',  'done' => !empty($doctor['first_name']) && !empty($doctor['last_name'])],
    ['label' => 'Spécialité',   'done' => !empty($doctor['specialty'])],
    ['label' => 'Téléphone',    'done' => !empty($doctor['phone'])],
    ['label' => 'Ville',        'done' => !empty($doctor['city'])],
    ['label' => 'Cabinet',      'done' => !empty($doctor['cabinet_name'])],
    ['label' => 'Photo',        'done' => !empty($doctor['photo_url'])],
    ['label' => 'Biographie',   'done' => !empty($doctor['bio'])],
    ['label' => 'Langues',      'done' => !empty($doctor['languages'])],
];
$doneCount  = collect($profileSteps)->where('done', true)->count();
$totalCount = count($profileSteps);
$pct        = (int) round($doneCount / $totalCount * 100);
$missing    = collect($profileSteps)->where('done', false);
$barColor   = $pct >= 80 ? '#059669' : ($pct >= 50 ? '#d97706' : '#dc2626');
$bgLight    = $pct >= 80 ? '#ecfdf5' : ($pct >= 50 ? '#fffbeb' : '#fef2f2');
$borderClr  = $pct >= 80 ? '#bbf7d0' : ($pct >= 50 ? '#fde68a' : '#fecaca');
@endphp

{{-- ── LIGNE 1 : Salutation + statut abonnement ──────────────── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">
            {{ $greeting }}{{ $fullName ? ', Dr. ' . $fullName : '' }} 👋
        </h1>
        <p class="text-sm text-gray-400 mt-0.5">
            {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
        </p>
    </div>

    {{-- Badge statut --}}
    @if($isPro)
    <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-2.5 flex-shrink-0">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        <span class="text-xs font-bold text-emerald-700">Plan Pro actif</span>
    </div>
    @elseif($urgency)
    <a href="/dashboard/abonnement"
       class="flex items-center gap-2 bg-red-50 border border-red-200 rounded-xl px-4 py-2.5 flex-shrink-0 hover:bg-red-100 transition-colors">
        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
        <span class="text-xs font-bold text-red-700">Essai : {{ $daysLeft }}j restant{{ $daysLeft > 1 ? 's' : '' }}</span>
        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    @elseif($trialActive)
    <a href="/dashboard/abonnement"
       class="flex items-center gap-2 bg-blue-50 border border-blue-200 rounded-xl px-4 py-2.5 flex-shrink-0 hover:bg-blue-100 transition-colors">
        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
        <span class="text-xs font-bold text-blue-700">Essai : {{ $daysLeft }}j restants</span>
        <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    @else
    <a href="/dashboard/abonnement"
       class="flex items-center gap-2 bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 flex-shrink-0 hover:bg-gray-200 transition-colors">
        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
        <span class="text-xs font-bold text-gray-600">Essai expiré</span>
        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    @endif
</div>

{{-- ── LIGNE 2 : Stats ─────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $stats = [
        [
            'label' => 'Vues du profil',
            'value' => number_format($profileViews),
            'sub'   => 'Visites de votre vitrine',
            'icon'  => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
            'color' => '#0d2150', 'light' => '#eff6ff', 'ring' => '#bfdbfe',
            'href'  => $profileUrl,
            'blank' => true,
        ],
        [
            'label' => 'Messages reçus',
            'value' => (string)$messageCount,
            'sub'   => $messageCount > 0 ? 'Via votre vitrine' : 'Aucun message encore',
            'icon'  => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            'color' => $messageCount > 0 ? '#059669' : '#9ca3af',
            'light' => $messageCount > 0 ? '#ecfdf5' : '#f9fafb',
            'ring'  => $messageCount > 0 ? '#6ee7b7' : '#e5e7eb',
            'href'  => '#messages',
            'blank' => false,
        ],
        [
            'label' => 'Profil complété',
            'value' => $pct . '%',
            'sub'   => $pct >= 100 ? 'Tout est renseigné ✓' : ($missing->count() . ' champ' . ($missing->count() > 1 ? 's' : '') . ' manquant' . ($missing->count() > 1 ? 's' : '')),
            'icon'  => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
            'color' => $pct >= 80 ? '#059669' : ($pct >= 50 ? '#d97706' : '#dc2626'),
            'light' => $pct >= 80 ? '#ecfdf5' : ($pct >= 50 ? '#fffbeb' : '#fef2f2'),
            'ring'  => $pct >= 80 ? '#6ee7b7' : ($pct >= 50 ? '#fde68a' : '#fecaca'),
            'href'  => '/dashboard/profil',
            'blank' => false,
        ],
        [
            'label' => 'Plan actuel',
            'value' => $isPro ? 'Pro' : 'Starter',
            'sub'   => $isPro ? 'Accès complet' : ($trialActive ? $daysLeft . 'j d\'essai restants' : 'Essai expiré'),
            'icon'  => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
            'color' => $isPro ? '#059669' : ($trialActive ? '#d97706' : '#9ca3af'),
            'light' => $isPro ? '#ecfdf5' : ($trialActive ? '#fffbeb' : '#f9fafb'),
            'ring'  => $isPro ? '#6ee7b7' : ($trialActive ? '#fde68a' : '#e5e7eb'),
            'href'  => '/dashboard/abonnement',
            'blank' => false,
        ],
    ];
    @endphp

    @foreach($stats as $s)
    <a href="{{ $s['href'] }}" {{ ($s['blank'] ?? false) ? 'target="_blank"' : '' }}
       class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 p-5 group block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                 style="background:{{ $s['light'] }}; border:1px solid {{ $s['ring'] }}">
                <svg style="width:16px;height:16px;color:{{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                </svg>
            </div>
            <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <p class="text-[22px] font-bold text-gray-900 leading-none mb-1">{{ $s['value'] }}</p>
        <p class="text-xs font-semibold text-gray-500 mb-0.5">{{ $s['label'] }}</p>
        <p class="text-[11px] text-gray-400 truncate">{{ $s['sub'] }}</p>
    </a>
    @endforeach
</div>

{{-- ── BARRE DE COMPLÉTION PROFIL ──────────────────────────────── --}}
@if($pct < 100)
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div class="flex items-center gap-3">
            {{-- Badge pourcentage --}}
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 font-bold text-sm"
                 style="background:{{ $bgLight }};border:1px solid {{ $borderClr }};color:{{ $barColor }}">
                {{ $pct }}%
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Votre profil est complété à {{ $pct }}%</p>
                <p class="text-xs text-gray-400">
                    {{ $missing->count() }} élément{{ $missing->count() > 1 ? 's' : '' }} manquant{{ $missing->count() > 1 ? 's' : '' }} :
                    {{ $missing->pluck('label')->join(', ') }}
                </p>
            </div>
        </div>
        <a href="/dashboard/profil"
           class="flex-shrink-0 flex items-center gap-1.5 text-xs font-bold px-4 py-2 rounded-xl transition-opacity hover:opacity-80"
           style="background:{{ $bgLight }};color:{{ $barColor }};border:1px solid {{ $borderClr }}">
            Compléter maintenant
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Barre de progression --}}
    <div class="w-full bg-gray-100 rounded-full h-2 mb-4 overflow-hidden">
        <div class="h-2 rounded-full transition-all duration-500"
             style="width:{{ $pct }}%;background:{{ $barColor }}"></div>
    </div>

    {{-- Checklist des champs --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
        @foreach($profileSteps as $step)
        <div class="flex items-center gap-2 px-3 py-2 rounded-xl {{ $step['done'] ? 'bg-emerald-50/60' : 'bg-gray-50' }}">
            @if($step['done'])
                <div class="w-4 h-4 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-700 truncate">{{ $step['label'] }}</span>
            @else
                <div class="w-4 h-4 rounded-full border-2 border-dashed border-gray-300 flex-shrink-0"></div>
                <span class="text-xs font-medium text-gray-400 truncate">{{ $step['label'] }}</span>
            @endif
        </div>
        @endforeach
    </div>

</div>
@endif

{{-- ── LIGNE 3 : Corps principal ───────────────────────────────── --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Colonne gauche large : Abonnement + Accès rapides --}}
    <div class="xl:col-span-2 space-y-5">

        {{-- Carte abonnement --}}
        @if(!$isPro)
        <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
            <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                 style="background: linear-gradient(135deg, #0a1628 0%, #0d2150 55%, #0f3460 100%);">
                <div>
                    <p class="text-[10px] font-bold text-blue-300/60 uppercase tracking-widest mb-1">Votre abonnement</p>
                    <p class="text-base font-bold text-white mb-0.5">
                        Starter{{ $trialActive ? " — Essai en cours" : " — Essai expiré" }}
                    </p>
                    @if($trialActive)
                    <p class="text-xs text-blue-200/70">{{ $daysLeft }} jour{{ $daysLeft > 1 ? 's' : '' }} restant{{ $daysLeft > 1 ? 's' : '' }} · expire le {{ $trialEndFmt }}</p>
                    @else
                    <p class="text-xs text-blue-200/70">Passez au Pro pour continuer à utiliser MediAssist</p>
                    @endif
                </div>
                <a href="/dashboard/abonnement"
                   class="flex-shrink-0 inline-flex items-center gap-2 bg-white text-gray-900 text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-gray-100 transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    Passer au Pro
                </a>
            </div>
            @if($trialActive)
            <div class="px-6 py-3 bg-white border-t border-gray-100">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[11px] text-gray-400">Progression de l'essai</span>
                    <span class="text-[11px] font-semibold text-gray-600">Jour {{ $trialTotal - $daysLeft }} / {{ $trialTotal }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                    <div class="h-1.5 rounded-full transition-all duration-500"
                         style="width:{{ $trialPct }}%; background: linear-gradient(90deg, #0d2150, #0f3460)"></div>
                </div>
            </div>
            @endif
        </div>
        @else
        <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-200 rounded-2xl px-6 py-4">
            <div class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-4.5 h-4.5 text-white" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-emerald-800">Plan Pro — Actif</p>
                <p class="text-xs text-emerald-600 mt-0.5">Accès complet à toutes les fonctionnalités MediAssist</p>
            </div>
            <a href="/dashboard/abonnement" class="text-xs font-semibold text-emerald-700 hover:text-emerald-900 transition-colors flex-shrink-0">
                Gérer →
            </a>
        </div>
        @endif

        {{-- Accès rapides --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-bold text-gray-900">Navigation rapide</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @php
                $shortcuts = [
                    [
                        'href'  => '/dashboard/abonnement',
                        'label' => 'Mon abonnement',
                        'sub'   => 'Gérer votre plan',
                        'icon'  => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                        'color' => '#0d2150', 'light' => '#eff6ff',
                    ],
                    [
                        'href'  => '/dashboard/profil',
                        'label' => 'Mon profil',
                        'sub'   => 'Infos du cabinet',
                        'icon'  => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                        'color' => '#7c3aed', 'light' => '#f5f3ff',
                    ],
                    [
                        'href'  => '/dashboard/parametres',
                        'label' => 'Paramètres',
                        'sub'   => 'Mot de passe & notifs',
                        'icon'  => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                        'color' => '#d97706', 'light' => '#fffbeb',
                    ],
                ];
                @endphp
                @foreach($shortcuts as $s)
                <a href="{{ $s['href'] }}"
                   class="flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:bg-gray-50 transition-all group">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:{{ $s['light'] }}">
                        <svg style="width:15px;height:15px;color:{{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-gray-900 truncate">{{ $s['label'] }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $s['sub'] }}</p>
                    </div>
                    <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-gray-400 ml-auto flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Derniers messages vitrine --}}
        <div id="messages" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <h2 class="text-sm font-bold text-gray-900">Derniers messages</h2>
                    @if($messageCount > 0)
                    <span class="text-[11px] font-bold text-white px-2 py-0.5 rounded-full"
                          style="background:linear-gradient(135deg,#0d2150,#0f3460)">{{ $messageCount }}</span>
                    @endif
                </div>
                <span class="text-[11px] text-gray-400">Via votre vitrine publique</span>
            </div>

            @if($recentMessages->isEmpty())
            <div class="text-center py-10">
                <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-400 mb-1">Aucun message pour l'instant</p>
                <p class="text-xs text-gray-300">Partagez votre vitrine pour recevoir des messages de patients.</p>
                <a href="{{ $profileUrl }}" target="_blank"
                   class="inline-flex items-center gap-1.5 mt-4 text-xs font-bold text-white px-4 py-2 rounded-xl transition-opacity hover:opacity-85"
                   style="background:linear-gradient(135deg,#0d2150,#0f3460)">
                    Voir ma vitrine →
                </a>
            </div>
            @else
            <div class="space-y-3">
                @foreach($recentMessages as $msg)
                <div class="flex items-start gap-3 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:bg-gray-50/50 transition-colors group">
                    {{-- Avatar initiale --}}
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                         style="background:linear-gradient(135deg,#0d2150,#0f3460)">
                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-0.5">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $msg->name }}</p>
                            <span class="text-[10px] text-gray-400 flex-shrink-0">
                                {{ $msg->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 truncate">{{ $msg->email }}</p>
                        <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed">{{ $msg->message }}</p>
                    </div>
                    <a href="mailto:{{ $msg->email }}"
                       class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity p-1.5 rounded-lg hover:bg-gray-200"
                       title="Répondre par e-mail">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                    </a>
                </div>
                @endforeach

                @if($messageCount > 3)
                <p class="text-center text-xs text-gray-400 pt-1">
                    + {{ $messageCount - 3 }} autre{{ $messageCount - 3 > 1 ? 's' : '' }} message{{ $messageCount - 3 > 1 ? 's' : '' }}
                </p>
                @endif
            </div>
            @endif
        </div>

    </div>

    {{-- Colonne droite : vitrine + profil + support --}}
    <div class="xl:col-span-1 space-y-5">

        {{-- Carte vitrine --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5"
             x-data="{ copied: false }">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                     style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 004 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-gray-900">Votre vitrine</h2>
                    <p class="text-[10px] text-gray-400">Page publique visible par vos patients</p>
                </div>
            </div>

            <div class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-gray-50 border border-gray-100 mb-4">
                <span class="text-[11px] text-gray-500 truncate flex-1 font-mono">{{ url($profileUrl) }}</span>
                <button
                    @click="navigator.clipboard.writeText('{{ url($profileUrl) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="flex-shrink-0 p-1.5 rounded-lg hover:bg-gray-200 transition-colors"
                    title="Copier le lien">
                    <svg x-show="!copied" class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <svg x-show="copied" class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </div>

            <a href="{{ $profileUrl }}" target="_blank"
               class="w-full flex items-center justify-center gap-1.5 text-xs font-bold text-white py-2.5 rounded-xl transition-opacity hover:opacity-90"
               style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Voir ma page publique
            </a>
        </div>

        {{-- Carte profil --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            {{-- Avatar --}}
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-50">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                    {{ $initials ?: strtoupper(substr(auth()->user()->email, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">
                        {{ $fullName ? 'Dr. '.$fullName : auth()->user()->email }}
                    </p>
                    <p class="text-xs text-gray-400 truncate">{{ $specialty ?: 'Spécialité non renseignée' }}</p>
                </div>
            </div>

            <div class="space-y-2.5 mb-4">
                @foreach([
                    ['label' => 'Email',    'value' => auth()->user()->email],
                    ['label' => 'Cabinet',  'value' => $cabinet ?: '—'],
                    ['label' => 'Ville',    'value' => $city    ?: '—'],
                ] as $row)
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-gray-400 flex-shrink-0">{{ $row['label'] }}</span>
                    <span class="text-xs font-medium text-gray-700 truncate text-right">{{ $row['value'] }}</span>
                </div>
                @endforeach
            </div>

            <a href="/dashboard/profil"
               class="w-full flex items-center justify-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-xl py-2.5 transition-colors">
                Modifier mon profil
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Support --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-bold text-gray-900">Support</h2>
            </div>
            <p class="text-xs text-gray-400 leading-relaxed mb-4">
                Une question sur votre abonnement ou la plateforme ? Notre équipe répond sous 24h.
            </p>
            <a href="/#contact"
               class="w-full flex items-center justify-center gap-2 text-xs font-bold text-white py-2.5 rounded-xl transition-colors"
               style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Nous contacter
            </a>
        </div>

    </div>

</div>

@endsection
