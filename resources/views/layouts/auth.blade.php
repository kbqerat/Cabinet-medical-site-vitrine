<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MediAssist')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <style>[x-cloak]{display:none!important}</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 font-sans min-h-screen">

    {{-- Toast notifications --}}
    @if(session('success') || session('error'))
    <div x-data="{
            show: true,
            type: '{{ session('error') ? 'error' : 'success' }}',
            message: '{{ addslashes(session('error') ?? session('success')) }}'
         }"
         x-init="setTimeout(() => show = false, 3500)"
         x-show="show"
         x-cloak
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
         class="fixed top-4 left-1/2 -translate-x-1/2 z-50">
        <div :class="type === 'success'
                ? 'border-green-200/60 shadow-green-500/8'
                : 'border-red-200/60 shadow-red-500/8'"
             class="flex items-center gap-2.5 bg-white/90 backdrop-blur-md border rounded-full px-3.5 py-2 shadow-lg">
            <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
                 class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0">
                <svg x-show="type === 'success'" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
                <svg x-show="type === 'error'" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-700 whitespace-nowrap" x-text="message"></p>
            <button @click="show = false" class="text-gray-300 hover:text-gray-500 transition-colors ml-0.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    @yield('content')
</body>
</html>
