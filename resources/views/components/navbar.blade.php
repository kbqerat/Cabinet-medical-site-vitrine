@php
$isLoggedIn  = session()->has('firebase_uid');
$isAdmin     = $isLoggedIn && session('firebase_email') === env('ADMIN_EMAIL');
$userEmail   = session('firebase_email', '');
$displayName = session('firebase_display_name', '');
$initials    = $displayName
    ? collect(explode(' ', $displayName))->take(2)->map(fn($w) => strtoupper($w[0]))->implode('')
    : strtoupper(substr($userEmail, 0, 1));
$shortName   = $displayName ?: explode('@', $userEmail)[0];
$dashUrl     = $isAdmin ? '/admin/dashboard' : '/dashboard';
$roleBadge   = $isAdmin ? 'Admin' : 'Médecin';
$roleColor   = $isAdmin
    ? 'bg-indigo-100 text-indigo-700 border-indigo-200'
    : 'bg-blue-100 text-blue-700 border-blue-200';
$avatarBg    = $isAdmin
    ? 'background: linear-gradient(135deg, #312e81, #4338ca)'
    : 'background: linear-gradient(135deg, #0f2460, #1d4ed8)';
@endphp

<nav x-data="{ open: false, scrolled: false, loginOpen: false, profileOpen: false, mobileLogin: false, mobileProfile: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 30 })"
     @click.outside="loginOpen = false; profileOpen = false"
     :class="scrolled ? 'bg-white/95 shadow-sm backdrop-blur-xl' : 'bg-transparent'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">

    <div class="max-w-7xl mx-auto px-6 lg:px-8" style="touch-action: none">
        <div class="flex items-center justify-between h-16 lg:h-[70px]">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 group shrink-0">
                <div class="relative w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-blue-300 transition-shadow duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="leading-tight">
                    <span class="text-[17px] font-bold tracking-tight text-gray-900">Medi<span class="text-blue-600">Assist</span></span>
                    <p class="text-[10px] text-gray-400 font-medium tracking-wide -mt-0.5 hidden sm:block">Cabinet Médical</p>
                </div>
            </a>

            {{-- Liens desktop --}}
            <div class="hidden lg:flex items-center gap-1">
                @if($isAdmin)
                    @foreach([
                        ['href' => '/admin/dashboard', 'label' => 'Dashboard'],
                        ['href' => '/admin/medecins',  'label' => 'Médecins'],
                        ['href' => '/admin/plans',     'label' => 'Plans & tarifs'],
                        ['href' => '/admin/messages',  'label' => 'Messages'],
                        ['href' => '/admin/parametres','label' => 'Paramètres'],
                    ] as $link)
                    <a href="{{ $link['href'] }}"
                       class="relative px-3 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors duration-200 group rounded-lg hover:bg-indigo-50/60">
                        {{ $link['label'] }}
                        <span class="absolute bottom-1 left-3 right-3 h-0.5 bg-indigo-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center"></span>
                    </a>
                    @endforeach
                @else
                    @foreach([
                        ['href' => '#features',     'label' => 'Fonctionnalités'],
                        ['href' => '#how-it-works', 'label' => 'Comment ça marche'],
                        ['href' => '#pricing',      'label' => 'Tarifs'],
                        ['href' => '#faq',          'label' => 'FAQ'],
                        ['href' => '#contact',      'label' => 'Contact'],
                    ] as $link)
                    <a href="{{ $link['href'] }}" data-scroll
                       class="relative px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors duration-200 group rounded-lg hover:bg-blue-50/60">
                        {{ $link['label'] }}
                        <span class="absolute bottom-1 left-3 right-3 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center"></span>
                    </a>
                    @endforeach
                @endif
            </div>

            {{-- Actions desktop --}}
            <div class="hidden md:flex items-center gap-2">

                @if($isLoggedIn)
                {{-- ── PROFIL connecté ── --}}
                <div class="relative">
                    <button @click="profileOpen = !profileOpen"
                            class="flex items-center gap-2.5 border rounded-xl px-2 py-1.5 pr-3.5 transition-all duration-200"
                            :class="profileOpen
                                ? '{{ $isAdmin ? 'bg-indigo-50 border-indigo-200' : 'bg-blue-50 border-blue-200' }}'
                                : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
                        {{-- Avatar --}}
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0"
                             style="{{ $avatarBg }}">
                            {{ $initials }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 max-w-[100px] truncate">{{ $shortName }}</span>
                        <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown profil --}}
                    <div x-cloak x-show="profileOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                         class="absolute right-0 top-[calc(100%+8px)] w-68 bg-white rounded-2xl shadow-sm shadow-gray-200/40 border border-gray-100 overflow-hidden z-50" style="width:272px">

                        {{-- Header profil --}}
                        <div class="px-4 py-4 border-b border-gray-100 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-bold shrink-0"
                                 style="{{ $avatarBg }}">
                                {{ $initials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $shortName }}</div>
                                <div class="text-xs text-gray-400 truncate">{{ $userEmail }}</div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $roleColor }} shrink-0">
                                {{ $roleBadge }}
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="p-2">
                            <a href="{{ $dashUrl }}" @click="profileOpen = false"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors duration-150 group">
                                <div class="w-8 h-8 rounded-lg {{ $isAdmin ? 'bg-indigo-50' : 'bg-blue-50' }} flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 {{ $isAdmin ? 'text-indigo-500' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($isAdmin)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-800">Mon dashboard</div>
                                    <div class="text-xs text-gray-400">{{ $isAdmin ? 'Espace administration' : 'Espace médecin' }}</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Déconnexion --}}
                        <div class="border-t border-gray-100 p-2">
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 transition-colors duration-150 group text-left">
                                    <div class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center shrink-0 transition-colors">
                                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-600 group-hover:text-red-600 transition-colors">Se déconnecter</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @else
                {{-- ── Non connecté : dropdown login ── --}}
                <div class="relative">
                    <button @click="loginOpen = !loginOpen"
                            :class="loginOpen ? 'bg-blue-50 text-blue-600 border-blue-200' : 'text-gray-700 border-gray-200 hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50/60'"
                            class="flex items-center gap-2 border rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Se connecter
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="loginOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-cloak x-show="loginOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                         class="absolute right-0 top-[calc(100%+8px)] w-64 bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden z-50">

                        <div class="px-3 pt-3 pb-1">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 px-1 mb-2">Connexion</p>
                        </div>
                        <div class="px-2 pb-2 space-y-1">
                            <a href="/login/doctor"
                               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-blue-50 transition-colors duration-150 group">
                                <div class="w-9 h-9 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center transition-colors duration-150 shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-800 group-hover:text-blue-700 transition-colors">Connexion médecin</div>
                                    <div class="text-xs text-gray-400">Accéder à votre cabinet</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-400 ml-auto transition-all duration-150 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="/login/admin"
                               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-indigo-50 transition-colors duration-150 group">
                                <div class="w-9 h-9 bg-indigo-100 group-hover:bg-indigo-200 rounded-xl flex items-center justify-center transition-colors duration-150 shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-800 group-hover:text-indigo-700 transition-colors">Connexion admin</div>
                                    <div class="text-xs text-gray-400">Accès administrateur</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-400 ml-auto transition-all duration-150 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        <div class="border-t border-gray-100 px-4 py-3 bg-gray-50/60 flex items-center justify-between">
                            <p class="text-xs text-gray-400">Pas encore de compte ?</p>
                            <a href="/inscription" @click="loginOpen = false" class="text-xs text-blue-600 font-semibold hover:underline">S'inscrire →</a>
                        </div>
                    </div>
                </div>
                @endif

                {{-- CTA principal (masqué pour l'admin connecté) --}}
                @if(!$isAdmin)
                <a href="#contact" data-scroll
                   class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-blue-400/30 hover:scale-[1.02] active:scale-100 transition-all duration-300 group">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <span class="relative z-10">Demander une démo</span>
                </a>
                @endif
            </div>

            {{-- Boutons mobile --}}
            <div class="md:hidden flex items-center gap-2">

                @if($isLoggedIn)
                {{-- Avatar mobile --}}
                <button @click="mobileProfile = !mobileProfile; open = false"
                        class="flex items-center gap-2 border rounded-xl px-2 py-1.5 pr-3 transition-all duration-200"
                        :class="mobileProfile ? '{{ $isAdmin ? 'border-indigo-200 bg-indigo-50' : 'border-blue-200 bg-blue-50' }}' : 'border-gray-200 bg-white'">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold"
                         style="{{ $avatarBg }}">
                        {{ $initials }}
                    </div>
                    <svg class="w-3 h-3 text-gray-400 transition-transform duration-200" :class="mobileProfile ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                @else
                {{-- Connexion mobile --}}
                <button @click="mobileLogin = !mobileLogin; open = false"
                        :class="mobileLogin ? 'bg-blue-600 text-white border-blue-600' : 'text-blue-600 border-blue-200 bg-blue-50'"
                        class="flex items-center gap-1.5 text-xs font-semibold border px-3 py-1.5 rounded-lg transition-colors duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Connexion
                </button>
                @endif

                {{-- Burger --}}
                <button @click="open = !open; mobileLogin = false; mobileProfile = false"
                        class="relative w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors duration-200"
                        aria-label="Menu">
                    <svg x-show="!open" class="w-5 h-5 text-gray-700 absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5 text-gray-700 absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Panel nav mobile (burger) --}}
    <div x-cloak x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100/60 bg-white/98 backdrop-blur-xl px-4 pt-3 pb-5 overscroll-contain" style="touch-action: none">

        <div class="space-y-0.5">
            @foreach([
                ['href' => '#features',     'label' => 'Fonctionnalités',    'icon' => 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18'],
                ['href' => '#how-it-works', 'label' => 'Comment ça marche',  'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                ['href' => '#pricing',      'label' => 'Tarifs',             'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['href' => '#faq',          'label' => 'FAQ',                'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['href' => '#contact',      'label' => 'Contact',            'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ] as $link)
            <a href="{{ $link['href'] }}" data-scroll @click="open = false"
               class="flex items-center gap-4 px-3 py-3 rounded-2xl text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50/70 active:bg-blue-100/60 transition-all duration-150 group">
                <div class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center shrink-0 transition-colors duration-150">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $link['icon'] }}"/>
                    </svg>
                </div>
                <span>{{ $link['label'] }}</span>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-400 ml-auto transition-all duration-150 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endforeach
        </div>

        <div class="mt-3 pt-3 border-t border-gray-100">
            <a href="#contact" data-scroll @click="open = false"
               class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-3 rounded-2xl text-sm font-semibold">
                Demander une démo
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>

    @if($isLoggedIn)
    {{-- Panel profil mobile --}}
    <div x-cloak x-show="mobileProfile"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100/80 bg-white backdrop-blur-xl px-5 py-5 overscroll-contain" style="touch-action: none">

        {{-- Info utilisateur --}}
        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-base font-bold shrink-0"
                 style="{{ $avatarBg }}">
                {{ $initials }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-bold text-gray-900 truncate">{{ $shortName }}</div>
                <div class="text-xs text-gray-400 truncate">{{ $userEmail }}</div>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $roleColor }} shrink-0">
                {{ $roleBadge }}
            </span>
        </div>

        {{-- Mon dashboard --}}
        <a href="{{ $dashUrl }}" @click="mobileProfile = false"
           class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl border {{ $isAdmin ? 'border-indigo-100 bg-indigo-50/60 hover:bg-indigo-100/60' : 'border-blue-100 bg-blue-50/60 hover:bg-blue-100/60' }} transition-colors duration-150 group mb-2">
            <div class="w-10 h-10 {{ $isAdmin ? 'bg-indigo-100' : 'bg-blue-100' }} rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 {{ $isAdmin ? 'text-indigo-600' : 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($isAdmin)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    @endif
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-sm font-semibold text-gray-800">Mon dashboard</div>
                <div class="text-xs text-gray-400">{{ $isAdmin ? 'Espace administration' : 'Espace médecin' }}</div>
            </div>
            <svg class="w-4 h-4 {{ $isAdmin ? 'text-indigo-300' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        {{-- Déconnexion --}}
        <form action="/logout" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3.5 px-4 py-3.5 rounded-2xl border border-red-100 bg-red-50/60 hover:bg-red-100/60 transition-colors duration-150 text-left">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-red-600">Se déconnecter</span>
            </button>
        </form>
    </div>

    @else
    {{-- Panel connexion mobile --}}
    <div x-cloak x-show="mobileLogin"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100/80 bg-white backdrop-blur-xl px-5 py-5 overscroll-contain" style="touch-action: none">

        <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-3">Connexion</p>

        <div class="space-y-2.5">
            <a href="/login/doctor" @click="mobileLogin = false"
               class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl border border-blue-100 bg-blue-50/60 hover:bg-blue-100/60 transition-colors duration-150 group">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-semibold text-gray-800">Connexion médecin</div>
                    <div class="text-xs text-gray-400">Accéder à votre cabinet</div>
                </div>
                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="/login/admin" @click="mobileLogin = false"
               class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl border border-indigo-100 bg-indigo-50/60 hover:bg-indigo-100/60 transition-colors duration-150 group">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-semibold text-gray-800">Connexion admin</div>
                    <div class="text-xs text-gray-400">Accès administrateur</div>
                </div>
                <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="flex items-center justify-between mt-4">
            <p class="text-xs text-gray-400">Pas encore de compte ?</p>
            <a href="/inscription" @click="mobileLogin = false" class="text-xs text-blue-600 font-semibold">S'inscrire →</a>
        </div>
    </div>
    @endif

</nav>
