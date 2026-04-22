@extends('layouts.admin')
@section('title', 'Plans & Abonnements — MediAssist Admin')
@section('page-title', 'Plans & Abonnements')
@section('page-subtitle', 'Suivi des abonnements et configuration des offres')

@section('content')

@php
$proPrice = (int)($planConfig['pro_price_monthly'] ?? 490);
$mrr      = $proCount * $proPrice;
$total    = max($totalDoctors, 1);
$sPct     = round($starterCount / $total * 100);
$pPct     = round($proCount     / $total * 100);
$tPct     = round($trialCount   / $total * 100);
@endphp

{{-- Alerte essais expirants --}}
@if($expiringCount > 0)
<div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-5">
    <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0 mt-0.5">
        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-semibold text-amber-800">{{ $expiringCount }} essai{{ $expiringCount > 1 ? 's' : '' }} expirant dans moins de 3 jours</p>
        <p class="text-xs text-amber-600 mt-0.5">Ces médecins n'ont pas encore souscrit à un abonnement Pro.</p>
    </div>
    <a href="#table-section" class="text-xs font-semibold text-amber-700 hover:text-amber-800 flex items-center gap-1 mt-0.5">
        Voir <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </a>
</div>
@endif

{{-- KPI Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-0.5">{{ $totalDoctors }}</p>
        <p class="text-xs text-gray-500 font-medium">Médecins inscrits</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background:#dbeafe">
            <svg class="w-5 h-5" style="color:#0d2150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-0.5">{{ $proCount }}</p>
        <p class="text-xs text-gray-500 font-medium">Abonnements Pro</p>
        @if($mrr > 0)<p class="text-xs font-semibold mt-1.5" style="color:#0d2150">{{ $mrr }} MAD MRR</p>@endif
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-0.5">{{ $trialCount }}</p>
        <p class="text-xs text-gray-500 font-medium">En période d'essai</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4 {{ $expiringCount > 0 ? 'bg-red-50' : 'bg-gray-50' }}">
            <svg class="w-5 h-5 {{ $expiringCount > 0 ? 'text-red-500' : 'text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        </div>
        <p class="text-2xl font-bold {{ $expiringCount > 0 ? 'text-red-600' : 'text-gray-900' }} mb-0.5">{{ $expiringCount }}</p>
        <p class="text-xs text-gray-500 font-medium">Expirant dans ≤ 3 j</p>
    </div>
</div>

{{-- Distribution --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Répartition des plans</h2>
            <p class="text-xs text-gray-400 mt-0.5">Sur {{ $totalDoctors }} médecin{{ $totalDoctors !== 1 ? 's' : '' }} inscrit{{ $totalDoctors !== 1 ? 's' : '' }}</p>
        </div>
        @if($mrr > 0)
        <div class="text-right">
            <p class="text-xs text-gray-400">Revenu mensuel estimé</p>
            <p class="text-lg font-bold text-gray-900">{{ $mrr }} <span class="text-xs font-normal text-gray-400">MAD / mois</span></p>
        </div>
        @endif
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        @foreach([
            ['label'=>'Starter','count'=>$starterCount,'pct'=>$sPct,'color'=>'bg-emerald-500','dot'=>'bg-emerald-500'],
            ['label'=>'Pro',    'count'=>$proCount,    'pct'=>$pPct,'color'=>'bg-[#0d2150]',  'dot'=>'bg-[#0d2150]'],
            ['label'=>'En essai','count'=>$trialCount, 'pct'=>$tPct,'color'=>'bg-amber-400',  'dot'=>'bg-amber-400'],
        ] as $bar)
        <div>
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full {{ $bar['dot'] }}"></div>
                    <span class="text-sm font-medium text-gray-700">{{ $bar['label'] }}</span>
                </div>
                <span class="text-sm font-bold text-gray-900">{{ $bar['count'] }} <span class="text-xs font-normal text-gray-400">({{ $bar['pct'] }}%)</span></span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="{{ $bar['color'] }} h-2 rounded-full transition-all duration-700" style="width: {{ $bar['pct'] }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ── Configuration des plans ──────────────────────────────────── --}}
<div class="mb-2 flex items-center justify-between">
    <div>
        <h2 class="text-sm font-bold text-gray-900">Configuration des offres</h2>
        <p class="text-xs text-gray-400 mt-0.5">Les modifications sont reflétées en temps réel sur la page d'accueil</p>
    </div>
    <a href="/" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        Voir la page d'accueil
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

@php
$planDefs = [
    [
        'key'          => 'starter',
        'label'        => 'Starter',
        'badge'        => 'Gratuit / Essai',
        'accent'       => 'emerald',
        'price_monthly'=> (int)($planConfig['starter_price_monthly'] ?? 290),
        'price_annual' => (int)($planConfig['starter_price_annual']  ?? 232),
        'desc'         => $planConfig['starter_desc'] ?? 'Pour les médecins solo qui débutent',
        'features'     => json_decode($planConfig['starter_features_json'] ?? '[]', true) ?: [],
        'users'        => $starterCount,
        'is_licence'   => false,
    ],
    [
        'key'          => 'pro',
        'label'        => 'Pro',
        'badge'        => 'Populaire',
        'accent'       => 'navy',
        'price_monthly'=> (int)($planConfig['pro_price_monthly'] ?? 490),
        'price_annual' => (int)($planConfig['pro_price_annual']  ?? 392),
        'desc'         => $planConfig['pro_desc'] ?? 'Le plus populaire pour les cabinets actifs',
        'features'     => json_decode($planConfig['pro_features_json'] ?? '[]', true) ?: [],
        'users'        => $proCount,
        'is_licence'   => false,
    ],
    [
        'key'          => 'licence',
        'label'        => 'Licence',
        'badge'        => 'Paiement unique',
        'accent'       => 'gray',
        'price_monthly'=> (int)($planConfig['licence_price'] ?? 4900),
        'price_annual' => (int)($planConfig['licence_price'] ?? 4900),
        'desc'         => $planConfig['licence_desc']   ?? 'Paiement unique, hébergé chez vous',
        'suffix'       => $planConfig['licence_suffix'] ?? 'MAD · paiement unique',
        'features'     => json_decode($planConfig['licence_features_json'] ?? '[]', true) ?: [],
        'users'        => 0,
        'is_licence'   => true,
    ],
];
@endphp

@foreach($planDefs as $pd)
@php
$isNavy    = $pd['accent'] === 'navy';
$isGray    = $pd['accent'] === 'gray';
$isEmerald = $pd['accent'] === 'emerald';

// Pré-calculer les strings utilisées dans les :class Alpine pour éviter le bug Blade \B@
$editBtnActive   = $isNavy ? 'bg-white/20 text-white'                   : 'bg-gray-200 text-gray-700';
$editBtnInactive = $isNavy ? 'bg-white/10 text-blue-200 hover:bg-white/20' : 'bg-gray-100 text-gray-500 hover:bg-gray-200';
$featCheckBg     = $isNavy ? 'bg-blue-50'  : ($isEmerald ? 'bg-emerald-100'  : 'bg-gray-100');
$toggleOkClass   = $isNavy ? 'bg-blue-50 border-blue-200 text-blue-600'
                 : ($isEmerald ? 'bg-emerald-100 border-emerald-200 text-emerald-600'
                 :                'bg-gray-100 border-gray-200 text-gray-500');
@endphp

<div x-data="{
    editing: false,
    saving: false,
    saved: false,
    price_monthly: {{ $pd['price_monthly'] }},
    price_annual: {{ $pd['price_annual'] }},
    desc: {{ json_encode($pd['desc']) }},
    suffix: {{ json_encode($pd['suffix'] ?? '') }},
    features: {{ json_encode($pd['features']) }},
    newFeature: '',
    addFeature() {
        const t = this.newFeature.trim();
        if (t) { this.features.push({ text: t, ok: true }); this.newFeature = ''; }
    },
    removeFeature(i) { this.features.splice(i, 1); },
    toggleOk(i) { this.features[i].ok = !this.features[i].ok; },
    error: '',
    async save() {
        this.saving = true;
        this.error = '';
        const csrf = document.querySelector('meta[name=csrf-token]').content;
        const fd = new FormData();
        fd.append('_token', csrf);
        fd.append('plan', '{{ $pd['key'] }}');
        fd.append('desc', this.desc);
        @if($pd['is_licence'])
        fd.append('price', this.price_monthly);
        fd.append('suffix', this.suffix);
        @else
        fd.append('price_monthly', this.price_monthly);
        fd.append('price_annual', this.price_annual);
        @endif
        this.features.forEach((f, i) => {
            fd.append('feature_text[]', f.text);
            if (f.ok) fd.append('feature_ok[' + i + ']', '1');
        });
        try {
            const res = await fetch('/admin/plans/config', { method: 'POST', body: fd });
            const json = await res.json();
            if (json.ok) {
                this.saved = true; this.editing = false;
                setTimeout(() => this.saved = false, 3000);
            } else {
                this.error = json.error ?? 'Erreur inconnue';
            }
        } catch (e) {
            this.error = e.message;
        }
        this.saving = false;
    }
}" class="@if($isNavy) rounded-2xl overflow-hidden flex flex-col shadow-sm @else bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col @endif"
   @if($isNavy) style="border: 2px solid #0d2150;" @endif>

    {{-- Header --}}
    <div class="px-5 pt-5 pb-4 border-b @if($isNavy) @else border-gray-100 @endif"
         @if($isNavy) style="background:linear-gradient(135deg,#0a1628,#0d2150);border-color:#162a5a;" @endif>
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-widest
                    @if($isNavy) text-blue-300 @elseif($isEmerald) text-emerald-600 @else text-gray-500 @endif">
                    {{ $pd['label'] }}
                </span>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                    @if($isNavy) text-blue-200 bg-blue-900/40 @elseif($isEmerald) text-emerald-700 bg-emerald-50 border border-emerald-100 @else text-gray-500 bg-gray-100 @endif">
                    {{ $pd['badge'] }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span x-show="saved" x-transition
                      class="text-[10px] font-semibold px-2 py-0.5 rounded-full @if($isNavy) text-blue-200 bg-blue-900/40 border border-blue-400/30 @else text-emerald-600 bg-emerald-50 border border-emerald-100 @endif">
                    Enregistré ✓
                </span>
                <button @click="editing = !editing"
                        :class="editing ? '{{ $editBtnActive }}' : '{{ $editBtnInactive }}'"
                        class="flex items-center gap-1.5 text-[11px] font-semibold px-2.5 py-1 rounded-lg transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    <span x-text="editing ? 'Annuler' : 'Modifier'"></span>
                </button>
            </div>
        </div>

        {{-- Description (lecture) --}}
        <p x-show="!editing" class="text-xs mb-3 @if($isNavy) text-blue-300 @else text-gray-400 @endif" x-text="desc"></p>
        {{-- Description (édition) --}}
        <div x-show="editing" x-transition class="mb-3">
            <label class="block text-[10px] font-bold uppercase tracking-wider mb-1 @if($isNavy) text-blue-400 @else text-gray-400 @endif">Description</label>
            <input type="text" x-model="desc"
                   class="w-full text-xs px-3 py-2 rounded-lg border @if($isNavy) border-white/20 bg-white/10 text-white placeholder-blue-300/50 focus:bg-white/20 @else border-gray-200 bg-gray-50 text-gray-700 focus:bg-white @endif focus:outline-none transition-all">
        </div>

        {{-- Prix (lecture) --}}
        <div x-show="!editing">
            @if($pd['is_licence'])
            <p class="text-2xl font-bold @if($isNavy) text-white @else text-gray-900 @endif">
                <span x-text="price_monthly"></span>
                <span class="text-sm font-normal @if($isNavy) text-blue-300 @else text-gray-400 @endif"> MAD</span>
            </p>
            <p x-text="suffix" class="text-xs mt-0.5 @if($isNavy) text-blue-400 @else text-gray-400 @endif"></p>
            @else
            <p class="text-2xl font-bold @if($isNavy) text-white @else text-gray-900 @endif">
                <span x-text="price_monthly"></span>
                <span class="text-sm font-normal @if($isNavy) text-blue-300 @else text-gray-400 @endif"> MAD / mois</span>
            </p>
            <p class="text-xs mt-0.5 @if($isNavy) text-blue-400 @else text-gray-400 @endif">
                <span x-text="price_annual"></span> MAD / mois (annuel)
            </p>
            @endif
        </div>

        {{-- Prix (édition) --}}
        <div x-show="editing" x-transition>
            @if($pd['is_licence'])
            <label class="block text-[10px] font-bold uppercase tracking-wider mb-1 @if($isNavy) text-blue-400 @else text-gray-400 @endif">Prix (MAD)</label>
            <div class="flex items-center gap-2 mb-2">
                <input type="number" x-model.number="price_monthly" min="0"
                       class="w-28 px-3 py-2 text-lg font-bold rounded-xl border @if($isNavy) border-white/20 bg-white text-gray-900 @else border-gray-200 bg-gray-50 text-gray-900 focus:bg-white @endif focus:outline-none transition-all">
                <span class="text-sm @if($isNavy) text-blue-300 @else text-gray-400 @endif">MAD</span>
            </div>
            <label class="block text-[10px] font-bold uppercase tracking-wider mb-1 @if($isNavy) text-blue-400 @else text-gray-400 @endif">Libellé sous le prix</label>
            <input type="text" x-model="suffix"
                   class="w-full text-xs px-3 py-2 rounded-lg border @if($isNavy) border-white/20 bg-white/10 text-white placeholder-blue-300/50 focus:bg-white/20 @else border-gray-200 bg-gray-50 text-gray-700 focus:bg-white @endif focus:outline-none transition-all">
            @else
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider mb-1 @if($isNavy) text-blue-400 @else text-gray-400 @endif">Mensuel (MAD)</label>
                    <input type="number" x-model.number="price_monthly" min="0"
                           class="w-full px-3 py-2 text-base font-bold rounded-xl border @if($isNavy) border-white/20 bg-white text-gray-900 @else border-gray-200 bg-gray-50 text-gray-900 focus:bg-white @endif focus:outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider mb-1 @if($isNavy) text-blue-400 @else text-gray-400 @endif">Annuel (MAD)</label>
                    <input type="number" x-model.number="price_annual" min="0"
                           class="w-full px-3 py-2 text-base font-bold rounded-xl border @if($isNavy) border-white/20 bg-white text-gray-900 @else border-gray-200 bg-gray-50 text-gray-900 focus:bg-white @endif focus:outline-none transition-all">
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Features --}}
    <div class="px-5 py-4 flex-1 @if($isNavy) bg-white @endif">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2.5">Avantages</p>

        {{-- Lecture --}}
        <div x-show="!editing" class="space-y-2.5">
            <template x-for="(f, i) in features" :key="i">
                <div class="flex items-center gap-2.5 text-sm" :class="f.ok ? 'text-gray-700' : 'text-gray-300'">
                    <div class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0"
                         :class="f.ok ? '{{ $featCheckBg }}' : 'bg-gray-100'">
                        <template x-if="f.ok">
                            <svg class="w-2.5 h-2.5 @if($isNavy) text-blue-700 @elseif($isEmerald) text-emerald-600 @else text-gray-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </template>
                        <template x-if="!f.ok">
                            <svg class="w-2.5 h-2.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </template>
                    </div>
                    <span x-text="f.text"></span>
                </div>
            </template>
        </div>

        {{-- Édition --}}
        <div x-show="editing" x-transition class="space-y-1.5">
            <template x-for="(f, i) in features" :key="i">
                <div class="flex items-center gap-2 group">
                    {{-- Toggle ok/non-ok --}}
                    <button @click="toggleOk(i)"
                            :title="f.ok ? 'Marquer comme non inclus' : 'Marquer comme inclus'"
                            class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 transition-all border"
                            :class="f.ok ? '{{ $toggleOkClass }}' : 'bg-gray-50 border-gray-200 text-gray-300'">
                        <template x-if="f.ok">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <template x-if="!f.ok">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </template>
                    </button>
                    <input type="text" x-model="features[i].text"
                           class="flex-1 text-sm text-gray-700 px-2 py-1 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none focus:ring-1 focus:border-blue-400 focus:bg-white transition-all"
                           :class="f.ok ? '' : 'text-gray-400 line-through'">
                    <button @click="removeFeature(i)"
                            class="w-6 h-6 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center flex-shrink-0 opacity-0 group-hover:opacity-100 transition-all">
                        <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </template>
            {{-- Ajouter --}}
            <div class="flex items-center gap-2 pt-1">
                <div class="w-6 h-6 flex-shrink-0"></div>
                <input type="text" x-model="newFeature" @keydown.enter.prevent="addFeature()"
                       placeholder="Ajouter un avantage…"
                       class="flex-1 text-sm text-gray-500 px-2 py-1.5 rounded-lg border border-dashed border-gray-300 bg-transparent focus:outline-none focus:border-blue-400 focus:bg-white transition-all placeholder-gray-300">
                <button @click="addFeature()"
                        class="w-6 h-6 rounded-lg @if($isNavy) bg-blue-50 @elseif($isEmerald) bg-emerald-100 @else bg-gray-100 @endif flex items-center justify-center flex-shrink-0 transition-colors hover:opacity-80">
                    <svg class="w-3 h-3 @if($isNavy) text-blue-700 @elseif($isEmerald) text-emerald-700 @else text-gray-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="px-5 pb-5 @if($isNavy) bg-white @endif">
        {{-- Compteur (lecture) --}}
        <div x-show="!editing" class="flex items-center justify-between rounded-xl px-4 py-3
            @if($isNavy) @else @if($isEmerald) bg-emerald-50 border border-emerald-100 @else bg-gray-50 border border-gray-100 @endif @endif"
             @if($isNavy) style="background:#dbeafe;border:1px solid #bfdbfe;" @endif>
            <span class="text-xs font-medium @if($isNavy) @else @if($isEmerald) text-emerald-700 @else text-gray-500 @endif @endif"
                  @if($isNavy) style="color:#0d2150" @endif>
                Médecins sur ce plan
            </span>
            <span class="text-lg font-bold @if($isNavy) @else @if($isEmerald) text-emerald-700 @else text-gray-700 @endif @endif"
                  @if($isNavy) style="color:#0d2150" @endif>
                {{ $pd['users'] }}
            </span>
        </div>
        {{-- Erreur --}}
        <p x-show="error" x-text="error" class="text-xs text-red-500 mb-2 px-1"></p>
        {{-- Bouton Enregistrer --}}
        <button x-show="editing" @click="save()" :disabled="saving"
                class="w-full flex items-center justify-center gap-2 text-sm font-semibold text-white py-3 rounded-xl transition-all"
                style="background: @if($isNavy) linear-gradient(135deg,#0d2150,#0f3460) @elseif($isEmerald) linear-gradient(135deg,#059669,#10b981) @else linear-gradient(135deg,#4b5563,#6b7280) @endif;"
                :class="saving ? 'opacity-70 cursor-not-allowed' : 'hover:-translate-y-0.5'">
            <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
            </svg>
            <span x-text="saving ? 'Enregistrement…' : 'Enregistrer les modifications'"></span>
        </button>
    </div>

</div>
@endforeach

</div>

{{-- Table avec filtres --}}
<div id="table-section" x-data="{ filter: 'all' }" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex-1">
                <h2 class="text-sm font-bold text-gray-900">Détail par médecin</h2>
                <p class="text-xs text-gray-400 mt-0.5">{{ $totalDoctors }} médecin{{ $totalDoctors !== 1 ? 's' : '' }} au total</p>
            </div>
            <a href="/admin/medecins" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 self-start">
                Gérer les médecins
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
        <div class="flex items-center gap-1 mt-3 flex-wrap">
            @php
            $tabs = [
                ['key' => 'all',     'label' => 'Tous',        'count' => $totalDoctors],
                ['key' => 'pro',     'label' => 'Pro',          'count' => $proCount],
                ['key' => 'trial',   'label' => 'En essai',     'count' => $trialCount],
                ['key' => 'expired', 'label' => 'Essai expiré', 'count' => $starterCount - $trialCount],
            ];
            @endphp
            @foreach($tabs as $tab)
            <button @click="filter = '{{ $tab['key'] }}'"
                    :class="filter === '{{ $tab['key'] }}' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                {{ $tab['label'] }}
                <span :class="filter === '{{ $tab['key'] }}' ? 'bg-white/20 text-white' : 'bg-white text-gray-500'"
                      class="text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $tab['count'] }}</span>
            </button>
            @endforeach
        </div>
    </div>

    @if(count($doctors) === 0)
    <div class="px-6 py-14 text-center">
        <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="text-sm text-gray-400">Aucun médecin inscrit.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/60">
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Médecin</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Plan</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Statut essai</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Jours restants</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Fin d'essai</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Inscrit le</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($doctors as $d)
                @php
                $plan        = $d['plan'] ?? 'starter';
                $trialActive = $d['trial_active'];
                $daysLeft    = $d['days_left'] ?? 0;
                $urgent      = $trialActive && $daysLeft <= 3;
                @endphp
                <tr class="hover:bg-gray-50/60 transition-colors"
                    data-plan="{{ $plan }}"
                    data-trial="{{ $trialActive ? '1' : '0' }}"
                    x-show="filter === 'all'
                        || (filter === 'pro'     && $el.dataset.plan === 'pro')
                        || (filter === 'trial'   && $el.dataset.trial === '1')
                        || (filter === 'expired' && $el.dataset.trial === '0' && $el.dataset.plan !== 'pro')"
                    x-transition>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                 style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#0d2150">
                                {{ strtoupper(substr($d['first_name'] ?? $d['email'] ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ trim(($d['first_name'] ?? '') . ' ' . ($d['last_name'] ?? '')) ?: '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $d['email'] ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5">
                        @if($plan === 'pro')
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#dbeafe;color:#0d2150;border:1px solid #bfdbfe;">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Pro
                        </span>
                        @else
                        <span class="text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full">Starter</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5">
                        @if($trialActive)
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full {{ $urgent ? 'text-red-600 bg-red-50 border border-red-100' : 'text-amber-600 bg-amber-50 border border-amber-100' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $urgent ? 'bg-red-400' : 'bg-amber-400' }} animate-pulse"></span>
                            {{ $urgent ? 'Urgent' : 'Actif' }}
                        </span>
                        @elseif($plan === 'pro')
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full">Pro actif</span>
                        @else
                        <span class="text-xs text-gray-400 bg-gray-50 border border-gray-200 px-2.5 py-1 rounded-full">Expiré</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5">
                        @if($trialActive)
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-gray-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full {{ $urgent ? 'bg-red-400' : 'bg-amber-400' }}" style="width: {{ min(100, round($daysLeft / 14 * 100)) }}%"></div>
                            </div>
                            <span class="text-xs font-semibold {{ $urgent ? 'text-red-600' : 'text-gray-700' }}">{{ $daysLeft }}j</span>
                        </div>
                        @else
                        <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-xs text-gray-500">{{ $d['trial_ends_fmt'] ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-xs text-gray-400">{{ $d['created_at_fmt'] ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
