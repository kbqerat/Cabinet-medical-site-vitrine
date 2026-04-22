@extends('layouts.doctor')
@section('title', 'Mon abonnement — MediAssist')
@section('page-title', 'Mon abonnement')

@section('content')
@php
$plan        = $doctor['plan'] ?? 'starter';
$isPro       = $plan === 'pro';
$trialEndsAt = isset($doctor['trial_ends_at']) ? \Carbon\Carbon::parse($doctor['trial_ends_at']) : null;
$trialActive = $trialEndsAt && $trialEndsAt->isFuture();
$daysLeft    = $trialEndsAt ? max(0, (int) now()->diffInDays($trialEndsAt, false)) : 0;
$trialTotal  = 14;
$daysUsed    = $trialTotal - $daysLeft;
$trialPct    = $trialTotal > 0 ? min(100, round($daysUsed / $trialTotal * 100)) : 100;
$trialEndFmt = $trialEndsAt ? $trialEndsAt->locale('fr')->isoFormat('D MMMM YYYY') : '—';
$urgency     = !$isPro && $daysLeft <= 3;

// Données dynamiques des plans
$planConfig      = $planConfig ?? [];
$starterPrice    = (int)($planConfig['starter_price_monthly'] ?? 0);
$proPrice        = (int)($planConfig['pro_price_monthly'] ?? 490);
$proPriceAnnual  = (int)($planConfig['pro_price_annual']  ?? 392);
$proDesc         = $planConfig['pro_desc'] ?? 'Le plus populaire pour les cabinets actifs';
$starterDesc     = $planConfig['starter_desc'] ?? 'Pour les médecins solo qui débutent';
$proFeatures     = json_decode($planConfig['pro_features_json'] ?? '[]', true) ?: [];
$starterFeatures = json_decode($planConfig['starter_features_json'] ?? '[]', true) ?: [];
@endphp

{{-- ── BANDEAU STATUT ──────────────────────────────────────────── --}}
@if($isPro)
<div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 mb-6">
    <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold text-emerald-800">Abonnement Pro actif</p>
        <p class="text-xs text-emerald-600 mt-0.5">Renouvellement mensuel automatique · {{ $proPrice }} MAD/mois</p>
    </div>
    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 border border-emerald-200 px-2.5 py-1 rounded-full uppercase tracking-wide">Pro</span>
</div>

@elseif($trialActive)
<div class="flex items-center gap-3 {{ $urgency ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200' }} border rounded-2xl px-5 py-4 mb-6">
    <div class="w-8 h-8 rounded-xl {{ $urgency ? 'bg-red-500' : 'bg-blue-500' }} flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold {{ $urgency ? 'text-red-800' : 'text-blue-800' }}">
            {{ $urgency ? 'Votre essai expire bientôt' : "Période d'essai en cours" }}
        </p>
        <p class="text-xs {{ $urgency ? 'text-red-600' : 'text-blue-600' }} mt-0.5">
            {{ $daysLeft }} jour{{ $daysLeft > 1 ? 's' : '' }} restant{{ $daysLeft > 1 ? 's' : '' }} · expire le {{ $trialEndFmt }}
        </p>
    </div>
    @if($urgency)
    <span class="text-[10px] font-bold text-red-700 bg-red-100 border border-red-200 px-2.5 py-1 rounded-full uppercase tracking-wide animate-pulse">Urgent</span>
    @endif
</div>

@else
<div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 mb-6">
    <div class="w-8 h-8 rounded-xl bg-gray-400 flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold text-gray-800">Essai expiré</p>
        <p class="text-xs text-gray-500 mt-0.5">Votre période d'essai est terminée. Passez au Pro pour continuer.</p>
    </div>
    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full uppercase tracking-wide">Inactif</span>
</div>
@endif

{{-- ── GRILLE PRINCIPALE ───────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-5 mb-5">

    {{-- Colonne gauche : plan actuel --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- Carte plan actuel --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Votre plan</p>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:{{ $isPro ? '#ecfdf5' : '#eff6ff' }}; border:1px solid {{ $isPro ? '#a7f3d0' : '#bfdbfe' }}">
                    @if($isPro)
                    <svg style="width:18px;height:18px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    @else
                    <svg style="width:18px;height:18px;color:#2563eb" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    @endif
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-900">{{ $isPro ? 'Plan Pro' : 'Plan Starter' }}</p>
                    <p class="text-xs text-gray-400">{{ $isPro ? $proPrice.' MAD / mois' : ($starterPrice > 0 ? $starterPrice.' MAD / mois' : 'Gratuit · 14 jours') }}</p>
                </div>
            </div>

            {{-- Barre essai --}}
            @if($trialActive)
            <div class="mb-4 p-3.5 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-blue-700">Essai gratuit</span>
                    <span class="text-xs text-blue-500">{{ $daysLeft }}j restants</span>
                </div>
                <div class="w-full bg-blue-100 rounded-full h-1.5 overflow-hidden">
                    <div class="h-1.5 rounded-full bg-blue-500 transition-all"
                         style="width:{{ $trialPct }}%"></div>
                </div>
                <p class="text-[11px] text-blue-400 mt-1.5">Expire le {{ $trialEndFmt }}</p>
            </div>
            @endif

            <div class="space-y-2.5 pt-1">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Statut</span>
                    @if($isPro || $trialActive)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Actif
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-500">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Expiré
                    </span>
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Engagement</span>
                    <span class="text-xs font-medium text-gray-700">{{ $isPro ? 'Mensuel' : 'Aucun' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Résiliation</span>
                    <span class="text-xs font-medium text-gray-700">À tout moment</span>
                </div>
            </div>
        </div>

        {{-- Support rapide --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-bold text-gray-900 mb-3">Une question ?</p>
            <p class="text-xs text-gray-400 leading-relaxed mb-4">Notre équipe vous répond rapidement pour tout ce qui concerne votre abonnement.</p>
            <a href="/#contact"
               class="w-full flex items-center justify-center gap-2 text-xs font-semibold text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-300 bg-gray-50 hover:bg-gray-100 py-2.5 rounded-xl transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contacter le support
            </a>
        </div>

    </div>

    {{-- Colonne droite : offre Pro --}}
    <div class="lg:col-span-3">
        @if($isPro)
        {{-- Déjà Pro : ce qui est inclus --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 h-full">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Inclus dans votre plan Pro</p>
            <div class="space-y-2.5">
                @foreach($proFeatures as $f)
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-xl flex items-center justify-center flex-shrink-0
                        {{ ($f['ok'] ?? true) ? 'bg-emerald-50 border border-emerald-100' : 'bg-gray-50 border border-gray-100' }}">
                        @if($f['ok'] ?? true)
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        @else
                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        @endif
                    </div>
                    <span class="text-sm {{ ($f['ok'] ?? true) ? 'text-gray-800 font-medium' : 'text-gray-300' }}">{{ $f['text'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        @else
        {{-- Pas encore Pro : carte upgrade --}}
        <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm h-full flex flex-col">
            {{-- Header --}}
            <div class="px-6 py-6 flex-shrink-0" style="background: linear-gradient(135deg, #0a1628 0%, #0d2150 55%, #0f3460 100%);">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <p class="text-base font-bold text-white">Plan Pro</p>
                            <span class="text-[10px] font-bold text-yellow-300 bg-yellow-400/15 border border-yellow-400/30 px-2 py-0.5 rounded-full uppercase tracking-wide">Recommandé</span>
                        </div>
                        <p class="text-xs text-blue-200/70">{{ $proDesc }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-2xl font-bold text-white">{{ $proPrice }} <span class="text-sm font-normal text-blue-300">MAD</span></p>
                        <p class="text-[11px] text-blue-200/50">/ mois</p>
                    </div>
                </div>

                {{-- Fonctionnalités dynamiques --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($proFeatures as $f)
                    @if($f['ok'] ?? true)
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-blue-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-xs text-blue-100/80">{{ $f['text'] }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- CTA --}}
            <div class="bg-white px-6 py-5 flex-1 flex flex-col justify-between">
                <div class="mb-4">
                    <p class="text-sm font-bold text-gray-900 mb-1">Prêt à activer le plan Pro ?</p>
                    <p class="text-xs text-gray-400 leading-relaxed">Contactez notre équipe. Votre compte sera activé sous 24h.</p>
                </div>
                <div class="flex flex-col gap-2.5">
                    <a href="/#contact"
                       class="w-full flex items-center justify-center gap-2 text-sm font-bold text-white py-3 rounded-xl transition-all hover:-translate-y-0.5 shadow-sm"
                       style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Nous contacter pour activer
                    </a>
                    <p class="text-center text-[11px] text-gray-400">Sans carte bancaire requise — on vous contacte</p>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

{{-- ── COMPARAISON STARTER vs PRO ──────────────────────────────── --}}
@if(!$isPro)
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <p class="text-sm font-bold text-gray-900">Starter vs Pro — Comparaison détaillée</p>
        <div class="flex items-center gap-3 text-xs text-gray-400">
            <span>Starter · <span class="font-semibold text-gray-600">{{ $starterPrice > 0 ? $starterPrice.' MAD/mois' : 'Gratuit' }}</span></span>
            <span class="text-gray-200">|</span>
            <span>Pro · <span class="font-semibold" style="color:#0d2150">{{ $proPrice }} MAD/mois</span></span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 w-1/2">Fonctionnalité</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500">Starter</th>
                    <th class="px-4 py-3 text-center text-xs font-bold" style="color:#0d2150">Pro</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                // Construire la comparaison depuis les features des 2 plans
                // On fusionne les textes des 2 listes pour avoir toutes les features
                $allFeatureTexts = collect($starterFeatures)->pluck('text')
                    ->merge(collect($proFeatures)->pluck('text'))
                    ->unique()->values();
                $starterOk = collect($starterFeatures)->filter(fn($f) => $f['ok'] ?? true)->pluck('text')->flip();
                $proOk     = collect($proFeatures)->filter(fn($f) => $f['ok'] ?? true)->pluck('text')->flip();
                @endphp
                @foreach($allFeatureTexts as $feat)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $feat }}</td>
                    <td class="px-4 py-3 text-center">
                        @if(isset($starterOk[$feat]))
                        <svg class="w-4 h-4 text-blue-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        @else
                        <span class="w-4 h-0.5 bg-gray-200 block mx-auto rounded"></span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if(isset($proOk[$feat]))
                        <svg class="w-4 h-4 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        @else
                        <span class="w-4 h-0.5 bg-gray-200 block mx-auto rounded"></span>
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr class="bg-gray-50 border-t border-gray-100">
                    <td class="px-6 py-3 text-sm font-bold text-gray-800">Prix mensuel</td>
                    <td class="px-4 py-3 text-center text-sm font-semibold text-gray-500">{{ $starterPrice > 0 ? $starterPrice.' MAD' : 'Gratuit' }}</td>
                    <td class="px-4 py-3 text-center text-sm font-bold" style="color:#0d2150">{{ $proPrice }} MAD</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ── FAQ ──────────────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <p class="text-sm font-bold text-gray-900 mb-4">Questions fréquentes</p>
    <div class="space-y-2" x-data>
        @php
        $faqs = [
            ['q' => 'Comment activer le plan Pro ?',
             'a' => 'Cliquez sur "Nous contacter" et notre équipe vous envoie un lien de paiement sécurisé. Votre compte Pro est activé dans les 24h.'],
            ['q' => 'Puis-je annuler à tout moment ?',
             'a' => 'Oui, sans frais. Votre accès Pro reste actif jusqu\'à la fin du mois payé, puis passe en Starter.'],
            ['q' => 'Que se passe-t-il à la fin de l\'essai ?',
             'a' => 'Votre accès est limité aux fonctionnalités de base. Vous pouvez toujours vous connecter, compléter votre profil et activer le Pro à tout moment.'],
            ['q' => 'Y a-t-il des frais cachés ?',
             'a' => 'Non. '.$proPrice.' MAD/mois tout compris, sans frais d\'installation, sans engagement.'],
        ];
        @endphp
        @foreach($faqs as $faq)
        <div class="border border-gray-100 rounded-xl overflow-hidden" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                    class="w-full flex items-center justify-between px-5 py-3.5 text-left hover:bg-gray-50 transition-colors">
                <span class="text-sm font-semibold text-gray-800">{{ $faq['q'] }}</span>
                <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0 transition-transform duration-200"
                     :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-cloak
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="px-5 pb-4 border-t border-gray-100">
                <p class="text-sm text-gray-500 leading-relaxed pt-3">{{ $faq['a'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
