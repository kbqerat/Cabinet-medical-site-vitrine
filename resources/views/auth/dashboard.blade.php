@extends('layouts.auth')
@section('title', 'Vue d\'ensemble — MediAssist')

@section('content')
<div class="h-screen overflow-hidden flex font-sans" style="background:#f0f4f8;" x-data="{ sidebarOpen: false }">

    {{-- Toast --}}
    @if(session('success') || session('error'))
    <div x-data="{
            show: true,
            type: '{{ session('error') ? 'error' : 'success' }}',
            message: '{{ addslashes(session('error') ?? session('success')) }}'
         }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="fixed bottom-6 right-6 z-50">
        <div :class="type === 'success' ? 'border-green-200 shadow-green-500/10' : 'border-red-200 shadow-red-500/10'"
             class="flex items-center gap-3 bg-white border rounded-2xl px-4 py-3 shadow-xl min-w-[260px]">
            <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
                 class="w-7 h-7 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg x-show="type === 'success'" class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
                <svg x-show="type === 'error'" class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5"
                   x-text="type === 'success' ? 'Succès' : 'Erreur'"></p>
                <p class="text-sm font-medium text-gray-800" x-text="message"></p>
            </div>
            <button @click="show = false" class="text-gray-300 hover:text-gray-500 transition-colors ml-1 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Overlay mobile --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-20 lg:hidden backdrop-blur-sm"></div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-60 flex flex-col transition-transform duration-200 ease-in-out lg:sticky lg:top-0 lg:h-screen lg:translate-x-0 lg:flex flex-shrink-0"
           style="background: linear-gradient(180deg, #0d1f4e 0%, #1a3a8f 55%, #3730a3 100%);">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-3 px-5 py-[18px] border-b border-white/10 hover:bg-white/5 transition-colors">
            <div class="w-8 h-8 rounded-lg bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <span class="text-[14px] font-bold text-white tracking-tight">Medi<span class="text-blue-300">Assist</span></span>
        </a>

        {{-- Nav label --}}
        <div class="px-5 pt-5 pb-2">
            <p class="text-[9px] font-bold uppercase tracking-widest text-blue-300/40">Espace médecin</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 pb-4 space-y-0.5 overflow-y-auto">
            @php
            $nav = [
                ['href' => '/dashboard',            'icon' => 'M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2zm10 0a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1h-4a1 1 0 01-1-1v-5z', 'label' => 'Vue d\'ensemble'],
                ['href' => '/dashboard/abonnement', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'label' => 'Mon abonnement'],
                ['href' => '/dashboard/profil',     'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Mon profil'],
                ['href' => '/dashboard/parametres', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Paramètres'],
            ];
            $current = '/' . request()->path();
            @endphp

            @foreach($nav as $item)
            @php $active = ($current === $item['href']); @endphp
            <a href="{{ $item['href'] }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all duration-150
                      {{ $active ? 'bg-white/[0.12] text-white' : 'text-blue-200/60 hover:bg-white/[0.07] hover:text-blue-100' }}">
                @if($active)
                <div class="w-1 h-4 rounded-full bg-blue-300 -ml-1 mr-0 flex-shrink-0"></div>
                @endif
                <svg class="flex-shrink-0" style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ $active ? '2' : '1.7' }}" d="{{ $item['icon'] }}"/>
                </svg>
                {{ $item['label'] }}
            </a>
            @endforeach
        </nav>

        {{-- User dropdown --}}
        <div class="px-3 py-3 border-t border-white/10 bg-black/10 relative"
             x-data="{ open: false }" @click.outside="open = false">

            <button @click="open = !open" type="button"
                    class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-white/10 transition-all group">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-bold text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                    {{ strtoupper(substr(session('firebase_email', 'D'), 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1 text-left">
                    <p class="text-[11px] font-semibold text-white truncate leading-tight">Dr. {{ session('firebase_display_name', 'Médecin') }}</p>
                    <p class="text-[10px] text-blue-300/60 truncate">{{ session('firebase_email') }}</p>
                </div>
                <svg class="w-3.5 h-3.5 text-blue-300/50 flex-shrink-0 transition-transform duration-200"
                     :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-cloak
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-x-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-x-2 scale-95"
                 class="absolute bottom-4 left-[calc(100%+8px)] w-52 bg-white rounded-2xl shadow-xl shadow-black/10 border border-gray-100 overflow-hidden z-50">

                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-800 truncate">Dr. {{ session('firebase_display_name', 'Médecin') }}</p>
                    <p class="text-[10px] text-gray-400 truncate">{{ session('firebase_email') }}</p>
                </div>

                <div class="py-1.5">
                    @foreach($nav as $item)
                    <a href="{{ $item['href'] }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-[13px] font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        <svg class="flex-shrink-0 text-gray-400" style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 py-1.5">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-[13px] font-medium text-red-500 hover:text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        {{-- Topbar --}}
        <header class="sticky top-0 z-10 bg-white/80 backdrop-blur-md border-b border-gray-200/60 px-5 lg:px-8 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400 font-medium">Espace médecin</span>
                    <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="font-semibold text-gray-800">Vue d'ensemble</span>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <div class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-gray-400">
                    {{ now()->isoFormat('ddd D MMM') }}
                </div>
                <div class="w-px h-4 bg-gray-200 hidden sm:block"></div>
                <div class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Connecté
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 px-5 lg:px-8 py-6 lg:py-8 space-y-5">

            {{-- Bannière abonnement --}}
            <div class="rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
                 style="background: linear-gradient(135deg, #0a1628 0%, #0d2150 55%, #0f3460 100%);">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-0.5">Plan actuel</p>
                        <p class="text-base font-bold text-white">Starter — Période d'essai</p>
                        <p class="text-xs text-blue-200/70 mt-0.5">Accès complet pendant 14 jours</p>
                    </div>
                </div>
                <a href="/dashboard/abonnement"
                   class="flex-shrink-0 inline-flex items-center gap-2 bg-white text-blue-700 text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    Passer au Pro
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                $stats = [
                    ['label' => 'Plan actuel',        'value' => 'Starter',  'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color' => '#2563eb', 'light' => '#eff6ff', 'ring' => '#bfdbfe'],
                    ['label' => "Jours d'essai",      'value' => '14',       'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => '#d97706', 'light' => '#fffbeb', 'ring' => '#fde68a'],
                    ['label' => 'Statut du compte',   'value' => 'Actif',    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => '#059669', 'light' => '#ecfdf5', 'ring' => '#a7f3d0'],
                ];
                @endphp

                @foreach($stats as $s)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow p-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background:{{ $s['light'] }}; border:1px solid {{ $s['ring'] }}">
                        <svg style="width:18px;height:18px;color:{{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                        </svg>
                    </div>
                    <p class="text-[26px] font-bold text-gray-900 leading-none mb-1.5">{{ $s['value'] }}</p>
                    <p class="text-xs text-gray-400 font-medium">{{ $s['label'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Corps --}}
            <div class="grid grid-cols-1 xl:grid-cols-5 gap-5">

                {{-- Accès rapides --}}
                <div class="xl:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-900 mb-4">Accès rapides</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @php
                        $shortcuts = [
                            ['href' => '/dashboard/abonnement', 'label' => 'Mon abonnement',   'sub' => 'Gérer votre plan',             'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color' => '#2563eb', 'light' => '#eff6ff'],
                            ['href' => '/dashboard/profil',     'label' => 'Mon profil',        'sub' => 'Infos du cabinet',            'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => '#7c3aed', 'light' => '#f5f3ff'],
                            ['href' => '/dashboard/parametres', 'label' => 'Paramètres',        'sub' => 'Mot de passe & notifs',       'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'color' => '#d97706', 'light' => '#fffbeb'],
                        ];
                        @endphp
                        @foreach($shortcuts as $s)
                        <a href="{{ $s['href'] }}"
                           class="flex flex-col gap-3 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all group">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $s['light'] }}">
                                <svg style="width:16px;height:16px;color:{{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 group-hover:text-gray-900">{{ $s['label'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $s['sub'] }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Infos compte --}}
                <div class="xl:col-span-2 space-y-4">

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h2 class="text-sm font-bold text-gray-900 mb-4">Mon compte</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Email</span>
                                <span class="text-xs font-medium text-gray-700 truncate max-w-[160px]">{{ session('firebase_email') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Plan</span>
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-full uppercase tracking-wide">
                                    <span class="w-1 h-1 rounded-full bg-amber-400"></span>Starter
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Essai</span>
                                <span class="text-xs font-semibold text-gray-700">14 jours restants</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Statut</span>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Actif
                                </span>
                            </div>
                        </div>
                        <a href="/dashboard/profil"
                           class="mt-4 w-full flex items-center justify-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 border border-blue-100 hover:border-blue-200 bg-blue-50/60 hover:bg-blue-50 rounded-xl py-2.5 transition-colors">
                            Compléter mon profil →
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h2 class="text-sm font-bold text-gray-900 mb-3">Support</h2>
                        <p class="text-xs text-gray-400 leading-relaxed mb-4">Une question sur votre abonnement ou la plateforme ? Notre équipe est disponible.</p>
                        <a href="/#contact"
                           class="w-full flex items-center justify-center gap-2 text-xs font-semibold text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-xl py-2.5 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contacter le support
                        </a>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>
@endsection
