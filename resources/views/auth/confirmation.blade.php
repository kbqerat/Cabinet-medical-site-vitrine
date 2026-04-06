@extends('layouts.auth')
@section('title', 'Compte créé — MediAssist')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-5 relative overflow-hidden"
     style="background: linear-gradient(135deg, #f0f6ff 0%, #f5f0ff 50%, #edf9f4 100%);">

    {{-- Dot grid --}}
    <div class="absolute inset-0 pointer-events-none opacity-30"
         style="background-image: radial-gradient(circle, #94a3b8 1px, transparent 1px); background-size: 24px 24px;"></div>

    {{-- Blobs --}}
    <div class="absolute -top-20 -left-20 w-80 h-80 bg-blue-200/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-indigo-200/20 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Card --}}
    <div class="relative bg-white rounded-3xl shadow-xl shadow-black/5 border border-gray-100 p-10 max-w-md w-full text-center">

        {{-- Logo --}}
        <a href="/" class="inline-flex items-center gap-2 mb-8">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <span class="text-base font-bold text-gray-900">Medi<span class="text-blue-600">Assist</span></span>
        </a>

        {{-- Icône succès --}}
        <div class="relative inline-flex mb-6">
            <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center">
                <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="absolute -top-1 -right-1 w-5 h-5 bg-emerald-400 rounded-full border-2 border-white flex items-center justify-center">
                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                </svg>
            </div>
        </div>

        <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Compte créé avec succès !</h1>
        <p class="text-sm text-gray-400 leading-relaxed mb-8">
            Bienvenue sur MediAssist. Votre essai gratuit de <strong class="text-gray-600">14 jours</strong> commence maintenant.
            Vérifiez votre boîte mail pour activer votre compte.
        </p>

        {{-- Étapes --}}
        <div class="space-y-3 text-left mb-8">
            @foreach([
                ['num' => '1', 'text' => 'Vérifiez votre email et cliquez sur le lien d\'activation', 'done' => false],
                ['num' => '2', 'text' => 'Connectez-vous à votre espace médecin', 'done' => false],
                ['num' => '3', 'text' => 'Configurez votre cabinet et importez vos patients', 'done' => false],
            ] as $step)
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-blue-50 border-2 border-blue-200 flex items-center justify-center shrink-0 mt-0.5">
                    <span class="text-[10px] font-bold text-blue-500">{{ $step['num'] }}</span>
                </div>
                <p class="text-sm text-gray-600 leading-snug">{{ $step['text'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <a href="/login/doctor"
           class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 rounded-2xl text-sm font-bold shadow-sm hover:shadow-blue-500/20 hover:shadow-md transition-all duration-200 text-center mb-4">
            Accéder à mon espace
        </a>
        <a href="/" class="block text-xs text-gray-400 hover:text-gray-600 transition-colors">
            Retour au site
        </a>

    </div>

    {{-- Badge essai --}}
    <div class="relative mt-6 inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm border border-gray-100 rounded-full px-4 py-2 shadow-sm">
        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
        <span class="text-xs text-gray-500 font-medium">Essai gratuit 14 jours · Sans engagement</span>
    </div>

</div>
@endsection
