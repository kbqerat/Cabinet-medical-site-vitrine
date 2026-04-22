@extends('layouts.admin')
@section('title', "Vue d'ensemble — MediAssist Admin")
@section('page-title', "Vue d'ensemble")

@section('content')

{{-- ── LIGNE 1 : Salutation ────────────────────────────────────── --}}
@php
$hour     = (int) now()->format('H');
$greeting = $hour < 12 ? 'Bonjour' : ($hour < 18 ? 'Bon après-midi' : 'Bonsoir');
@endphp
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">{{ $greeting }}, Administrateur 👋</h1>
    <p class="text-sm text-gray-400 mt-0.5">
        {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
    </p>
</div>

{{-- ── LIGNE 2 : 4 stats ───────────────────────────────────────── --}}
@php
$cards = [
    [
        'label' => 'Médecins inscrits',
        'value' => $totalDoctors,
        'sub'   => 'Total des comptes',
        'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        'color' => '#0d2150', 'light' => '#eff6ff', 'ring' => '#bfdbfe',
        'href'  => '/admin/medecins',
    ],
    [
        'label' => "En période d'essai",
        'value' => $trialDoctors,
        'sub'   => 'Essai actif',
        'icon'  => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'color' => '#d97706', 'light' => '#fffbeb', 'ring' => '#fde68a',
        'href'  => '/admin/medecins',
    ],
    [
        'label' => 'Plan Starter',
        'value' => $starterCount,
        'sub'   => 'Comptes Starter',
        'icon'  => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
        'color' => '#059669', 'light' => '#ecfdf5', 'ring' => '#a7f3d0',
        'href'  => '/admin/plans',
    ],
    [
        'label' => 'Messages reçus',
        'value' => $messageCount,
        'sub'   => 'Contact & widget',
        'icon'  => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
        'color' => '#7c3aed', 'light' => '#f5f3ff', 'ring' => '#ddd6fe',
        'href'  => '/admin/messages',
    ],
];
@endphp

<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    @foreach($cards as $c)
    <a href="{{ $c['href'] }}"
       class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 p-5 group block">
        <div class="flex items-center justify-between mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                 style="background:{{ $c['light'] }}; border:1px solid {{ $c['ring'] }}">
                <svg style="width:16px;height:16px;color:{{ $c['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $c['icon'] }}"/>
                </svg>
            </div>
            <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <p class="text-[26px] font-bold text-gray-900 leading-none mb-1">{{ $c['value'] }}</p>
        <p class="text-xs font-semibold text-gray-500 mb-0.5">{{ $c['label'] }}</p>
        <p class="text-[11px] text-gray-400">{{ $c['sub'] }}</p>
    </a>
    @endforeach
</div>

{{-- ── LIGNE 3 : Corps ─────────────────────────────────────────── --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 items-start">

    {{-- Inscriptions récentes --}}
    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden self-start">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h2 class="text-sm font-bold text-gray-900">Inscriptions récentes</h2>
                <p class="text-xs text-gray-400 mt-0.5">5 derniers médecins inscrits</p>
            </div>
            <a href="/admin/medecins"
               class="text-xs font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1 transition-colors">
                Voir tout
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if(empty($recentDoctors))
        <div class="flex flex-col items-center justify-center py-14 text-center px-6">
            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-sm text-gray-400">Aucune inscription pour le moment</p>
        </div>
        @else
        <div class="divide-y divide-gray-50">
            @foreach($recentDoctors as $d)
            @php
            $dName = trim(($d['first_name'] ?? '') . ' ' . ($d['last_name'] ?? '')) ?: ($d['email'] ?? '—');
            $dInitials = strtoupper(substr($d['first_name'] ?? $d['email'] ?? '?', 0, 1) . substr($d['last_name'] ?? '', 0, 1));
            $isPro = ($d['plan'] ?? 'starter') === 'pro';
            $isActive = $d['trial_active'] ?? false;
            @endphp
            <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-gray-50/60 transition-colors">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                    {{ $dInitials }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">Dr. {{ $dName }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $d['email'] ?? '' }}{{ $d['specialty'] ?? '' ? ' · ' . $d['specialty'] : '' }}</p>
                </div>
                <div class="flex-shrink-0 flex flex-col items-end gap-1">
                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full
                          {{ $isPro ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($isActive ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-gray-100 text-gray-500') }}">
                        {{ $isPro ? 'Pro' : ($isActive ? 'Essai' : 'Expiré') }}
                    </span>
                    <p class="text-[10px] text-gray-300">{{ $d['created_at_fmt'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Colonne droite --}}
    <div class="xl:col-span-1 space-y-5">

        {{-- Répartition plans --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-gray-900">Répartition</h2>
                <a href="/admin/plans" class="text-xs font-semibold text-gray-400 hover:text-gray-700 transition-colors">Détails →</a>
            </div>
            @php
            $total = max((int)$totalDoctors, 1);
            $sPct  = is_numeric($starterCount) ? round($starterCount / $total * 100) : 0;
            $tPct  = is_numeric($trialDoctors)  ? round($trialDoctors  / $total * 100) : 0;
            $segments = [
                ['label' => 'Starter',  'count' => $starterCount, 'pct' => $sPct, 'bar' => '#0d2150', 'bg' => 'bg-blue-50', 'text' => 'text-blue-700'],
                ['label' => 'En essai', 'count' => $trialDoctors, 'pct' => $tPct, 'bar' => '#d97706', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700'],
            ];
            @endphp
            <div class="space-y-4">
                @foreach($segments as $seg)
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs font-semibold text-gray-600">{{ $seg['label'] }}</span>
                        <span class="text-xs font-bold text-gray-800">
                            {{ $seg['count'] }}
                            <span class="font-normal text-gray-400 text-[11px]">({{ $seg['pct'] }}%)</span>
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full transition-all duration-500"
                             style="width:{{ $seg['pct'] }}%; background:{{ $seg['bar'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Accès rapides --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="text-sm font-bold text-gray-900 mb-3">Accès rapides</h2>
            @php
            $shortcuts = [
                ['href' => '/admin/medecins',   'label' => 'Médecins',    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => '#0d2150', 'bg' => '#eff6ff'],
                ['href' => '/admin/messages',   'label' => 'Messages',    'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'color' => '#7c3aed', 'bg' => '#f5f3ff'],
                ['href' => '/admin/plans',      'label' => 'Plans',       'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color' => '#059669', 'bg' => '#ecfdf5'],
                ['href' => '/admin/parametres', 'label' => 'Paramètres',  'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'color' => '#d97706', 'bg' => '#fffbeb'],
            ];
            @endphp
            <div class="grid grid-cols-2 gap-2">
                @foreach($shortcuts as $s)
                <a href="{{ $s['href'] }}"
                   class="flex flex-col items-center gap-2 p-3.5 rounded-xl border border-gray-100 hover:border-gray-200 hover:bg-gray-50 transition-all group text-center">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:{{ $s['bg'] }}">
                        <svg style="width:15px;height:15px;color:{{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-gray-600 group-hover:text-gray-900 transition-colors">{{ $s['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection
