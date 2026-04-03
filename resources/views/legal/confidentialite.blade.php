@extends('layouts.legal', ['title' => 'Politique de confidentialité', 'updated' => '1er avril 2026'])

@section('content')

@php
function section(string $num, string $title): string {
    return '<h2 class="text-lg font-bold text-gray-900 mt-8 mb-3 pb-3 border-b border-gray-100 first:mt-0">'
         . '<span class="text-blue-500 mr-2 text-sm font-black">'.$num.'</span>'.$title.'</h2>';
}
function subsection(string $title): string {
    return '<h3 class="text-sm font-bold text-gray-800 mt-5 mb-2">'.$title.'</h3>';
}
@endphp

{!! section('01.', 'Introduction') !!}
<p class="text-sm text-gray-500 leading-relaxed">MediAssist SARL accorde une importance primordiale à la protection des données personnelles et médicales de ses utilisateurs. La présente politique décrit comment nous collectons, utilisons et protégeons vos données dans le cadre de l'utilisation de notre plateforme.</p>

{!! section('02.', 'Responsable du traitement') !!}
<div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-2 mb-2">
    @foreach([
        ['Société', 'MediAssist SARL'],
        ['Adresse', 'Boulevard Zerktouni, Casablanca 20000, Maroc'],
        ['Email DPO', 'privacy@mediassist.ma'],
    ] as [$k, $v])
    <div class="flex items-start gap-3">
        <span class="text-xs font-semibold text-gray-400 w-32 shrink-0">{{ $k }}</span>
        <span class="text-sm text-gray-700">{{ $v }}</span>
    </div>
    @endforeach
</div>

{!! section('03.', 'Données collectées') !!}
{!! subsection('3.1 Données du professionnel de santé') !!}
<ul class="space-y-1.5 mb-4">
    @foreach([
        'Nom, prénom, spécialité médicale',
        'Adresse email professionnelle et numéro de téléphone',
        'Informations de facturation (adresse, mode de paiement)',
        'Données d\'utilisation de la plateforme (connexions, actions effectuées)',
    ] as $item)
    <li class="flex items-start gap-2.5 text-sm text-gray-500">
        <div class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></div>
        {{ $item }}
    </li>
    @endforeach
</ul>

{!! subsection('3.2 Données des patients') !!}
<div class="flex items-start gap-3 bg-amber-50 border border-amber-100 rounded-2xl p-4 mb-3">
    <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
    <p class="text-sm text-amber-700">Les données patients sont traitées <strong>sous votre responsabilité exclusive</strong> en tant que professionnel de santé. MediAssist agit en qualité de <strong>sous-traitant</strong>.</p>
</div>
<ul class="space-y-1.5 mb-2">
    @foreach([
        'Informations d\'identité (nom, prénom, date de naissance, coordonnées)',
        'Données médicales (antécédents, allergies, prescriptions, analyses)',
        'Données de rendez-vous et de facturation',
    ] as $item)
    <li class="flex items-start gap-2.5 text-sm text-gray-500">
        <div class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></div>
        {{ $item }}
    </li>
    @endforeach
</ul>

{!! section('04.', 'Finalités du traitement') !!}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-2">
    @foreach([
        ['Fournir le service', 'Gestion de compte et accès à la plateforme', 'bg-blue-50 border-blue-100 text-blue-600'],
        ['Facturation', 'Émission des factures et suivi des paiements', 'bg-indigo-50 border-indigo-100 text-indigo-600'],
        ['Support', 'Répondre à vos demandes d\'assistance', 'bg-emerald-50 border-emerald-100 text-emerald-600'],
        ['Amélioration', 'Analyse anonymisée des usages', 'bg-amber-50 border-amber-100 text-amber-600'],
        ['Communication', 'Informations sur les mises à jour (avec consentement)', 'bg-purple-50 border-purple-100 text-purple-600'],
    ] as [$titre, $desc, $colors])
    <div class="border rounded-xl p-4 {{ $colors }}">
        <div class="text-xs font-bold mb-1">{{ $titre }}</div>
        <div class="text-xs opacity-70">{{ $desc }}</div>
    </div>
    @endforeach
</div>

{!! section('05.', 'Sécurité des données') !!}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-2">
    @foreach([
        ['Chiffrement transit', 'TLS 1.3', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
        ['Chiffrement repos', 'AES-256', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
        ['Sauvegardes', 'Toutes les heures', 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
        ['Hébergement', 'Serveurs au Maroc', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
    ] as [$label, $val, $icon])
    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex items-center gap-3">
        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/>
            </svg>
        </div>
        <div>
            <div class="text-xs font-bold text-gray-700">{{ $label }}</div>
            <div class="text-xs text-gray-400">{{ $val }}</div>
        </div>
    </div>
    @endforeach
</div>

{!! section('06.', 'Durée de conservation') !!}
<div class="space-y-2 mb-2">
    @foreach([
        ['Données de compte', '5 ans après résiliation'],
        ['Données de facturation', '10 ans (obligation légale)'],
        ['Dossiers patients', '20 ans minimum (réglementation médicale)'],
    ] as [$k, $v])
    <div class="flex items-center justify-between bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
        <span class="text-sm font-medium text-gray-700">{{ $k }}</span>
        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">{{ $v }}</span>
    </div>
    @endforeach
</div>

{!! section('07.', 'Vos droits') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">Conformément à la loi <strong class="text-gray-700">09-08</strong> relative à la protection des données à caractère personnel au Maroc, vous disposez des droits suivants :</p>
<ul class="space-y-1.5 mb-4">
    @foreach([
        ['Accès', 'Obtenir une copie de vos données'],
        ['Rectification', 'Corriger vos données inexactes'],
        ['Effacement', 'Demander la suppression de vos données'],
        ['Opposition', 'Vous opposer à certains traitements'],
        ['Portabilité', 'Recevoir vos données dans un format structuré'],
    ] as [$droit, $desc])
    <li class="flex items-start gap-2.5 text-sm text-gray-500">
        <div class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></div>
        <span><strong class="text-gray-700">Droit d'{{ $droit }} :</strong> {{ $desc }}</span>
    </li>
    @endforeach
</ul>
<p class="text-sm text-gray-500">Pour exercer ces droits : <a href="mailto:privacy@mediassist.ma" class="text-blue-600 font-medium hover:underline">privacy@mediassist.ma</a></p>

{!! section('08.', 'Contact') !!}
<p class="text-sm text-gray-500">Pour toute question : <a href="mailto:privacy@mediassist.ma" class="text-blue-600 font-medium hover:underline">privacy@mediassist.ma</a></p>

@endsection
