<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vérification en attente — MediAssist</title>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white mb-1">Vérification en cours</h1>
            <p class="text-sm text-blue-200/70">
                Bonjour Dr. {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
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

            @if(auth()->user()->verification_status === 'rejected')
            <div class="flex items-start gap-3 px-4 py-3.5 rounded-2xl bg-red-50 border border-red-100">
                <div class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 mt-1.5"></div>
                <div>
                    <p class="text-sm font-semibold text-red-800">Vérification refusée</p>
                    <p class="text-xs text-red-600 mt-0.5">Votre dossier n'a pas pu être validé. Contactez-nous pour plus d'informations.</p>
                </div>
            </div>
            @else
            <div class="flex items-start gap-3 px-4 py-3.5 rounded-2xl bg-amber-50 border border-amber-100">
                <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse flex-shrink-0 mt-1.5"></div>
                <div>
                    <p class="text-sm font-semibold text-amber-800">Dossier en attente d'examen</p>
                    <p class="text-xs text-amber-600 mt-0.5">Notre équipe examine votre dossier. Vous recevrez un e-mail dès validation.</p>
                </div>
            </div>
            @endif

            {{-- Méthode utilisée --}}
            <div class="space-y-1.5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Méthode de vérification</p>
                @if(auth()->user()->diploma_path)
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-100 bg-gray-50/50">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#0d2150,#0f3460)">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Diplôme téléchargé</p>
                        <p class="text-xs text-gray-400">Fichier soumis avec succès</p>
                    </div>
                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                @else
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-100 bg-gray-50/50">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#25D366]">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Message WhatsApp envoyé</p>
                        <p class="text-xs text-gray-400">Notre équipe vous contactera prochainement</p>
                    </div>
                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                @endif
            </div>

            {{-- Prochaines étapes --}}
            <div class="space-y-1.5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Prochaines étapes</p>
                <div class="space-y-1.5">
                    @php
                    $steps = [
                        ['done' => true,  'label' => 'Inscription complète'],
                        ['done' => true,  'label' => 'Vérification soumise'],
                        ['done' => false, 'label' => 'Examen par notre équipe', 'note' => '24–48h'],
                        ['done' => false, 'label' => 'Accès à votre espace médecin'],
                    ];
                    @endphp
                    @foreach($steps as $step)
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

        </div>

        <div class="px-8 pb-8">
            @if(auth()->user()->verification_status === 'rejected')
            <a href="/inscription/verification"
               class="w-full mb-3 flex items-center justify-center gap-2 text-xs font-bold text-white py-3 rounded-xl transition-colors"
               style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                Soumettre à nouveau
            </a>
            @endif
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
