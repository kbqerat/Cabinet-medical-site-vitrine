@extends('layouts.auth')
@section('title', 'Connexion administrateur — MediAssist')

@section('content')
<div class="min-h-screen flex">

    {{-- Panneau gauche --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[38%] flex-col min-h-screen relative overflow-hidden"
         style="background: linear-gradient(160deg, #0f1729 0%, #1e1b4b 50%, #312e81 100%);">

        {{-- Motif grille --}}
        <div class="absolute inset-0"
             style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px;"></div>

        {{-- Blobs --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(129,140,248,0.25) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);"></div>

        <div class="relative flex flex-col h-full min-h-screen px-10 py-10">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 w-fit group">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/15 group-hover:bg-white/15 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-[18px] font-bold text-white tracking-tight">Medi<span class="text-indigo-300">Assist</span></span>
            </a>

            {{-- Contenu central --}}
            <div class="flex-1 flex flex-col justify-center py-12">

                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/10 text-indigo-200 text-xs font-medium px-3.5 py-2 rounded-full mb-8 w-fit">
                    <svg class="w-3.5 h-3.5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Accès restreint · Administrateur
                </div>

                <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                    Tableau de<br>
                    <span class="text-indigo-300">bord admin</span>
                </h1>
                <p class="text-indigo-200/70 text-sm leading-relaxed mb-10 max-w-xs">
                    Portail réservé aux administrateurs MediAssist. Gérez les médecins, abonnements et configuration de la plateforme.
                </p>

                {{-- Accès rapide --}}
                <div class="space-y-5">
                    @foreach([
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Gestion des médecins', 'sub' => 'Abonnements, essais & accès'],
                        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'Statistiques globales', 'sub' => 'Revenus, conversions & KPIs'],
                        ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'title' => 'Configuration des plans', 'sub' => 'Prix, features & offres'],
                    ] as $feature)
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/8 border border-white/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-[18px] h-[18px] text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $feature['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold leading-tight">{{ $feature['title'] }}</p>
                            <p class="text-indigo-300/70 text-xs mt-0.5">{{ $feature['sub'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between">
                <p class="text-white/40 text-xs">© {{ date('Y') }} MediAssist</p>
                <div class="flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-400/80"></div>
                    <span class="text-white/40 text-xs">Système opérationnel</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Panneau droit --}}
    <div class="flex-1 flex flex-col min-h-screen" style="background: #f5f5f9;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 lg:px-10 py-5 border-b border-gray-100 bg-white/70 backdrop-blur-sm">
            <a href="/" class="flex items-center gap-2 text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour au site
            </a>
            <a href="/login/doctor" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">
                Vous êtes médecin ?
                <span class="text-indigo-600 font-semibold hover:underline ml-0.5">Connexion médecin →</span>
            </a>
        </div>

        {{-- Formulaire --}}
        <div class="flex-1 flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-[400px]">

                {{-- Badge --}}
                <div class="flex justify-center mb-6">
                    <div class="inline-flex items-center gap-2 text-indigo-700 bg-indigo-50 border border-indigo-200/60 text-xs font-semibold px-3.5 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Portail administrateur
                    </div>
                </div>

                {{-- Titre --}}
                <div class="mb-8 text-center">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 mx-auto"
                         style="background: linear-gradient(135deg, #e0e7ff, #ede9fe);">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-[26px] font-bold text-gray-900 leading-tight">Connexion admin</h2>
                    <p class="text-gray-500 text-sm mt-1.5">Accès réservé à l'équipe MediAssist</p>
                </div>

                {{-- Erreur --}}
                @if(session('error'))
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
                @endif

                {{-- Card formulaire --}}
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm shadow-gray-200/50 p-7"
                     x-data="{ showPassword: false, loading: false }">

                    <form action="/login/admin" method="POST" @submit="loading = true">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Adresse e-mail admin
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" required
                                       value="{{ old('email') }}"
                                       placeholder="admin@mediassist.ma"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 focus:bg-white transition-all">
                            </div>
                        </div>

                        {{-- Mot de passe --}}
                        <div class="mb-7">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                       placeholder="••••••••"
                                       class="w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 focus:bg-white transition-all">
                                <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                                    <svg x-show="!showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Bouton --}}
                        <button type="submit"
                                :disabled="loading"
                                class="w-full flex items-center justify-center gap-2.5 py-3.5 px-4 rounded-xl text-sm font-semibold text-white shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
                                style="background: linear-gradient(135deg, #312e81, #4338ca); box-shadow: 0 4px 14px rgba(67,56,202,0.3);">
                            <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <svg x-show="!loading" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span x-text="loading ? 'Connexion en cours...' : 'Accéder au dashboard'">Accéder au dashboard</span>
                        </button>
                    </form>

                </div>

                {{-- Note sécurité --}}
                <div class="flex items-center justify-center gap-2 mt-5 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Accès sécurisé · Sessions chiffrées
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
