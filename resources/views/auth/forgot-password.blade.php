<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié — MediAssist</title>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white mb-1">Mot de passe oublié ?</h1>
            <p class="text-sm text-blue-200/70">Entrez votre adresse e-mail et nous vous enverrons un lien de réinitialisation.</p>
        </div>

        <div class="px-8 py-6">

            @if(session('success'))
            <div class="flex items-start gap-3 px-4 py-3.5 rounded-2xl bg-emerald-50 border border-emerald-100 mb-5">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="flex items-start gap-3 px-4 py-3.5 rounded-2xl bg-red-50 border border-red-100 mb-5">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-red-700">{{ $errors->first() }}</p>
            </div>
            @endif

            @if(!session('success'))
            <form action="/mot-de-passe-oublie" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Adresse e-mail
                    </label>
                    <input type="email" name="email" required
                           value="{{ old('email') }}"
                           placeholder="dr.nom@exemple.com"
                           autofocus
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 text-sm font-bold text-white py-3.5 rounded-xl transition-opacity hover:opacity-90"
                        style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Envoyer le lien
                </button>
            </form>
            @endif

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
