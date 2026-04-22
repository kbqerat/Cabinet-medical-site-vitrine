<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace médecin — MediAssist')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <style>[x-cloak]{display:none!important}</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans" style="background:#f0f4f8;" x-data="{ sidebarOpen: false }">

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

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar overlay mobile --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-20 lg:hidden backdrop-blur-sm"></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-30 w-60 flex flex-col transition-transform duration-200 ease-in-out lg:sticky lg:top-0 lg:h-screen lg:translate-x-0 lg:flex flex-shrink-0"
               style="background: linear-gradient(180deg, #0a1628 0%, #0d2150 50%, #0f3460 100%);">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 px-5 py-[18px] border-b border-white/10 hover:bg-white/5 transition-colors">
                <div class="w-8 h-8 rounded-lg bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[14px] font-bold text-white tracking-tight">Medi<span class="text-blue-300">Assist</span></span>
                    <p class="text-[9px] text-blue-300/60 font-semibold uppercase tracking-widest">Espace médecin</p>
                </div>
            </a>

            {{-- Nav label --}}
            <div class="px-5 pt-5 pb-2">
                <p class="text-[9px] font-bold uppercase tracking-widest text-blue-300/40">Navigation</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 pb-4 space-y-0.5 overflow-y-auto">
                @php
                $navItems = [
                    ['href' => '/dashboard',            'icon' => 'M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2zm10 0a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1h-4a1 1 0 01-1-1v-5z', 'label' => "Vue d'ensemble"],
                    ['href' => '/dashboard/abonnement', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'label' => 'Mon abonnement'],
                    ['href' => '/dashboard/profil',     'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Mon profil'],
                    ['href' => '/dashboard/parametres', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Paramètres'],
                ];
                $currentPath = '/' . request()->path();
                @endphp

                @foreach($navItems as $item)
                @php $active = ($currentPath === $item['href']); @endphp
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
                        @php
                        $displayName = isset($doctor) && !empty($doctor['first_name'])
                            ? 'Dr. ' . $doctor['first_name'] . ' ' . ($doctor['last_name'] ?? '')
                            : 'Dr. ' . session('firebase_display_name', 'Médecin');
                        @endphp
                        <p class="text-[11px] font-semibold text-white truncate leading-tight">{{ trim($displayName) }}</p>
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
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ trim($displayName) }}</p>
                        <p class="text-[10px] text-gray-400 truncate">{{ session('firebase_email') }}</p>
                    </div>

                    <div class="py-1.5">
                        @foreach($navItems as $item)
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
                        <span class="font-semibold text-gray-800">@yield('page-title', "Vue d'ensemble")</span>
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    <div class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-gray-400">
                        {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('ddd D MMM') }}
                    </div>
                    <div class="w-px h-4 bg-gray-200 hidden sm:block"></div>
                    <div class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Connecté
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 px-5 lg:px-8 py-6 lg:py-8">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>
