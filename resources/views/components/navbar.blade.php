<nav x-data="{ open: false, scrolled: false, active: '' }"
     x-init="
        window.addEventListener('scroll', () => { scrolled = window.scrollY > 30 });
     "
     :class="scrolled ? 'bg-white/95 shadow-sm border-b border-gray-200/50 backdrop-blur-xl' : 'bg-white/70 backdrop-blur-md'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[70px]">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 group">
                <div class="relative w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-blue-300 transition-shadow duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="leading-tight">
                    <span class="text-[17px] font-bold tracking-tight text-gray-900">Medi<span class="text-blue-600">Assist</span></span>
                    <p class="text-[10px] text-gray-400 font-medium tracking-wide -mt-0.5 hidden sm:block">Cabinet Médical</p>
                </div>
            </a>

            {{-- Liens desktop --}}
            <div class="hidden md:flex items-center gap-1">
                @foreach([
                    ['href' => '#features',     'label' => 'Fonctionnalités'],
                    ['href' => '#how-it-works', 'label' => 'Comment ça marche'],
                    ['href' => '#pricing',      'label' => 'Tarifs'],
                    ['href' => '#faq',          'label' => 'FAQ'],
                    ['href' => '#contact',      'label' => 'Contact'],
                ] as $link)
                <a href="{{ $link['href'] }}"
                   data-scroll
                   class="relative px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors duration-200 group rounded-lg hover:bg-blue-50/60">
                    {{ $link['label'] }}
                    <span class="absolute bottom-1 left-3 right-3 h-0.5 bg-blue-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center"></span>
                </a>
                @endforeach
            </div>

            {{-- CTA desktop --}}
            <div class="hidden md:flex items-center gap-3">
                <a href="#pricing" data-scroll
                   class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-blue-50/60">
                    Voir les tarifs
                </a>
                <a href="#contact" data-scroll
                   class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-blue-400/40 hover:shadow-lg transition-all duration-300 group">
                    <span class="relative z-10">Demander une démo</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            </div>

            {{-- Burger mobile --}}
            <button @click="open = !open"
                    class="md:hidden relative w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors duration-200"
                    aria-label="Menu">
                <svg x-show="!open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" class="w-5 h-5 text-gray-700 absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" class="w-5 h-5 text-gray-700 absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- Menu mobile --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100/80 bg-white/98 backdrop-blur-xl px-6 py-4">
        <div class="space-y-1">
            <a href="#features"     data-scroll @click="open = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-400 opacity-60"></div>
                Fonctionnalités
            </a>
            <a href="#how-it-works" data-scroll @click="open = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-400 opacity-60"></div>
                Comment ça marche
            </a>
            <a href="#pricing"      data-scroll @click="open = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-400 opacity-60"></div>
                Tarifs
            </a>
            <a href="#faq"          data-scroll @click="open = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-400 opacity-60"></div>
                FAQ
            </a>
            <a href="#contact"      data-scroll @click="open = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-400 opacity-60"></div>
                Contact
            </a>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="#contact" data-scroll @click="open = false"
               class="block bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center px-5 py-3 rounded-xl text-sm font-semibold shadow-md hover:shadow-blue-400/30 transition-all duration-300">
                Demander une démo
            </a>
        </div>
    </div>

</nav>
