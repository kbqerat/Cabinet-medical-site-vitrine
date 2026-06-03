<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouveau mot de passe — MediAssist</title>
    <style>[x-cloak]{display:none!important}</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 flex flex-col items-center justify-center p-4">

    <div class="mb-8">
        <a href="/" class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #0d2150, #0f3460)">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="text-xl font-bold text-gray-900 tracking-tight">MediAssist</span>
        </a>
    </div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-8 pt-8 pb-6 text-center" style="background: linear-gradient(135deg, #0a1628 0%, #0d2150 55%, #0f3460 100%)">
            <div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white mb-1">Nouveau mot de passe</h1>
            <p class="text-sm text-blue-200/70">Choisissez un mot de passe sécurisé d'au moins 8 caractères.</p>
        </div>

        <div class="px-8 py-6" x-data="{ showPwd: false, showConfirm: false }">

            @if($errors->has('token'))
            <div class="flex items-start gap-3 px-4 py-3.5 rounded-2xl bg-red-50 border border-red-100 mb-5">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700">{{ $errors->first('token') }}</p>
                    <a href="/mot-de-passe-oublie" class="text-xs text-red-500 hover:underline mt-0.5 inline-block">Faire une nouvelle demande →</a>
                </div>
            </div>
            @endif

            @if($errors->has('password'))
            <div class="flex items-start gap-3 px-4 py-3.5 rounded-2xl bg-red-50 border border-red-100 mb-5">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-red-700">{{ $errors->first('password') }}</p>
            </div>
            @endif

            <form action="/reinitialiser-mot-de-passe" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- Nouveau mot de passe --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input :type="showPwd ? 'text' : 'password'" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-4 pr-11 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                        <button type="button" @click="showPwd = !showPwd"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                            <svg x-show="!showPwd" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPwd" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1.5 text-[11px] text-gray-400 leading-relaxed">
                        Requis : 8 caractères min. · 1 majuscule (A-Z) · 1 minuscule (a-z) · 1 chiffre (0-9)
                    </p>
                </div>

                {{-- Confirmation --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                               placeholder="••••••••"
                               class="w-full pl-4 pr-11 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showConfirm" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 text-sm font-bold text-white py-3.5 rounded-xl transition-opacity hover:opacity-90"
                        style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Enregistrer le nouveau mot de passe
                </button>
            </form>

        </div>

        <div class="px-8 pb-8">
            <a href="/login/doctor"
               class="w-full flex items-center justify-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour à la connexion
            </a>
        </div>

    </div>

</body>
</html>
