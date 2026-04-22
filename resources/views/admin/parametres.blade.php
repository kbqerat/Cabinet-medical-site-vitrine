@extends('layouts.admin')
@section('title', 'Paramètres — MediAssist Admin')
@section('page-title', 'Paramètres')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    {{-- Compte administrateur --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Compte administrateur</h2>
            <p class="text-xs text-gray-400 mt-0.5">Identifiants de connexion à la plateforme</p>
        </div>
        <div class="px-6 py-5 space-y-5">

            {{-- Email --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Adresse e-mail</label>
                <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl cursor-default select-none">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm text-gray-700 font-medium">{{ env('ADMIN_EMAIL') }}</span>
                    <span class="ml-auto inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full">
                        <span class="w-1 h-1 rounded-full bg-emerald-500"></span>Actif
                    </span>
                </div>
            </div>

            {{-- Changer mot de passe (collapsible) --}}
            <div x-data="{ open: false, loading: false, show0: false, show1: false, show2: false }">
                <button type="button" @click="open = !open"
                        class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors group">
                    <div class="w-6 h-6 rounded-lg bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span x-text="open ? 'Annuler' : 'Changer le mot de passe'"></span>
                </button>

                <div x-show="open" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-4">
                    <form action="/admin/parametres/password" method="POST" @submit="loading = true">
                        @csrf
                        <div class="space-y-3">
                            {{-- Ancien mot de passe --}}
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input :type="show0 ? 'text' : 'password'" name="current_password" required
                                       placeholder="Mot de passe actuel"
                                       class="w-full pl-10 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                                <button type="button" @click="show0 = !show0" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                                    <svg x-show="!show0" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show0" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            {{-- Nouveau --}}
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <input :type="show1 ? 'text' : 'password'" name="password" required minlength="8"
                                       placeholder="Nouveau mot de passe (min. 8 caractères)"
                                       class="w-full pl-10 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                                <button type="button" @click="show1 = !show1" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                                    <svg x-show="!show1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show1" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            {{-- Confirmation --}}
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <input :type="show2 ? 'text' : 'password'" name="password_confirmation" required minlength="8"
                                       placeholder="Confirmer le nouveau mot de passe"
                                       class="w-full pl-10 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                                <button type="button" @click="show2 = !show2" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                                    <svg x-show="!show2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show2" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" :disabled="loading"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-white px-5 py-2.5 rounded-xl shadow-sm transition-all hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none"
                                    style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                                <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span x-text="loading ? 'Mise à jour…' : 'Mettre à jour le mot de passe'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Notifications --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Notifications</h2>
            <p class="text-xs text-gray-400 mt-0.5">Choisissez les événements pour lesquels vous souhaitez être notifié</p>
        </div>
        <div class="divide-y divide-gray-50">
            @php
            $notifs = [
                ['label' => 'Nouvelle inscription médecin', 'sub' => 'Reçois un email à chaque nouveau compte créé',      'default' => true],
                ['label' => 'Nouveau message de contact',   'sub' => 'Reçois un email à chaque soumission de formulaire', 'default' => true],
                ['label' => 'Essai expiré',                 'sub' => 'Rappel quand un médecin passe en essai expiré',      'default' => false],
            ];
            @endphp
            @foreach($notifs as $n)
            <div class="flex items-center justify-between px-6 py-4" x-data="{ on: {{ $n['default'] ? 'true' : 'false' }} }">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $n['label'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $n['sub'] }}</p>
                </div>
                <button @click="on = !on" type="button"
                        :class="on ? 'bg-blue-600' : 'bg-gray-200'"
                        class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors duration-200 focus:outline-none flex-shrink-0 ml-4">
                    <span :class="on ? 'translate-x-4' : 'translate-x-0.5'"
                          class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200"></span>
                </button>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Période d'essai --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Période d'essai</h2>
            <p class="text-xs text-gray-400 mt-0.5">Durée accordée aux nouveaux médecins lors de l'inscription</p>
        </div>
        <div class="px-6 py-5">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 flex-1 max-w-xs">
                    <input type="number" value="14" min="1" max="90"
                           class="w-24 text-center text-lg font-bold text-gray-900 border border-gray-200 rounded-xl py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 bg-gray-50 transition-all">
                    <span class="text-sm text-gray-500 font-medium">jours d'essai gratuit</span>
                </div>
                <button type="button"
                        class="text-xs font-semibold text-blue-600 border border-blue-200 bg-blue-50 hover:bg-blue-100 px-4 py-2.5 rounded-xl transition-colors">
                    Enregistrer
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-3">Les nouveaux inscrits bénéficient de <strong class="text-gray-600">14 jours</strong> d'accès gratuit au plan Starter.</p>
        </div>
    </div>

</div>
@endsection
