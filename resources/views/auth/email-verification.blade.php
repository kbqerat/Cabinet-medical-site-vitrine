<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmez votre e-mail — MediAssist</title>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white mb-1">Confirmez votre e-mail</h1>
            <p class="text-sm text-blue-200/70">
                Dr. {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
            </p>
        </div>

        <div class="px-8 py-6 space-y-5">

            @if(session('success'))
            <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-100 text-sm text-emerald-700">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Statut --}}
            <div class="flex items-start gap-3 px-4 py-3.5 rounded-2xl bg-amber-50 border border-amber-100">
                <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse flex-shrink-0 mt-1.5"></div>
                <div>
                    <p class="text-sm font-semibold text-amber-800">E-mail non confirmé</p>
                    <p class="text-xs text-amber-600 mt-0.5">
                        Un lien de confirmation a été envoyé à<br>
                        <strong>{{ auth()->user()->email }}</strong>
                    </p>
                </div>
            </div>

            {{-- Instructions --}}
            <div class="space-y-1.5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Comment faire ?</p>
                <div class="space-y-1.5">
                    @foreach([
                        ['done' => true,  'label' => 'Inscription complète'],
                        ['done' => false, 'label' => 'Ouvrir l\'e-mail de confirmation', 'note' => 'Maintenant'],
                        ['done' => false, 'label' => 'Cliquer sur le lien de confirmation'],
                        ['done' => false, 'label' => 'Soumettre votre dossier de vérification'],
                    ] as $step)
                    <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ $step['done'] ? 'bg-emerald-50/60' : 'bg-gray-50/60' }}">
                        @if($step['done'])
                        <div class="w-5 h-5 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-emerald-700">{{ $step['label'] }}</span>
                        @else
                        <div class="w-5 h-5 rounded-full border-2 border-dashed flex-shrink-0 {{ isset($step['note']) ? 'border-amber-300' : 'border-gray-300' }}"></div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-gray-500">{{ $step['label'] }}</span>
                            @isset($step['note'])
                            <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-1.5 py-0.5 rounded-full">{{ $step['note'] }}</span>
                            @endisset
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <p class="text-xs text-gray-400 text-center">
                Vérifiez aussi votre dossier spam si vous ne trouvez pas l'e-mail.
            </p>

        </div>

        <div class="px-8 pb-8 space-y-3">
            <form action="/email/verification-notification" method="POST">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 text-sm font-bold text-white py-3 rounded-xl transition-opacity hover:opacity-90"
                        style="background: linear-gradient(135deg, #0d2150, #0f3460)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Renvoyer l'e-mail de confirmation
                </button>
            </form>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit"
                        class="w-full py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                    Se déconnecter
                </button>
            </form>
        </div>

    </div>

    <p class="mt-6 text-xs text-gray-400">
        Une question ?
        <a href="https://wa.me/212721667521" target="_blank" class="text-blue-600 hover:underline">Contactez-nous sur WhatsApp</a>
    </p>

</body>
</html>
