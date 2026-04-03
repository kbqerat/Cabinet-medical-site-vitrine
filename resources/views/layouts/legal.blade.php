<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — MediAssist</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f8faff] text-gray-800 font-sans">

    @include('components.navbar')

    <main class="pt-16 lg:pt-[70px]">

        {{-- Hero light --}}
        <div class="relative overflow-hidden border-b border-blue-100/60" style="background: linear-gradient(135deg, #eef4ff 0%, #f5f0ff 50%, #edf9f4 100%);">

            {{-- Dot grid --}}
            <div class="absolute inset-0 pointer-events-none opacity-[0.35]"
                 style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 22px 22px;"></div>

            {{-- Soft blobs --}}
            <div class="absolute -top-16 -left-16 w-72 h-72 bg-blue-200/30 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 right-0 w-80 h-80 bg-indigo-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-0 right-1/4 w-48 h-48 bg-emerald-100/30 rounded-full blur-2xl pointer-events-none"></div>

            {{-- Decorative document icon (right side) --}}
            <div class="absolute right-8 top-1/2 -translate-y-1/2 hidden lg:block pointer-events-none select-none opacity-[0.06]">
                <svg class="w-56 h-56 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                </svg>
            </div>

            <div class="relative max-w-6xl mx-auto px-5 lg:px-8 py-10 lg:py-14">
                <a href="/" class="inline-flex items-center gap-2 text-xs text-blue-500/70 hover:text-blue-600 transition-colors mb-6 group font-medium">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour à l'accueil
                </a>
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
                    <div>
                        <div class="inline-flex items-center gap-2 mb-3">
                            <span class="bg-blue-600/10 text-blue-600 text-[11px] font-bold uppercase tracking-widest px-3 py-1 rounded-full border border-blue-200/60">
                                Document légal
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">{{ $title }}</h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 pb-0.5">
                        <span class="inline-flex items-center gap-1.5 text-[11px] text-blue-700/60 bg-white/70 border border-blue-100 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Mis à jour le {{ $updated ?? '1er avril 2026' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-700/70 bg-emerald-50/80 border border-emerald-200/60 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                            En vigueur
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="max-w-6xl mx-auto px-5 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-4 lg:gap-10 items-start">

                {{-- Sommaire sticky --}}
                <aside class="hidden lg:block lg:col-span-1">
                    <div class="sticky top-24 space-y-4">
                        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">Autres pages</p>
                            <div class="space-y-1">
                                @foreach([
                                    ['label' => 'Mentions légales',             'href' => '/mentions-legales'],
                                    ['label' => 'Politique de confidentialité', 'href' => '/confidentialite'],
                                    ['label' => "CGU",                          'href' => '/cgu'],
                                ] as $l)
                                <a href="{{ $l['href'] }}"
                                   class="flex items-center gap-2 text-xs py-1.5 px-2 rounded-lg transition-all duration-150
                                          {{ request()->is(ltrim($l['href'], '/')) ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:text-blue-600 hover:bg-blue-50' }}">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $l['label'] }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- Contenu --}}
                <article class="lg:col-span-3 bg-white border border-gray-100 rounded-3xl shadow-sm p-7 lg:p-10" id="legal-content">
                    @yield('content')

                    <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="/" class="inline-flex items-center gap-2 text-xs text-gray-400 hover:text-blue-600 transition-colors group">
                            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Retour à l'accueil
                        </a>
                        <a href="/#contact"
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl hover:scale-[1.02] transition-all duration-200 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Une question ? Contactez-nous
                        </a>
                    </div>
                </article>

            </div>
        </div>
    </main>

    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sommaire auto
            const toc = document.getElementById('toc');
            if (toc) {
                document.querySelectorAll('#legal-content h2').forEach((h, i) => {
                    h.id = 'section-' + i;
                    const a = document.createElement('a');
                    a.href = '#section-' + i;
                    a.textContent = h.textContent;
                    a.className = 'block text-xs text-gray-500 hover:text-blue-600 py-1.5 px-2 rounded-lg hover:bg-blue-50 transition-all duration-150 leading-tight';
                    a.addEventListener('click', e => {
                        e.preventDefault();
                        window.scrollTo({ top: h.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
                    });
                    toc.appendChild(a);
                });
            }
        });
    </script>

</body>
</html>
