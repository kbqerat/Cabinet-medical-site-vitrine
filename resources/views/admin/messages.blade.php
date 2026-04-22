@extends('layouts.admin')
@section('title', 'Messages — MediAssist Admin')
@section('page-title', 'Messages')
@section('page-subtitle', 'Formulaires de contact reçus via le site')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    @php
    $statCards = [
        ['label' => 'Total messages',    'value' => count($messages), 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => '#0d2150', 'bg' => '#dbeafe'],
        ['label' => 'Formulaire contact','value' => $contactCount,    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => '#059669', 'bg' => '#d1fae5'],
        ['label' => 'Widget chat',       'value' => $widgetCount,     'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'color' => '#7c3aed', 'bg' => '#ede9fe'],
    ];
    @endphp
    @foreach($statCards as $s)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3" style="background:{{ $s['bg'] }}">
            <svg style="width:16px;height:16px;color:{{ $s['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-0.5">{{ $s['value'] }}</p>
        <p class="text-xs text-gray-500 font-medium">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

@if(count($messages) === 0)
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-20 text-center">
    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>
    <p class="text-sm font-semibold text-gray-700 mb-1">Aucun message reçu</p>
    <p class="text-xs text-gray-400">Les prochains messages soumis via le site apparaîtront ici.</p>
</div>
@else

<div x-data="{
    search: '',
    tab: 'all',
    page: 1,
    perPage: 5,
    selected: null,
    messages: {{ json_encode($messages) }},
    get filtered() {
        const s = this.search.toLowerCase();
        return this.messages.filter(m => {
            const txt = ((m.name ?? '') + ' ' + (m.email ?? '') + ' ' + (m.subject ?? '') + ' ' + (m.message ?? '')).toLowerCase();
            const matchSearch = s === '' || txt.includes(s);
            const matchTab = this.tab === 'all' || m.source === this.tab;
            return matchSearch && matchTab;
        });
    },
    get paginated() {
        const start = (this.page - 1) * this.perPage;
        return this.filtered.slice(start, start + this.perPage);
    },
    get totalPages() {
        return Math.max(1, Math.ceil(this.filtered.length / this.perPage));
    },
    get pageNumbers() {
        const total = this.totalPages;
        const cur   = this.page;
        if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
        const pages = new Set([1, total, cur]);
        if (cur > 1) pages.add(cur - 1);
        if (cur < total) pages.add(cur + 1);
        return [...pages].sort((a, b) => a - b);
    },
    setTab(t) { this.tab = t; this.page = 1; this.selected = null; },
    setSearch(v) { this.search = v; this.page = 1; },
    counts: {
        all:     {{ count($messages) }},
        contact: {{ $contactCount }},
        widget:  {{ $widgetCount }},
    }
}">

    {{-- Barre recherche + tabs --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 mb-4">
        <div class="relative mb-3">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" @input="setSearch($event.target.value)" :value="search"
                   placeholder="Nom, email, sujet, message…"
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/10 focus:border-blue-300 focus:bg-white transition-all">
        </div>
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <div class="flex items-center gap-1">
                @foreach([
                    ['key' => 'all',     'label' => 'Tous',    'count' => count($messages)],
                    ['key' => 'contact', 'label' => 'Contact', 'count' => $contactCount],
                    ['key' => 'widget',  'label' => 'Widget',  'count' => $widgetCount],
                ] as $t)
                <button @click="setTab('{{ $t['key'] }}')"
                        :class="tab === '{{ $t['key'] }}' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                    {{ $t['label'] }}
                    <span :class="tab === '{{ $t['key'] }}' ? 'bg-white/20 text-white' : 'bg-white text-gray-500'"
                          class="text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $t['count'] }}</span>
                </button>
                @endforeach
            </div>
            <span class="text-xs text-gray-400">
                <span x-text="filtered.length"></span> résultat<span x-show="filtered.length !== 1">s</span>
            </span>
        </div>
    </div>

    {{-- Layout liste + détail --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- Colonne liste --}}
        <div class="lg:col-span-2 flex flex-col gap-3">

            {{-- Empty state filtré --}}
            <template x-if="filtered.length === 0">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
                    <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">Aucun message trouvé</p>
                </div>
            </template>

            {{-- Messages paginés --}}
            <template x-for="(m, i) in paginated" :key="m.id ?? i">
                <div @click="selected = m"
                     :class="selected && selected.id === m.id
                        ? 'border-blue-300 bg-blue-50/50 ring-1 ring-blue-200'
                        : 'border-gray-100 bg-white hover:border-gray-200 hover:shadow-md'"
                     class="rounded-2xl border shadow-sm p-4 cursor-pointer transition-all">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                             style="background: linear-gradient(135deg, #0d2150, #0f3460);"
                             x-text="(m.name ?? m.email ?? '?')[0].toUpperCase()"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-0.5">
                                <p class="font-semibold text-gray-900 text-sm truncate" x-text="m.name || '—'"></p>
                                <span :class="m.source === 'widget'
                                        ? 'bg-violet-50 text-violet-600 border-violet-100'
                                        : 'bg-blue-50 text-blue-600 border-blue-100'"
                                      class="text-[10px] font-bold px-2 py-0.5 rounded-full border flex-shrink-0"
                                      x-text="m.source === 'widget' ? 'Widget' : 'Contact'"></span>
                            </div>
                            <p class="text-xs text-gray-400 truncate" x-text="m.email || '—'"></p>
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed" x-text="m.message || ''"></p>
                            <p class="text-[10px] text-gray-300 mt-1.5" x-text="m.created_at_fmt || ''"></p>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Pagination --}}
            <div x-show="totalPages > 1" class="flex items-center justify-between pt-1">
                <button @click="page = Math.max(1, page - 1)" :disabled="page === 1"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3 py-2 rounded-xl hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Préc.
                </button>

                <div class="flex items-center gap-1">
                    <template x-for="(p, idx) in pageNumbers" :key="idx">
                        <template x-if="idx > 0 && pageNumbers[idx] - pageNumbers[idx-1] > 1">
                            <span class="text-xs text-gray-300 px-1">…</span>
                        </template>
                        <button @click="page = p; selected = null"
                                :class="page === p
                                    ? 'bg-gray-900 text-white'
                                    : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50'"
                                class="w-8 h-8 text-xs font-bold rounded-lg transition-all"
                                x-text="p"></button>
                    </template>
                </div>

                <button @click="page = Math.min(totalPages, page + 1)" :disabled="page === totalPages"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3 py-2 rounded-xl hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                    Suiv.
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- Info pagination --}}
            <div x-show="totalPages > 1" class="text-center">
                <p class="text-[10px] text-gray-300">
                    Page <span x-text="page"></span> / <span x-text="totalPages"></span>
                    · <span x-text="filtered.length"></span> messages
                </p>
            </div>

        </div>

        {{-- Colonne détail --}}
        <div class="lg:col-span-3">

            {{-- Placeholder --}}
            <template x-if="!selected">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm h-full flex flex-col items-center justify-center py-24 text-center px-6">
                    <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-400 mb-1">Aucun message sélectionné</p>
                    <p class="text-xs text-gray-300">Cliquez sur un message pour le lire</p>
                </div>
            </template>

            {{-- Détail --}}
            <template x-if="selected">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-4">

                    {{-- Header --}}
                    <div class="px-6 py-5 border-b border-gray-100" style="background: linear-gradient(135deg, #f8faff, #f0f4ff);">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-base font-bold text-white flex-shrink-0"
                                     style="background: linear-gradient(135deg, #0d2150, #0f3460);"
                                     x-text="(selected.name ?? selected.email ?? '?')[0].toUpperCase()"></div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm" x-text="selected.name || '—'"></p>
                                    <p class="text-xs text-gray-400 mt-0.5" x-text="selected.email || '—'"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span :class="selected.source === 'widget'
                                        ? 'bg-violet-100 text-violet-700 border-violet-200'
                                        : 'bg-blue-100 text-blue-700 border-blue-200'"
                                      class="text-[10px] font-bold px-2.5 py-1 rounded-full border"
                                      x-text="selected.source === 'widget' ? 'Widget chat' : 'Formulaire contact'"></span>
                                <button @click="selected = null"
                                        class="w-7 h-7 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Méta --}}
                    <div class="grid grid-cols-2 divide-x divide-y divide-gray-50 border-b border-gray-100">
                        <template x-if="selected.subject">
                            <div class="px-5 py-3.5">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Sujet</p>
                                <p class="text-sm text-gray-800 font-medium" x-text="selected.subject"></p>
                            </div>
                        </template>
                        <div class="px-5 py-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Reçu le</p>
                            <p class="text-sm text-gray-700" x-text="selected.created_at_fmt || '—'"></p>
                        </div>
                        <template x-if="selected.phone">
                            <div class="px-5 py-3.5">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Téléphone</p>
                                <p class="text-sm text-gray-700" x-text="selected.phone"></p>
                            </div>
                        </template>
                        <template x-if="selected.specialty">
                            <div class="px-5 py-3.5">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Spécialité</p>
                                <p class="text-sm text-gray-700" x-text="selected.specialty"></p>
                            </div>
                        </template>
                        <template x-if="selected.city">
                            <div class="px-5 py-3.5">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Ville</p>
                                <p class="text-sm text-gray-700" x-text="selected.city"></p>
                            </div>
                        </template>
                    </div>

                    {{-- Corps --}}
                    <div class="px-6 py-5">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-3">Message</p>
                        <div class="bg-gray-50 rounded-xl px-4 py-4 border border-gray-100">
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap" x-text="selected.message || '—'"></p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="px-6 pb-5 flex items-center gap-3">
                        <a :href="'mailto:' + (selected.email ?? '') + '?subject=Re: ' + encodeURIComponent(selected.subject ?? 'Votre message MediAssist')"
                           class="inline-flex items-center gap-2 text-xs font-semibold text-white px-4 py-2.5 rounded-xl hover:-translate-y-0.5 transition-all"
                           style="background: linear-gradient(135deg, #0d2150, #0f3460);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                            Répondre
                        </a>
                        <a :href="'mailto:' + (selected.email ?? '')"
                           class="inline-flex items-center gap-2 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 px-4 py-2.5 rounded-xl transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Nouveau mail
                        </a>
                    </div>

                </div>
            </template>

        </div>
    </div>

</div>
@endif

@endsection
