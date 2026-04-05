@extends('layouts.admin')

@section('title', 'Tableau de bord — Admin')

@section('content')
    @php
        $firstName = explode(' ', auth()->user()->name)[0];
        $membersFormatted = number_format($membersCount, 0, ',', ' ');
        $trendLine = function (?float $pct): string {
            if ($pct === null) {
                return 'text-zinc-500';
            }

            return $pct >= 0 ? 'text-emerald-600' : 'text-red-600';
        };
        $trendText = function (?float $pct): string {
            if ($pct === null) {
                return '—';
            }
            $sign = $pct > 0 ? '+' : '';

            return $sign.number_format($pct, 1, ',', ' ').'%';
        };
    @endphp

    <div class="mx-auto max-w-7xl">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">Bonjour, {{ $firstName }}</h1>
                <p class="mt-1 text-zinc-600">Voici le résumé de l’activité de votre salle de sport aujourd’hui.</p>
            </div>
            <div class="inline-flex items-center gap-2 self-start rounded-[10px] border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 shadow-sm">
                <svg class="size-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span>Aujourd’hui, {{ now()->locale('fr')->isoFormat('D MMM YYYY') }}</span>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]">
                <div class="flex items-start justify-between gap-2">
                    <span class="text-sm font-medium text-zinc-500">Membres actifs</span>
                    <span class="flex size-10 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-bold tabular-nums text-zinc-900">{{ $membersFormatted }}</p>
                <p class="mt-1 text-sm font-medium {{ $trendLine($trends['members'] ?? null) }}">
                    {{ $trendText($trends['members'] ?? null) }} <span class="font-normal text-zinc-500">nouveaux inscrits (mois)</span>
                </p>
            </article>

            <article class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]">
                <div class="flex items-start justify-between gap-2">
                    <span class="text-sm font-medium text-zinc-500">Vidéos</span>
                    <span class="flex size-10 items-center justify-center rounded-lg bg-red-100 text-brand">
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-bold tabular-nums text-zinc-900">{{ number_format($videoCount, 0, ',', ' ') }}</p>
                <p class="mt-1 text-sm font-medium {{ $trendLine($trends['videos'] ?? null) }}">
                    {{ $trendText($trends['videos'] ?? null) }} <span class="font-normal text-zinc-500">ajouts ce mois</span>
                </p>
            </article>

            <article class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]">
                <div class="flex items-start justify-between gap-2">
                    <span class="text-sm font-medium text-zinc-500">Programmes complétés</span>
                    <span class="flex size-10 items-center justify-center rounded-lg bg-violet-100 text-violet-600">
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.874a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-bold tabular-nums text-zinc-900">{{ number_format($progressCount, 0, ',', ' ') }}</p>
                <p class="mt-1 text-sm font-medium {{ $trendLine($trends['progress'] ?? null) }}">
                    {{ $trendText($trends['progress'] ?? null) }} <span class="font-normal text-zinc-500">progressions (mois)</span>
                </p>
            </article>

            <article class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]">
                <div class="flex items-start justify-between gap-2">
                    <span class="text-sm font-medium text-zinc-500">Revenus (catalogue)</span>
                    <span class="flex size-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-bold tabular-nums text-zinc-900">{{ $revenueDisplay }}</p>
                <p class="mt-1 text-sm font-medium {{ $trendLine($trends['revenue'] ?? null) }}">
                    {{ $trendText($trends['revenue'] ?? null) }} <span class="font-normal text-zinc-500">CA ce mois</span>
                </p>
            </article>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-5">
            <section class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:col-span-3">
                <h2 class="text-base font-semibold text-zinc-900">Engagement utilisateurs</h2>
                <p class="mt-1 text-sm text-zinc-500">Nouveaux membres et vidéos ajoutées par mois (12 derniers mois)</p>
                <div class="relative mt-4 h-56 w-full min-w-[280px]">
                    <canvas id="chart-engagement" aria-label="Graphique d’engagement"></canvas>
                </div>
            </section>

            <section class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:col-span-2">
                <h2 class="text-base font-semibold text-zinc-900">Répartition programmes</h2>
                <p class="mt-1 text-sm text-zinc-500">Par catégorie (pondération vidéos)</p>
                <div class="mt-6 flex flex-col items-center gap-6 sm:flex-row sm:justify-center">
                    <div class="relative size-44 shrink-0">
                        <canvas id="chart-programs" aria-label="Répartition des programmes"></canvas>
                    </div>
                    <ul class="grid w-full gap-2 text-sm sm:max-w-[200px]">
                        @foreach ($donutSegments as $seg)
                            <li class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-2 text-zinc-600">
                                    <span class="size-2.5 shrink-0 rounded-sm" style="background-color: {{ $seg['color'] }}"></span>
                                    {{ $seg['label'] }}
                                </span>
                                <span class="font-medium tabular-nums text-zinc-900">{{ $seg['pct'] }}%</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-5">
            <section class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:col-span-2">
                <h2 class="text-base font-semibold text-zinc-900">Actions rapides</h2>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <a
                        href="{{ route('admin.videos.create') }}"
                        class="flex flex-col items-center justify-center gap-2 rounded-[10px] border border-sky-200 bg-sky-50/80 px-4 py-8 text-center text-sm font-semibold text-sky-800 transition hover:bg-sky-100"
                    >
                        <svg class="size-8 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Ajouter vidéo
                    </a>
                    <a
                        href="{{ route('admin.programs.create') }}"
                        class="flex flex-col items-center justify-center gap-2 rounded-[10px] border border-sky-200 bg-sky-50/80 px-4 py-8 text-center text-sm font-semibold text-sky-800 transition hover:bg-sky-100"
                    >
                        <svg class="size-8 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Créer prog.
                    </a>
                </div>
            </section>

            <section class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:col-span-3">
                <div class="flex items-start justify-between gap-2">
                    <h2 class="text-base font-semibold text-zinc-900">Nouveaux inscrits</h2>
                    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-brand hover:underline">Voir tout</a>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full min-w-[480px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-zinc-100 text-xs font-medium uppercase tracking-wide text-zinc-400">
                                <th class="pb-3 pr-4 font-medium">Utilisateur</th>
                                <th class="pb-3 pr-4 font-medium">Plan</th>
                                <th class="pb-3 pr-4 font-medium">Date d’inscription</th>
                                <th class="pb-3 font-medium">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse ($recentUsers as $u)
                                <tr class="transition hover:bg-zinc-50/80">
                                    <td class="py-3 pr-4">
                                        <span class="font-medium text-zinc-900">{{ $u->name }}</span>
                                        <br>
                                        <span class="text-xs text-zinc-500">{{ $u->email }}</span>
                                    </td>
                                    <td class="py-3 pr-4 text-zinc-700">{{ $u->role?->name === 'Client' ? 'Premium' : ($u->role?->name ?? '—') }}</td>
                                    <td class="py-3 pr-4 text-zinc-600">{{ $u->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                    <td class="py-3">
                                        <span class="font-medium text-emerald-600">Actif</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-zinc-500">Aucun inscrit récent.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    @push('scripts')
        <script type="application/json" id="admin-dashboard-config">@json($chartConfig)</script>
        @vite(['resources/js/admin-dashboard.js'])
    @endpush
@endsection
