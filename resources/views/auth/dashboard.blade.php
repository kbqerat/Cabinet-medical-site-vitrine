@extends('layouts.auth')
@section('title', 'Tableau de bord — MediAssist')

@section('content')
<div class="min-h-screen" style="background: #f8fafc;">

    {{-- Topbar --}}
    <header class="bg-white border-b border-gray-100 px-6 lg:px-10 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center"
                 style="background: linear-gradient(135deg, #1d4ed8, #4f46e5);">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <span class="text-[16px] font-bold text-gray-900 tracking-tight">Medi<span class="text-blue-600">Assist</span></span>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-sm text-gray-600 hidden sm:block">{{ session('firebase_email') }}</span>
            </div>

            <form action="/logout" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-1.5 text-sm text-gray-400 hover:text-red-500 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </header>

    {{-- Contenu --}}
    <main class="max-w-3xl mx-auto px-6 py-14 text-center">

        <div class="w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg shadow-green-500/20"
             style="background: linear-gradient(135deg, #22c55e, #16a34a);">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Connexion réussie !</h1>
        <p class="text-gray-500 text-base mb-10">Bienvenue sur votre espace médecin MediAssist.</p>

        {{-- Info session --}}
        <div class="bg-white rounded-2xl border border-gray-200/70 shadow-sm text-left max-w-sm mx-auto mb-8 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Session active</p>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-gray-400 font-medium">Email</span>
                    <span class="text-sm text-gray-800 font-medium truncate">{{ session('firebase_email') }}</span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-gray-400 font-medium">UID</span>
                    <span class="text-xs text-gray-500 font-mono truncate">{{ session('firebase_uid') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-400 font-medium">Statut</span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-green-600 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Authentifié
                    </span>
                </div>
            </div>
        </div>

        <div class="inline-flex items-center gap-2.5 bg-blue-50 border border-blue-100 rounded-xl px-5 py-3.5 text-sm text-blue-600">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Le tableau de bord complet est en cours de développement.
        </div>

    </main>
</div>
@endsection
