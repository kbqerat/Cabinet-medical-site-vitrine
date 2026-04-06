@extends('layouts.auth')
@section('title', 'Créer un compte — MediAssist')

@section('content')
<div class="min-h-screen flex">

    {{-- Panneau gauche --}}
    <div class="hidden lg:flex lg:w-[45%] xl:w-[40%] flex-col relative overflow-hidden"
         style="background: linear-gradient(145deg, #1e3a8a 0%, #1d4ed8 40%, #4f46e5 100%);">

        {{-- Dot grid --}}
        <div class="absolute inset-0 opacity-[0.07]"
             style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

        {{-- Blobs --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col h-full px-10 py-10">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 w-fit">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-[17px] font-bold text-white tracking-tight">Medi<span class="text-blue-200">Assist</span></span>
            </a>

            {{-- Contenu central --}}
            <div class="flex-1 flex flex-col justify-center">
                <div class="mb-10">
                    <span class="inline-flex items-center gap-2 bg-white/10 text-blue-100 text-xs font-bold px-3 py-1.5 rounded-full mb-6">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                        Essai gratuit 14 jours · Sans carte bancaire
                    </span>
                    <h2 class="text-3xl font-extrabold text-white leading-tight mb-4">
                        Gérez votre cabinet<br>comme un pro.
                    </h2>
                    <p class="text-blue-200 text-sm leading-relaxed max-w-xs">
                        Rejoignez plus de 500 médecins marocains qui font confiance à MediAssist pour simplifier leur quotidien.
                    </p>
                </div>

                {{-- Avantages --}}
                <div class="space-y-4">
                    @foreach([
                        ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'text' => 'Agenda intelligent & gestion des RDV'],
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'text' => 'Dossiers patients centralisés'],
                        ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'text' => 'Ordonnances & facturation en 1 clic'],
                        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'text' => 'Statistiques & rapports détaillés'],
                    ] as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-sm text-blue-100">{{ $item['text'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Témoignage --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/10">
                <div class="flex items-center gap-1 mb-3">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-blue-100 text-xs leading-relaxed italic mb-3">
                    "MediAssist a transformé ma façon de gérer mon cabinet. Je gagne au moins 2h par jour sur les tâches administratives."
                </p>
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white text-[10px] font-bold">BK</div>
                    <div>
                        <p class="text-white text-xs font-semibold">Dr. Benali Karim</p>
                        <p class="text-blue-300 text-[10px]">Cardiologue · Oujda</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Panneau droit (formulaire) --}}
    <div class="flex-1 flex flex-col overflow-y-auto bg-[#f8faff]">

        {{-- Header desktop --}}
        <div class="hidden lg:flex items-center justify-between px-8 py-5">
            <a href="/" class="flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors font-medium group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour au site
            </a>
            <span class="text-xs text-gray-400">Déjà un compte ? <a href="/login/doctor" class="text-blue-600 font-semibold hover:underline">Se connecter</a></span>
        </div>

        {{-- Header mobile --}}
        <div class="lg:hidden flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-white">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-base font-bold text-gray-900">Medi<span class="text-blue-600">Assist</span></span>
            </a>
            <a href="/" class="text-xs text-gray-500 hover:text-gray-700 font-medium transition-colors">← Retour</a>
        </div>

        <div class="flex-1 flex flex-col items-center justify-center px-5 py-8">

            {{-- Card formulaire --}}
            <div class="w-full max-w-[480px] bg-white rounded-3xl shadow-sm shadow-gray-200/80 border border-gray-100 p-8">

            {{-- En-tête formulaire --}}
            <div class="mb-7">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 text-[11px] font-bold px-3 py-1.5 rounded-full mb-4">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                    Essai gratuit 14 jours · Sans carte bancaire
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 mb-1.5">Créer votre compte</h1>
                <p class="text-sm text-gray-400">Commencez dès maintenant, c'est gratuit.</p>
            </div>

            {{-- Formulaire --}}
            <form action="/inscription" method="POST" class="space-y-4 w-full"
                  x-data="{
                      sending: false,
                      showPass: false,
                      showPassConfirm: false,
                      password: '',
                      passwordConfirm: '',
                      get strength() {
                          if (this.password.length === 0) return 0;
                          let s = 0;
                          if (this.password.length >= 8) s++;
                          if (/[A-Z]/.test(this.password)) s++;
                          if (/[0-9]/.test(this.password)) s++;
                          if (/[^A-Za-z0-9]/.test(this.password)) s++;
                          return s;
                      },
                      get strengthLabel() {
                          return ['', 'Faible', 'Moyen', 'Bon', 'Fort'][this.strength];
                      },
                      get strengthColor() {
                          return ['', 'bg-red-400', 'bg-amber-400', 'bg-blue-400', 'bg-emerald-400'][this.strength];
                      }
                  }">

                @csrf

                {{-- Nom & Prénom --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Prénom</label>
                        <input type="text" name="first_name" placeholder="Hassan" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nom</label>
                        <input type="text" name="last_name" placeholder="Alami" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email professionnel</label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="dr.alami@cabinet.ma" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                {{-- Téléphone & Spécialité --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Téléphone</label>
                        <input type="tel" name="phone" placeholder="+212 6XX XXX XXX"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Spécialité</label>
                        <select name="specialty"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                            <option value="">Sélectionner...</option>
                            <option>Médecine générale</option>
                            <option>Cardiologie</option>
                            <option>Pédiatrie</option>
                            <option>Gynécologie</option>
                            <option>Dermatologie</option>
                            <option>Dentisterie</option>
                            <option>Ophtalmologie</option>
                            <option>Orthopédie</option>
                            <option>Neurologie</option>
                            <option>Autre</option>
                        </select>
                    </div>
                </div>

                {{-- Nom du cabinet & Ville --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nom du cabinet</label>
                        <input type="text" name="cabinet_name" placeholder="Cabinet Alami"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Ville</label>
                        <input type="text" name="city" placeholder="Oujda"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Mot de passe</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" x-model="password"
                               placeholder="Min. 8 caractères" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-10 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <button type="button" @click="showPass = !showPass"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 transition-colors">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    {{-- Indicateur de force --}}
                    <div x-show="password.length > 0" class="mt-2 space-y-1">
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 4; $i++)
                            <div class="h-1 flex-1 rounded-full transition-all duration-300"
                                 :class="strength >= {{ $i }} ? strengthColor : 'bg-gray-100'"></div>
                            @endfor
                        </div>
                        <p class="text-[11px] text-gray-400">Force : <span x-text="strengthLabel" class="font-semibold" :class="{ 'text-red-400': strength===1, 'text-amber-400': strength===2, 'text-blue-400': strength===3, 'text-emerald-500': strength===4 }"></span></p>
                    </div>
                </div>

                {{-- Confirmation mot de passe --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Confirmer le mot de passe</label>
                    <div class="relative">
                        <input :type="showPassConfirm ? 'text' : 'password'" name="password_confirmation" x-model="passwordConfirm"
                               placeholder="Répétez votre mot de passe" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-10 py-2.5 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all"
                               :class="passwordConfirm.length > 0 && password !== passwordConfirm ? 'border-red-300 focus:border-red-400 focus:ring-red-100' : ''">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <button type="button" @click="showPassConfirm = !showPassConfirm"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 transition-colors">
                            <svg x-show="!showPassConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <p x-show="passwordConfirm.length > 0 && password !== passwordConfirm"
                       class="mt-1.5 text-[11px] text-red-400">Les mots de passe ne correspondent pas.</p>
                </div>

                {{-- CGU --}}
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" name="cgu" required
                           class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 shrink-0">
                    <span class="text-xs text-gray-500 leading-relaxed">
                        J'accepte les
                        <a href="/cgu" target="_blank" class="text-blue-500 hover:underline font-medium">Conditions d'utilisation</a>
                        et la
                        <a href="/confidentialite" target="_blank" class="text-blue-500 hover:underline font-medium">Politique de confidentialité</a>
                        de MediAssist.
                    </span>
                </label>

                {{-- Bouton --}}
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 rounded-2xl text-sm font-bold shadow-sm hover:shadow-blue-500/20 hover:shadow-md hover:scale-[1.01] transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Créer mon compte gratuitement
                </button>

                {{-- Déjà un compte --}}
                <p class="text-center text-xs text-gray-400">
                    Déjà un compte ?
                    <a href="/login/doctor" class="text-blue-500 hover:text-blue-700 font-semibold transition-colors">Se connecter</a>
                </p>

            </form>
            </div>{{-- fin card --}}

        </div>
    </div>

</div>
@endsection
