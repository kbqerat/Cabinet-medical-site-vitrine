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

    {{-- Informations personnelles --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Informations personnelles</h2>
            <p class="text-xs text-gray-400 mt-0.5">Votre identité professionnelle</p>
        </div>
        <div class="px-6 py-5 space-y-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Prénom</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                        <span class="text-sm {{ ($doctor['first_name'] ?? '') ? 'text-gray-800' : 'text-gray-300' }}">
                            {{ $doctor['first_name'] ?? '—' }}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nom</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                        <span class="text-sm {{ ($doctor['last_name'] ?? '') ? 'text-gray-800' : 'text-gray-300' }}">
                            {{ $doctor['last_name'] ?? '—' }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Adresse e-mail</label>
                <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm text-gray-800 font-medium">{{ session('firebase_email') }}</span>
                    <span class="ml-auto inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full">
                        <span class="w-1 h-1 rounded-full bg-emerald-500"></span>Actif
                    </span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Téléphone</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <span class="text-sm {{ ($doctor['phone'] ?? '') ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $doctor['phone'] ?? '—' }}
                    </span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Spécialité</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <span class="text-sm {{ ($doctor['specialty'] ?? '') ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $doctor['specialty'] ?? '—' }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- Cabinet médical --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Cabinet médical</h2>
            <p class="text-xs text-gray-400 mt-0.5">Informations sur votre lieu d'exercice</p>
        </div>
        <div class="px-6 py-5 space-y-4">

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nom du cabinet</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <span class="text-sm {{ ($doctor['cabinet_name'] ?? '') ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $doctor['cabinet_name'] ?? '—' }}
                    </span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Ville</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <span class="text-sm {{ ($doctor['city'] ?? '') ? 'text-gray-800' : 'text-gray-300' }}">
                        {{ $doctor['city'] ?? '—' }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    <p class="text-xs text-gray-400 text-center pb-2">
        Pour modifier vos informations, rendez-vous dans
        <a href="/dashboard/parametres" class="text-blue-500 hover:underline">Paramètres</a>.
    </p>

</div>
@endsection
