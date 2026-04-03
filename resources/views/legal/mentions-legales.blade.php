@extends('layouts.legal', ['title' => 'Mentions légales', 'updated' => '1er avril 2026'])

@section('content')

@php
function section(string $num, string $title): string {
    return '<h2 class="text-lg font-bold text-gray-900 mt-8 mb-3 pb-3 border-b border-gray-100 first:mt-0">'
         . '<span class="text-blue-500 mr-2 text-sm font-black">'.$num.'</span>'.$title.'</h2>';
}
@endphp

{!! section('01.', 'Éditeur du site') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">Le site <strong class="text-gray-700">mediassist.ma</strong> est édité par la société <strong class="text-gray-700">MediAssist SARL</strong>, société à responsabilité limitée au capital de 100 000 MAD, immatriculée au Registre de Commerce de Casablanca.</p>
<div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-2.5 mb-4">
    @foreach([
        ['Raison sociale', 'MediAssist SARL'],
        ['Forme juridique', 'SARL'],
        ['Capital social', '100 000 MAD'],
        ['Registre de Commerce', 'RC 123456 – Casablanca'],
        ['Siège social', 'Boulevard Zerktouni, Casablanca 20000, Maroc'],
        ['Téléphone', '+212 5 XX XX XX XX'],
        ['Email', 'contact@mediassist.ma'],
        ['Directeur de publication', 'M. [Nom du dirigeant]'],
    ] as [$k, $v])
    <div class="flex items-start gap-3">
        <span class="text-xs font-semibold text-gray-400 w-44 shrink-0">{{ $k }}</span>
        <span class="text-sm text-gray-700">{{ $v }}</span>
    </div>
    @endforeach
</div>

{!! section('02.', 'Hébergement') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">Le site est hébergé par :</p>
<div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-2 mb-4">
    @foreach([
        ['Hébergeur', 'Datacenter Maroc / [Nom hébergeur]'],
        ['Adresse', 'Casablanca, Maroc'],
        ['Téléphone', '+212 5 XX XX XX XX'],
    ] as [$k, $v])
    <div class="flex items-start gap-3">
        <span class="text-xs font-semibold text-gray-400 w-44 shrink-0">{{ $k }}</span>
        <span class="text-sm text-gray-700">{{ $v }}</span>
    </div>
    @endforeach
</div>
<p class="text-sm text-gray-500 leading-relaxed">Les données sont stockées exclusivement sur des serveurs situés au Maroc, conformément à la réglementation en vigueur.</p>

{!! section('03.', 'Propriété intellectuelle') !!}
<p class="text-sm text-gray-500 leading-relaxed mb-3">L'ensemble des contenus présents sur le site mediassist.ma (textes, images, logos, icônes, logiciels, bases de données) est la propriété exclusive de <strong class="text-gray-700">MediAssist SARL</strong> et est protégé par les lois marocaines et internationales relatives à la propriété intellectuelle.</p>
<div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-4">
    <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <p class="text-sm text-blue-700">Toute reproduction, représentation, modification ou publication de tout ou partie des éléments du site est interdite sans autorisation écrite préalable de MediAssist SARL.</p>
</div>

{!! section('04.', 'Liens hypertextes') !!}
<p class="text-sm text-gray-500 leading-relaxed">Le site mediassist.ma peut contenir des liens vers des sites tiers. MediAssist SARL n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu ou leurs pratiques en matière de confidentialité.</p>

{!! section('05.', 'Limitation de responsabilité') !!}
<p class="text-sm text-gray-500 leading-relaxed">MediAssist SARL s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur ce site. Cependant, MediAssist SARL ne peut garantir l'exactitude, la complétude et l'actualité des informations diffusées sur ce site.</p>

{!! section('06.', 'Droit applicable') !!}
<p class="text-sm text-gray-500 leading-relaxed">Les présentes mentions légales sont soumises au <strong class="text-gray-700">droit marocain</strong>. En cas de litige, les tribunaux de <strong class="text-gray-700">Casablanca</strong> seront seuls compétents.</p>

{!! section('07.', 'Contact') !!}
<p class="text-sm text-gray-500 leading-relaxed">Pour toute question relative aux présentes mentions légales, contactez-nous à <a href="mailto:contact@mediassist.ma" class="text-blue-600 font-medium hover:underline">contact@mediassist.ma</a></p>

@endsection
