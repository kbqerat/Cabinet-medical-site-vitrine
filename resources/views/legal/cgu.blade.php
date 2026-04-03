@extends('layouts.legal', ['title' => "Conditions Générales d'Utilisation", 'updated' => '1er avril 2026'])

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

{!! section('01.', 'Objet') !!}
<p class="text-sm text-gray-500 leading-relaxed">Les présentes CGU régissent l'accès et l'utilisation de la plateforme <strong class="text-gray-700">MediAssist</strong>, logiciel de gestion de cabinet médical édité par MediAssist SARL. Toute utilisation implique l'acceptation pleine et entière des présentes conditions.</p>

{!! section('02.', 'Accès au service') !!}
{!! subsection('2.1 Inscription') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">L'accès à MediAssist nécessite la création d'un compte avec des informations exactes et à jour. Vous êtes responsable de la confidentialité de vos identifiants de connexion.</p>

{!! subsection('2.2 Période d\'essai') !!}
<div class="flex items-start gap-3 bg-green-50 border border-green-100 rounded-2xl p-4 mb-3">
    <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <p class="text-sm text-green-700">Un essai gratuit de <strong>14 jours</strong> est proposé sans carte bancaire. Vous accédez à toutes les fonctionnalités sans limitation pendant cette période.</p>
</div>

{!! subsection('2.3 Conditions d\'accès') !!}
<p class="text-sm text-gray-500 leading-relaxed">L'accès est réservé aux <strong class="text-gray-700">professionnels de santé</strong> (médecins, dentistes, paramédicaux) et à leur personnel administratif autorisé.</p>

{!! section('03.', 'Description du service') !!}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-3">
    @foreach([
        ['Gestion des dossiers patients', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Agenda & gestion des rendez-vous', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['Ordonnances et comptes rendus', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['Facturation et suivi des paiements', 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
        ['Application mobile (selon plan)', 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
        ['Suivi des analyses médicales', 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
    ] as [$label, $icon])
    <div class="flex items-center gap-2.5 bg-gray-50 border border-gray-100 rounded-xl px-3.5 py-2.5">
        <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/>
            </svg>
        </div>
        <span class="text-sm text-gray-600">{{ $label }}</span>
    </div>
    @endforeach
</div>

{!! section('04.', 'Tarification et paiement') !!}
{!! subsection('4.1 Plans disponibles') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">Les tarifs en vigueur sont ceux affichés sur la <a href="/#pricing" class="text-blue-600 font-medium hover:underline">page Tarifs</a>. MediAssist se réserve le droit de modifier ses tarifs avec un préavis de <strong class="text-gray-700">30 jours</strong>.</p>

{!! subsection('4.2 Modalités de paiement') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">Le paiement s'effectue mensuellement ou annuellement selon le plan choisi. En cas de non-paiement, l'accès peut être suspendu après mise en demeure.</p>

{!! subsection('4.3 Remboursement') !!}
<p class="text-sm text-gray-500 leading-relaxed">La période d'essai gratuite n'est pas remboursable. Pour les abonnements payants, aucun remboursement n'est effectué pour les périodes entamées.</p>

{!! section('05.', 'Obligations de l\'utilisateur') !!}
<ul class="space-y-1.5 mb-2">
    @foreach([
        'Utiliser le service conformément à la législation marocaine applicable',
        'Respecter le secret médical et la confidentialité des données patients',
        'Ne pas partager vos identifiants avec des tiers non autorisés',
        'Ne pas tenter de contourner les mesures de sécurité de la plateforme',
        'Informer MediAssist de tout accès non autorisé à votre compte',
    ] as $item)
    <li class="flex items-start gap-2.5 text-sm text-gray-500">
        <div class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></div>
        {{ $item }}
    </li>
    @endforeach
</ul>

{!! section('06.', 'Responsabilités médicales') !!}
<div class="flex items-start gap-3 bg-rose-50 border border-rose-100 rounded-2xl p-4 mb-3">
    <svg class="w-5 h-5 text-rose-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
    <p class="text-sm text-rose-700">MediAssist est un <strong>outil de gestion</strong>. Il ne se substitue en aucun cas au jugement clinique du professionnel de santé. MediAssist décline toute responsabilité quant aux décisions médicales prises via la plateforme.</p>
</div>

{!! section('07.', 'Disponibilité du service') !!}
<div class="flex items-center justify-between bg-gray-50 border border-gray-100 rounded-xl px-5 py-4 mb-3">
    <span class="text-sm text-gray-600">Disponibilité garantie</span>
    <span class="text-lg font-extrabold text-blue-600">99,5%</span>
</div>
<p class="text-sm text-gray-500 leading-relaxed">Des interruptions planifiées peuvent survenir avec un préavis de 48h. En cas d'indisponibilité supérieure au seuil garanti, une compensation sous forme de prolongation d'abonnement pourra être accordée.</p>

{!! section('08.', 'Résiliation') !!}
{!! subsection('8.1 Par l\'utilisateur') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">Vous pouvez résilier à tout moment depuis votre espace client. La résiliation prend effet à la fin de la période de facturation en cours.</p>

{!! subsection('8.2 Conséquences') !!}
<div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-2xl p-4">
    <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <p class="text-sm text-blue-700">À la résiliation, vos données vous sont restituées dans un format exportable (CSV/PDF) dans un délai de <strong>30 jours</strong>. Passé ce délai, les données sont supprimées définitivement.</p>
</div>

{!! section('09.', 'Droit applicable et litiges') !!}
<p class="text-sm text-gray-500 leading-relaxed">Les présentes CGU sont soumises au <strong class="text-gray-700">droit marocain</strong>. En cas de litige, les parties s'engagent à rechercher une solution amiable. À défaut, les tribunaux de <strong class="text-gray-700">Casablanca</strong> seront seuls compétents.</p>

{!! section('10.', 'Contact') !!}
<p class="text-sm text-gray-500">Pour toute question : <a href="mailto:legal@mediassist.ma" class="text-blue-600 font-medium hover:underline">legal@mediassist.ma</a></p>

@endsection
