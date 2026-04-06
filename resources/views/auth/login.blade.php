@extends('layouts.auth')
@section('title', 'Connexion médecin — MediAssist')

@section('content')
<div class="min-h-screen flex">

    {{-- Panneau gauche --}}
    <div class="hidden lg:flex lg:w-[42%] xl:w-[38%] flex-col min-h-screen relative overflow-hidden"
         style="background: linear-gradient(160deg, #0f2460 0%, #1d4ed8 50%, #4338ca 100%);">

        {{-- Motif grille --}}
        <div class="absolute inset-0"
             style="background-image: linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 40px 40px;"></div>

        {{-- Blobs décoratifs --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(99,102,241,0.35) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(59,130,246,0.3) 0%, transparent 70%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(129,140,248,0.15) 0%, transparent 70%);"></div>

        <div class="relative flex flex-col h-full min-h-screen px-10 py-10">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 w-fit group">
                <div class="w-10 h-10 bg-white/15 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20 group-hover:bg-white/20 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-[18px] font-bold text-white tracking-tight">Medi<span class="text-blue-300">Assist</span></span>
            </a>

            {{-- Contenu central --}}
            <div class="flex-1 flex flex-col justify-center py-12">

                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/15 text-blue-100 text-xs font-medium px-3.5 py-2 rounded-full mb-8 w-fit">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Espace sécurisé médecin
                </div>

                <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                    Bon retour<br>
                    <span class="text-blue-300">parmi nous</span>
                </h1>
                <p class="text-blue-200/80 text-sm leading-relaxed mb-10 max-w-xs">
                    Accédez à votre cabinet digital et gérez vos patients, rendez-vous et revenus en un seul endroit.
                </p>

                {{-- Features --}}
                <div class="space-y-5">
                    @foreach([
                        ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Agenda & rendez-vous', 'sub' => 'Planification intelligente & rappels SMS'],
                        ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Dossiers patients', 'sub' => 'Historique médical & ordonnances'],
                        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'Statistiques & revenus', 'sub' => 'Tableaux de bord en temps réel'],
                    ] as $feature)
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4.5 h-4.5 text-blue-300" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $feature['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold leading-tight">{{ $feature['title'] }}</p>
                            <p class="text-blue-300/80 text-xs mt-0.5">{{ $feature['sub'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between">
                <p class="text-white/50 text-xs">© {{ date('Y') }} MediAssist</p>
                <div class="flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-400/80"></div>
                    <span class="text-white/50 text-xs">Système opérationnel</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Panneau droit --}}
    <div class="flex-1 flex flex-col min-h-screen" style="background: #f8fafc;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 lg:px-10 py-5 border-b border-gray-100 bg-white/70 backdrop-blur-sm">
            <a href="/" class="flex items-center gap-2 text-gray-400 hover:text-gray-600 text-sm font-medium transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour au site
            </a>
            <a href="/inscription" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
                Pas de compte ?
                <span class="text-blue-600 font-semibold hover:underline ml-0.5">S'inscrire</span>
            </a>
        </div>

        {{-- Formulaire --}}
        <div class="flex-1 flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-[400px]">

                {{-- Titre --}}
                <div class="mb-8">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5"
                         style="background: linear-gradient(135deg, #dbeafe, #e0e7ff);">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-[26px] font-bold text-gray-900 leading-tight">Connexion médecin</h2>
                    <p class="text-gray-500 text-sm mt-1.5">Entrez vos identifiants pour accéder à votre espace</p>
                </div>

                {{-- Card formulaire --}}
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm shadow-gray-200/50 p-7"
                     x-data="{ showPassword: false, loading: false }">

                    <form action="/login/doctor" method="POST" @submit="loading = true">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Adresse e-mail
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" required
                                       value="{{ old('email') }}"
                                       placeholder="dr.nom@exemple.com"
                                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                            </div>
                        </div>

                        {{-- Mot de passe --}}
                        <div class="mb-7">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Mot de passe</label>
                                <a href="#" class="text-xs text-blue-500 hover:text-blue-700 font-medium transition-colors">Oublié ?</a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                       placeholder="••••••••"
                                       class="w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
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
                                class="w-full flex items-center justify-center gap-2.5 py-3.5 px-4 rounded-xl text-sm font-semibold text-white shadow-md shadow-blue-500/25 transition-all hover:shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
                                style="background: linear-gradient(135deg, #1d4ed8 0%, #4f46e5 100%);">
                            <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <svg x-show="!loading" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span x-text="loading ? 'Connexion en cours...' : 'Se connecter'">Se connecter</span>
                        </button>
                    </form>

                </div>

                {{-- CGU --}}
                <p class="text-center text-xs text-gray-400 mt-6 leading-relaxed">
                    En vous connectant, vous acceptez nos
                    <a href="/cgu" class="text-gray-500 hover:text-gray-700 underline underline-offset-2">CGU</a>
                    et notre
                    <a href="/confidentialite" class="text-gray-500 hover:text-gray-700 underline underline-offset-2">politique de confidentialité</a>.
                </p>

            </div>
        </div>
    </div>

</div>
@endsection
