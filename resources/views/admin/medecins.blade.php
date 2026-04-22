@extends('layouts.admin')
@section('title', 'Médecins — MediAssist Admin')
@section('page-title', 'Médecins')

@section('content')

<div x-data="{
    search: '',
    tab: 'all',
    selected: null,
    doctors: {{ json_encode($doctors) }},
    get filtered() {
        return this.doctors.filter(d => {
            const name = ((d.first_name ?? '') + ' ' + (d.last_name ?? '') + ' ' + (d.email ?? '') + ' ' + (d.specialty ?? '') + ' ' + (d.city ?? '') + ' ' + (d.cabinet_name ?? '')).toLowerCase();
            const matchSearch = this.search === '' || name.includes(this.search.toLowerCase());
            const matchTab = this.tab === 'all'
                || (this.tab === 'pro'     &&  (d.plan ?? '') === 'pro')
                || (this.tab === 'trial'   &&   d.trial_active)
                || (this.tab === 'expired' && !d.trial_active && (d.plan ?? 'starter') !== 'pro');
            return matchSearch && matchTab;
        });
    },
    open(d) { this.selected = d; },
    close() { this.selected = null; }
}" @keydown.escape.window="close()">

{{-- ── Stats ──────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $statCards = [
        ['label' => 'Total inscrits',  'value' => count($doctors), 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => '#0d2150', 'light' => '#eff6ff', 'ring' => '#bfdbfe'],
        ['label' => 'En essai actif',  'value' => $trialCount,     'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',  'color' => '#d97706', 'light' => '#fffbeb', 'ring' => '#fde68a'],
        ['label' => 'Plan Starter',    'value' => $starterCount,   'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'color' => '#059669', 'light' => '#ecfdf5', 'ring' => '#a7f3d0'],
        ['label' => 'Plan Pro',        'value' => $proCount,       'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'color' => '#0d2150', 'light' => '#eff6ff', 'ring' => '#bfdbfe'],
    ];
    @endphp
    @foreach($statCards as $s)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-3"
             style="background:{{ $s['light'] }}; border:1px solid {{ $s['ring'] }}">
            <svg style="width:15px;height:15px;color:{{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 leading-none mb-1">{{ $s['value'] }}</p>
        <p class="text-xs text-gray-400 font-medium">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- ── Barre recherche + tabs ─────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 mb-4">
    {{-- Recherche --}}
    <div class="relative mb-3">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input type="text" x-model="search" placeholder="Nom, email, spécialité, ville…"
               class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-300 focus:bg-white transition-all">
    </div>

    {{-- Tabs --}}
    <div class="flex items-center justify-between gap-2 flex-wrap">
        <div class="flex items-center gap-1 flex-wrap">
            @php
            $tabs = [
                ['key' => 'all',     'label' => 'Tous',        'count' => count($doctors)],
                ['key' => 'pro',     'label' => 'Pro',          'count' => $proCount],
                ['key' => 'trial',   'label' => 'En essai',     'count' => $trialCount],
                ['key' => 'expired', 'label' => 'Essai expiré', 'count' => $starterCount - $trialCount],
            ];
            @endphp
            @foreach($tabs as $tab)
            <button @click="tab = '{{ $tab['key'] }}'"
                    :class="tab === '{{ $tab['key'] }}'
                        ? 'bg-gray-900 text-white'
                        : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                {{ $tab['label'] }}
                <span :class="tab === '{{ $tab['key'] }}' ? 'bg-white/20 text-white' : 'bg-white text-gray-500'"
                      class="text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $tab['count'] }}</span>
            </button>
            @endforeach
        </div>
        <div class="flex items-center gap-1 text-xs text-gray-400 whitespace-nowrap flex-shrink-0">
            <span x-text="filtered.length" class="font-bold text-gray-600"></span>
            <span>résultat<span x-show="filtered.length !== 1">s</span></span>
        </div>
    </div>
</div>

{{-- ── Table (desktop) ─────────────────────────────────────────── --}}
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-5 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Médecin</th>
                <th class="text-left px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Spécialité & Cabinet</th>
                <th class="text-left px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Plan</th>
                <th class="text-left px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Statut</th>
                <th class="text-left px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Inscription</th>
                <th class="px-4 py-3.5"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <template x-if="filtered.length === 0">
                <tr>
                    <td colspan="6" class="px-5 py-14 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">Aucun médecin trouvé</p>
                            <p class="text-xs text-gray-300">Essayez de modifier vos filtres</p>
                        </div>
                    </td>
                </tr>
            </template>

            <template x-for="d in filtered" :key="d.uid ?? d.email">
                <tr @click="open(d)"
                    class="hover:bg-blue-50/40 transition-colors cursor-pointer group"
                    :class="selected && selected.uid === d.uid ? 'bg-blue-50/60' : ''">

                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                 style="background: linear-gradient(135deg, #0d2150, #0f3460);"
                                 x-text="((d.first_name ?? d.email ?? '?')[0]).toUpperCase()">
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate"
                                   x-text="'Dr. ' + (((d.first_name ?? '') + ' ' + (d.last_name ?? '')).trim() || '—')"></p>
                                <p class="text-xs text-gray-400 truncate" x-text="d.email ?? '—'"></p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3.5">
                        <p class="text-sm text-gray-700 font-medium truncate max-w-[180px]" x-text="d.specialty || '—'"></p>
                        <p class="text-xs text-gray-400 truncate max-w-[180px]">
                            <span x-text="[d.cabinet_name, d.city].filter(Boolean).join(' · ') || '—'"></span>
                        </p>
                    </td>

                    <td class="px-4 py-3.5">
                        <span :class="(d.plan ?? 'starter') === 'pro'
                                ? 'text-white border-transparent'
                                : 'bg-slate-100 text-slate-500 border-slate-200'"
                              :style="(d.plan ?? 'starter') === 'pro' ? 'background:linear-gradient(135deg,#0d2150,#0f3460)' : ''"
                              class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full border uppercase tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full"
                                  :class="(d.plan ?? 'starter') === 'pro' ? 'bg-blue-300' : 'bg-slate-400'"></span>
                            <span x-text="d.plan ?? 'Starter'"></span>
                        </span>
                    </td>

                    <td class="px-4 py-3.5">
                        <template x-if="(d.plan ?? 'starter') === 'pro'">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Actif
                            </span>
                        </template>
                        <template x-if="(d.plan ?? 'starter') !== 'pro' && d.trial_active">
                            <div>
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-amber-700 bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>Essai
                                </span>
                                <p class="text-[10px] text-gray-400 mt-0.5" x-text="'Fin : ' + (d.trial_ends_fmt ?? '—')"></p>
                            </div>
                        </template>
                        <template x-if="(d.plan ?? 'starter') !== 'pro' && !d.trial_active">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-gray-400 bg-gray-50 border border-gray-200 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>Expiré
                            </span>
                        </template>
                    </td>

                    <td class="px-4 py-3.5 text-xs text-gray-400" x-text="d.created_at_fmt ?? '—'"></td>

                    <td class="px-4 py-3.5 text-right">
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors inline-block"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </td>

                </tr>
            </template>
        </tbody>
    </table>
</div>

{{-- ── Cards (mobile) ──────────────────────────────────────────── --}}
<div class="md:hidden space-y-3">
    <template x-if="filtered.length === 0">
        <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center">
            <p class="text-sm text-gray-400">Aucun médecin trouvé</p>
        </div>
    </template>
    <template x-for="d in filtered" :key="d.uid ?? d.email">
        <div @click="open(d)"
             class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 cursor-pointer hover:border-blue-200 hover:shadow-md transition-all active:scale-[0.99]">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #0d2150, #0f3460);"
                     x-text="((d.first_name ?? d.email ?? '?')[0]).toUpperCase()"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate"
                       x-text="'Dr. ' + (((d.first_name ?? '') + ' ' + (d.last_name ?? '')).trim() || '—')"></p>
                    <p class="text-xs text-gray-400 truncate" x-text="d.email ?? '—'"></p>
                </div>
                <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <div class="grid grid-cols-2 gap-x-4 gap-y-1.5 text-xs pt-3 border-t border-gray-50">
                <div><span class="text-gray-400">Spécialité · </span><span class="text-gray-700 font-medium" x-text="d.specialty || '—'"></span></div>
                <div><span class="text-gray-400">Ville · </span><span class="text-gray-700 font-medium" x-text="d.city || '—'"></span></div>
                <div><span class="text-gray-400">Inscrit · </span><span class="text-gray-700 font-medium" x-text="d.created_at_fmt || '—'"></span></div>
                <div><span :class="d.trial_active ? 'text-amber-600 font-semibold' : 'text-gray-400'"
                           x-text="d.trial_active ? 'Essai actif' : 'Essai expiré'"></span></div>
            </div>
        </div>
    </template>
</div>

{{-- ── Overlay + Panel détail ───────────────────────────────────── --}}
<div x-show="selected" x-cloak>

    {{-- Backdrop --}}
    <div @click="close()"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40"></div>

    {{-- Panel --}}
    <div x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 translate-x-8"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-8"
         class="fixed top-0 right-0 h-full w-full sm:w-[420px] bg-white shadow-2xl z-50 flex flex-col overflow-hidden">

        {{-- En-tête panel --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 flex-shrink-0"
             style="background: linear-gradient(135deg, #0a1628 0%, #0d2150 55%, #0f3460 100%);">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center text-base font-bold text-white flex-shrink-0"
                     x-text="((selected?.first_name ?? selected?.email ?? '?')[0]).toUpperCase()">
                </div>
                <div>
                    <p class="text-sm font-bold text-white"
                       x-text="'Dr. ' + (((selected?.first_name ?? '') + ' ' + (selected?.last_name ?? '')).trim() || '—')"></p>
                    <p class="text-xs text-blue-200/70 truncate max-w-[230px]" x-text="selected?.email ?? ''"></p>
                </div>
            </div>
            <button @click="close()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Contenu scrollable --}}
        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">

            {{-- Statut abonnement --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Abonnement</p>
                <div class="flex items-center gap-3 p-4 rounded-xl border border-gray-100 bg-gray-50/50">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm font-bold text-gray-900"
                                  x-text="'Plan ' + ((selected?.plan ?? 'starter').charAt(0).toUpperCase() + (selected?.plan ?? 'starter').slice(1))"></span>
                            <span x-show="selected?.trial_active"
                                  class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-full uppercase tracking-wide">
                                Essai actif
                            </span>
                            <span x-show="!selected?.trial_active && (selected?.plan ?? 'starter') !== 'pro'"
                                  class="text-[10px] font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-full uppercase tracking-wide">
                                Expiré
                            </span>
                            <span x-show="(selected?.plan ?? '') === 'pro'"
                                  class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full uppercase tracking-wide">
                                Actif
                            </span>
                        </div>
                        <p class="text-xs text-gray-400"
                           x-text="selected?.trial_active ? 'Fin d\'essai : ' + (selected?.trial_ends_fmt ?? '—') : (selected?.plan === 'pro' ? 'Accès complet' : 'Essai terminé')">
                        </p>
                    </div>
                </div>
            </div>

            {{-- Informations personnelles --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Informations personnelles</p>
                <div class="space-y-0 rounded-xl border border-gray-100 overflow-hidden">
                    @php
                    $rows = [
                        ['label' => 'Prénom',     'key' => 'first_name'],
                        ['label' => 'Nom',        'key' => 'last_name'],
                        ['label' => 'Email',      'key' => 'email'],
                        ['label' => 'Téléphone',  'key' => 'phone'],
                        ['label' => 'Spécialité', 'key' => 'specialty'],
                    ];
                    @endphp
                    @foreach($rows as $i => $row)
                    <div class="flex items-center justify-between px-4 py-3 {{ $i > 0 ? 'border-t border-gray-50' : '' }}">
                        <span class="text-xs text-gray-400 flex-shrink-0 w-24">{{ $row['label'] }}</span>
                        <span class="text-xs font-medium text-gray-800 text-right truncate ml-4"
                              x-text="selected?.{{ $row['key'] }} || '—'"></span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Cabinet --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Cabinet médical</p>
                <div class="space-y-0 rounded-xl border border-gray-100 overflow-hidden">
                    @php
                    $cabinetRows = [
                        ['label' => 'Nom du cabinet', 'key' => 'cabinet_name'],
                        ['label' => 'Ville',          'key' => 'city'],
                    ];
                    @endphp
                    @foreach($cabinetRows as $i => $row)
                    <div class="flex items-center justify-between px-4 py-3 {{ $i > 0 ? 'border-t border-gray-50' : '' }}">
                        <span class="text-xs text-gray-400 flex-shrink-0 w-24">{{ $row['label'] }}</span>
                        <span class="text-xs font-medium text-gray-800 text-right truncate ml-4"
                              x-text="selected?.{{ $row['key'] }} || '—'"></span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Compte --}}
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2.5">Compte</p>
                <div class="space-y-0 rounded-xl border border-gray-100 overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-xs text-gray-400 flex-shrink-0 w-24">UID Firebase</span>
                        <span class="text-[10px] font-mono text-gray-500 text-right truncate ml-4 max-w-[200px]"
                              x-text="selected?.uid || '—'"></span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3 border-t border-gray-50">
                        <span class="text-xs text-gray-400 flex-shrink-0 w-24">Inscrit le</span>
                        <span class="text-xs font-medium text-gray-800 text-right"
                              x-text="selected?.created_at_fmt || '—'"></span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3 border-t border-gray-50">
                        <span class="text-xs text-gray-400 flex-shrink-0 w-24">Fin d'essai</span>
                        <span class="text-xs font-medium text-gray-800 text-right"
                              x-text="selected?.trial_ends_fmt || '—'"></span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer panel --}}
        <div class="px-6 py-4 border-t border-gray-100 flex-shrink-0">
            <a :href="'mailto:' + (selected?.email ?? '')"
               class="w-full flex items-center justify-center gap-2 text-xs font-bold text-white py-3 rounded-xl transition-colors"
               style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contacter ce médecin
            </a>
        </div>

    </div>
</div>

</div>
@endsection
