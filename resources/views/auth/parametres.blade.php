@extends('layouts.doctor')
@section('title', 'Paramètres — MediAssist')
@section('page-title', 'Paramètres')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    {{-- Compte --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Mon compte</h2>
            <p class="text-xs text-gray-400 mt-0.5">Identifiants de connexion à la plateforme</p>
        </div>
        <div class="px-6 py-5 space-y-5">

            {{-- Email --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Adresse e-mail</label>
                <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl cursor-default select-none">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm text-gray-700 font-medium">{{ session('firebase_email') }}</span>
                    <span class="ml-auto inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full">
                        <span class="w-1 h-1 rounded-full bg-emerald-500"></span>Actif
                    </span>
                </div>
            </div>

            {{-- Changer l'adresse e-mail (collapsible) --}}
            <div x-data="{ open: false, loading: false, showPass: false }">
                <button type="button" @click="open = !open"
                        class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors group">
                    <div class="w-6 h-6 rounded-lg bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span x-text="open ? 'Annuler' : 'Changer l\'adresse e-mail'"></span>
                </button>
                <div x-show="open" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-4">
                    <form action="/dashboard/parametres/email" method="POST" @submit="loading = true">
                        @csrf
                        <div class="space-y-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="new_email" required
                                       placeholder="Nouvelle adresse e-mail"
                                       class="w-full pl-10 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input :type="showPass ? 'text' : 'password'" name="current_password" required
                                       placeholder="Mot de passe actuel (pour confirmer)"
                                       class="w-full pl-10 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                                <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                                    <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span x-text="loading ? 'Mise à jour…' : 'Changer l\'e-mail'"></span>
                            </button>
                        </div>
                    </form>
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
                    <form action="/dashboard/parametres/password" method="POST" @submit="loading = true">
                        @csrf
                        <div class="space-y-3">
                            {{-- Ancien --}}
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

    {{-- Informations du profil --}}
    <form action="/dashboard/profil" method="POST"
          x-data="{
              loading: false,
              photoPreview: null,
              photoBase64: '',
              setPhoto(e) {
                  const f = e.target.files[0];
                  if (!f) return;
                  this.photoPreview = URL.createObjectURL(f);
                  const img = new Image();
                  const reader = new FileReader();
                  reader.onload = ev => {
                      img.onload = () => {
                          const size = 300;
                          const ratio = Math.min(size / img.width, size / img.height, 1);
                          const canvas = document.createElement('canvas');
                          canvas.width  = Math.round(img.width  * ratio);
                          canvas.height = Math.round(img.height * ratio);
                          canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
                          this.photoBase64 = canvas.toDataURL('image/jpeg', 0.82);
                      };
                      img.src = ev.target.result;
                  };
                  reader.readAsDataURL(f);
              }
          }"
          @submit="loading = true">
        @csrf
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Informations personnelles</h2>
                <p class="text-xs text-gray-400 mt-0.5">Votre identité professionnelle visible sur votre profil</p>
            </div>
            <div class="px-6 py-5 space-y-4">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Prénom</label>
                        <input type="text" name="first_name" value="{{ $doctor['first_name'] ?? '' }}"
                               placeholder="Votre prénom"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nom</label>
                        <input type="text" name="last_name" value="{{ $doctor['last_name'] ?? '' }}"
                               placeholder="Votre nom"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Téléphone</label>
                    <input type="tel" name="phone" value="{{ $doctor['phone'] ?? '' }}"
                           placeholder="+212 6 00 00 00 00"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Spécialité</label>
                    <input type="text" name="specialty" value="{{ $doctor['specialty'] ?? '' }}"
                           placeholder="ex. Médecine générale, Cardiologie…"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Cabinet médical</h2>
                <p class="text-xs text-gray-400 mt-0.5">Informations sur votre lieu d'exercice</p>
            </div>
            <div class="px-6 py-5 space-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nom du cabinet</label>
                    <input type="text" name="cabinet_name" value="{{ $doctor['cabinet_name'] ?? '' }}"
                           placeholder="ex. Cabinet du Dr Dupont"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Ville</label>
                    <input type="text" name="city" value="{{ $doctor['city'] ?? '' }}"
                           placeholder="ex. Casablanca, Rabat…"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

            </div>
        </div>

        {{-- Informations supplémentaires --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Informations supplémentaires</h2>
                <p class="text-xs text-gray-400 mt-0.5">Bio, photo et présence en ligne</p>
            </div>
            <div class="px-6 py-5 space-y-5">

                {{-- Photo de profil --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Photo de profil</label>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl overflow-hidden border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center flex-shrink-0 transition-all"
                             :class="photoPreview ? 'border-blue-300' : ''">
                            <img x-show="photoPreview" :src="photoPreview" class="w-full h-full object-cover" x-cloak>
                            @if($doctor['photo_url'] ?? '')
                            <img x-show="!photoPreview" src="{{ $doctor['photo_url'] }}" class="w-full h-full object-cover">
                            @else
                            <svg x-show="!photoPreview" class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            @endif
                        </div>
                        <label class="flex-1 cursor-pointer">
                            <div class="border border-dashed border-gray-200 rounded-xl px-4 py-3 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-all">
                                @php $photoLabel = ($doctor['photo_url'] ?? '') ? 'Remplacer la photo' : 'Choisir une photo'; @endphp
                                <p class="text-xs font-semibold text-gray-500" x-text="photoPreview ? 'Changer la photo' : '{{ $photoLabel }}'"></p>
                                <p class="text-[10px] text-gray-300 mt-0.5">JPG, PNG, WEBP · max 2 Mo</p>
                            </div>
                            <input type="file" accept="image/jpeg,image/png,image/webp"
                                   class="hidden" @change="setPhoto($event)">
                        </label>
                        <input type="hidden" name="photo_base64" :value="photoBase64">
                    </div>
                </div>

                {{-- Bio --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Biographie</label>
                    <textarea name="bio" rows="3"
                              placeholder="Votre parcours, votre expérience, votre approche..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all resize-none">{{ $doctor['bio'] ?? '' }}</textarea>
                </div>

                {{-- Réseaux sociaux --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Réseaux sociaux</label>
                    <div class="space-y-2">
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50/50 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:bg-white transition-all">
                            <div class="flex items-center justify-center w-11 h-10 flex-shrink-0" style="background:#0A66C2">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </div>
                            <div class="w-px h-6 bg-gray-200 flex-shrink-0"></div>
                            <input type="url" name="linkedin" value="{{ $doctor['linkedin'] ?? '' }}" placeholder="linkedin.com/in/votre-profil"
                                   class="flex-1 bg-transparent px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none">
                        </div>
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50/50 focus-within:border-pink-400 focus-within:ring-2 focus-within:ring-pink-500/20 focus-within:bg-white transition-all">
                            <div class="flex items-center justify-center w-11 h-10 flex-shrink-0" style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </div>
                            <div class="w-px h-6 bg-gray-200 flex-shrink-0"></div>
                            <input type="url" name="instagram" value="{{ $doctor['instagram'] ?? '' }}" placeholder="instagram.com/votre-compte"
                                   class="flex-1 bg-transparent px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none">
                        </div>
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50/50 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:bg-white transition-all">
                            <div class="flex items-center justify-center w-11 h-10 flex-shrink-0" style="background:#1877F2">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div class="w-px h-6 bg-gray-200 flex-shrink-0"></div>
                            <input type="url" name="facebook" value="{{ $doctor['facebook'] ?? '' }}" placeholder="facebook.com/votre-page"
                                   class="flex-1 bg-transparent px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- Langues --}}
                @php $currentLangs = array_filter(array_map('trim', explode(',', $doctor['languages'] ?? ''))); @endphp
                <div x-data="{ selectedLangs: {{ json_encode(array_values($currentLangs)) }} }">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Langues parlées</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Arabe', 'Français', 'Anglais', 'Espagnol', 'Berbère', 'Allemand', 'Portugais', 'Italien'] as $lang)
                        <button type="button"
                                @click="selectedLangs.includes('{{ $lang }}') ? selectedLangs=selectedLangs.filter(l=>l!=='{{ $lang }}') : selectedLangs.push('{{ $lang }}')"
                                :class="selectedLangs.includes('{{ $lang }}') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-blue-300 hover:text-blue-600'"
                                class="text-xs font-medium px-3 py-1.5 rounded-full border transition-all duration-150">
                            {{ $lang }}
                        </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="languages" :value="selectedLangs.join(',')">
                </div>

            </div>
        </div>

        <div class="flex justify-end mb-5">
            <button type="submit" :disabled="loading"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-white px-6 py-3 rounded-xl shadow-sm transition-all hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none"
                    style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span x-text="loading ? 'Enregistrement…' : 'Enregistrer les modifications'"></span>
            </button>
        </div>
    </form>

    {{-- Notifications (désactivé) --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden opacity-60">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-gray-900">Notifications</h2>
                <p class="text-xs text-gray-400 mt-0.5">Choisissez les événements pour lesquels vous souhaitez être notifié</p>
            </div>
            <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full">Bientôt disponible</span>
        </div>
        <div class="divide-y divide-gray-50 pointer-events-none select-none">
            @php
            $notifs = [
                ['label' => 'Confirmation d\'abonnement', 'sub' => 'Reçois un email lors de tout changement de plan',         'default' => true],
                ['label' => 'Rappel fin d\'essai',         'sub' => 'Rappel 3 jours avant l\'expiration de votre essai',      'default' => true],
                ['label' => 'Nouvelles fonctionnalités',   'sub' => 'Sois informé des mises à jour et nouveautés MediAssist', 'default' => false],
            ];
            @endphp
            @foreach($notifs as $n)
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $n['label'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $n['sub'] }}</p>
                </div>
                <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-gray-200 flex-shrink-0 ml-4">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow translate-x-0.5"></span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Danger --}}
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden"
         x-data="{
             showModal: false,
             emailInput: '',
             passInput: '',
             loading: false,
             get canDelete() { return this.emailInput === '{{ addslashes(session('firebase_email')) }}' && this.passInput.length >= 1; }
         }">
        <div class="px-6 py-4 border-b border-red-50">
            <h2 class="text-sm font-bold text-red-700">Zone de danger</h2>
            <p class="text-xs text-red-400 mt-0.5">Ces actions sont irréversibles, procédez avec précaution</p>
        </div>
        <div class="px-6 py-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Supprimer mon compte</p>
                    <p class="text-xs text-gray-400 mt-0.5">Toutes vos données seront définitivement supprimées</p>
                </div>
                <button type="button" @click="showModal = true"
                        class="flex-shrink-0 text-xs font-semibold text-red-500 border border-red-200 hover:border-red-300 hover:bg-red-50 bg-white px-4 py-2.5 rounded-xl transition-colors ml-4">
                    Supprimer mon compte
                </button>
            </div>
        </div>

        {{-- Modal de confirmation style GitHub --}}
        <div x-show="showModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                 @click="showModal = false; emailInput = ''; passInput = ''"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-red-100 bg-red-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900">Supprimer mon compte</h3>
                    </div>
                    <button @click="showModal = false; emailInput = ''; passInput = ''"
                            class="text-gray-300 hover:text-gray-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                {{-- Body --}}
                <div class="px-6 py-5">
                    <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-5">
                        <p class="text-xs text-red-700 leading-relaxed">
                            Cette action est <strong>permanente et irréversible</strong>. Votre compte, votre profil et tous vos accès à MediAssist seront définitivement supprimés.
                        </p>
                    </div>
                    <p class="text-xs text-gray-500 mb-1.5">Pour confirmer, saisissez votre adresse e-mail :</p>
                    <p class="text-xs font-mono font-bold text-gray-800 bg-gray-100 rounded-lg px-3 py-2 mb-4 select-all">{{ session('firebase_email') }}</p>
                    <form action="/dashboard/parametres/delete" method="POST"
                          @submit.prevent="if(canDelete && !loading) { loading = true; $el.submit(); }">
                        @csrf
                        <div class="space-y-3">
                            <input type="text" name="email_confirm" x-model="emailInput"
                                   required autocomplete="off" spellcheck="false"
                                   placeholder="votre@email.com"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition-all font-mono">
                            <input type="password" name="password" x-model="passInput" required
                                   placeholder="Mot de passe"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition-all">
                        </div>
                        <div class="mt-5 flex gap-3">
                            <button type="button"
                                    @click="showModal = false; emailInput = ''; passInput = ''"
                                    class="flex-1 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 px-4 py-2.5 rounded-xl transition-colors">
                                Annuler
                            </button>
                            <button type="submit" :disabled="!canDelete || loading"
                                    :style="canDelete && !loading ? 'background:#991b1b' : 'background:#991b1b; opacity:0.4; cursor:not-allowed'"
                                    class="flex-1 inline-flex items-center justify-center gap-2 text-sm font-semibold text-white px-4 py-2.5 rounded-xl transition-all">
                                <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                <span x-text="loading ? 'Suppression…' : 'Supprimer définitivement'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
