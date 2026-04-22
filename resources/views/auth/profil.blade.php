@extends('layouts.doctor')
@section('title', 'Mon profil — MediAssist')
@section('page-title', 'Mon profil')

@section('content')
@php
$fullName = trim(($doctor['first_name'] ?? '') . ' ' . ($doctor['last_name'] ?? ''));
$initials = strtoupper(
    substr($doctor['first_name'] ?? session('firebase_email', '?'), 0, 1) .
    substr($doctor['last_name'] ?? '', 0, 1)
);
@endphp

<div class="max-w-2xl mx-auto space-y-5">

    {{-- Avatar + résumé --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-xl font-bold text-white flex-shrink-0"
                 style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                {{ $initials ?: strtoupper(substr(session('firebase_email', '?'), 0, 1)) }}
            </div>
            <div>
                <h1 class="text-base font-bold text-gray-900">
                    {{ $fullName ? 'Dr. ' . $fullName : 'Mon profil' }}
                </h1>
                <p class="text-sm text-gray-400 mt-0.5">{{ $doctor['specialty'] ?? '' }}</p>
                <p class="text-xs text-gray-400">{{ session('firebase_email') }}</p>
            </div>
        </div>
    </div>

    {{-- Formulaire infos cabinet --}}
    <form action="/dashboard/profil" method="POST">
        @csrf

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Informations personnelles</h2>
                <p class="text-xs text-gray-400 mt-0.5">Votre identité professionnelle</p>
            </div>
            <div class="px-6 py-5 space-y-4">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Prénom</label>
                        <input type="text" name="first_name" value="{{ $doctor['first_name'] ?? '' }}"
                               placeholder="Votre prénom"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nom</label>
                        <input type="text" name="last_name" value="{{ $doctor['last_name'] ?? '' }}"
                               placeholder="Votre nom"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Adresse e-mail</label>
                    <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl cursor-default select-none">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-gray-700 font-medium">{{ session('firebase_email') }}</span>
                        <span class="ml-auto text-[10px] font-semibold text-gray-400">Non modifiable</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Téléphone</label>
                    <input type="tel" name="phone" value="{{ $doctor['phone'] ?? '' }}"
                           placeholder="+33 6 00 00 00 00"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Spécialité</label>
                    <input type="text" name="specialty" value="{{ $doctor['specialty'] ?? '' }}"
                           placeholder="ex. Médecine générale, Cardiologie…"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Cabinet médical</h2>
                <p class="text-xs text-gray-400 mt-0.5">Informations sur votre lieu d'exercice</p>
            </div>
            <div class="px-6 py-5 space-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nom du cabinet</label>
                    <input type="text" name="cabinet_name" value="{{ $doctor['cabinet_name'] ?? '' }}"
                           placeholder="ex. Cabinet du Dr Dupont"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Ville</label>
                    <input type="text" name="city" value="{{ $doctor['city'] ?? '' }}"
                           placeholder="ex. Paris, Lyon, Marseille…"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 focus:bg-white transition-all">
                </div>

            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-white px-6 py-3 rounded-xl shadow-sm hover:-translate-y-0.5 transition-all"
                    style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les modifications
            </button>
        </div>

    </form>

</div>
@endsection
