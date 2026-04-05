@extends('layouts.admin')

@section('title', 'Statistiques — Admin')

@section('content')
    @php
        $toneIconWrap = [
            'sky' => 'bg-sky-100 text-sky-600 ring-sky-200/60',
            'amber' => 'bg-amber-100 text-amber-600 ring-amber-200/60',
            'violet' => 'bg-violet-100 text-violet-600 ring-violet-200/60',
            'brand' => 'bg-red-100 text-brand ring-red-200/60',
            'emerald' => 'bg-emerald-100 text-emerald-600 ring-emerald-200/60',
            'rose' => 'bg-rose-100 text-rose-600 ring-rose-200/60',
        ];
        $hasOrdersChart = count($chartConfig['ordersByStatus']['labels'] ?? []) > 0;
        $hasTopPrograms = count($chartConfig['topPrograms']['labels'] ?? []) > 0;
    @endphp

    <div class="mx-auto max-w-7xl">
        {{-- En-tête --}}
        <div
            class="animate-admin-stat relative overflow-hidden rounded-[12px] border border-zinc-200/80 bg-gradient-to-br from-white via-white to-zinc-50 p-6 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.08)] ring-1 ring-zinc-100 sm:p-8"
            style="animation-delay: 0ms"
        >
            <div
                class="pointer-events-none absolute -right-16 -top-16 size-56 rounded-full bg-gradient-to-br from-brand/15 to-transparent blur-2xl"
                aria-hidden="true"
            ></div>
            <div class="relative flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-zinc-500">
                        <span class="admin-stat-live-dot size-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
                        Données en direct
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">Statistiques</h1>
                    <p class="mt-1 max-w-xl text-sm text-zinc-600">
                        Vue agrégée de l’activité Athleticore : membres, contenus, commandes et engagement sur les 12 derniers mois.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-sm text-zinc-600">
                    <span class="inline-flex items-center gap-2 rounded-[10px] border border-zinc-200 bg-white px-3 py-2 shadow-sm">
                        <svg class="size-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                    </span>
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center gap-1.5 rounded-[10px] bg-brand px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90"
                    >
                        Tableau de bord
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($kpis as $idx => $kpi)
                <article
                    class="animate-admin-stat group rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-zinc-200/50"
                    style="animation-delay: {{ ($idx + 1) * 58 }}ms"
                >
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <span class="text-sm font-medium text-zinc-500">{{ $kpi['label'] }}</span>
                            <p class="mt-2 text-2xl font-bold tabular-nums tracking-tight text-zinc-900">
                                @if (is_numeric($kpi['value']))
                                    {{ number_format((int) $kpi['value'], 0, ',', ' ') }}
                                @else
                                    {{ $kpi['value'] }}
                                @endif
                            </p>
                            <p class="mt-1 text-xs text-zinc-500">{{ $kpi['hint'] }}</p>
                        </div>
                        <span
                            class="flex size-12 shrink-0 items-center justify-center rounded-xl ring-2 ring-inset transition group-hover:scale-105 {{ $toneIconWrap[$kpi['tone']] ?? 'bg-zinc-100 text-zinc-600 ring-zinc-200/60' }}"
                        >
                            @switch($kpi['key'])
                                @case('members')
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Z" />
                                    </svg>
                                    @break
                                @case('revenue')
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    @break
                                @case('orders')
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218a1.5 1.5 0 0 0 1.464-1.175l3.114-15.75H7.5m0 0L5.417 5.25H2.25M7.5 14.25v-4.5m3 4.5v-4.5m3 4.5v-4.5" />
                                    </svg>
                                    @break
                                @case('videos')
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                    @break
                                @case('programs')
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                    @break
                                @default
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.874a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                    </svg>
                            @endswitch
                        </span>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Bandeau secondaire --}}
        <div
            class="animate-admin-stat mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4"
            style="animation-delay: 420ms"
        >
            <div class="flex items-center gap-3 rounded-[10px] border border-zinc-200 bg-white px-4 py-3 text-sm shadow-sm">
                <span class="flex size-9 items-center justify-center rounded-lg bg-zinc-100 text-zinc-600">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </span>
                <div>
                    <p class="font-medium text-zinc-900">Admins</p>
                    <p class="text-xs text-zinc-500">{{ number_format($adminsCount, 0, ',', ' ') }} compte(s)</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-[10px] border border-zinc-200 bg-white px-4 py-3 text-sm shadow-sm">
                <span class="flex size-9 items-center justify-center rounded-lg bg-zinc-100 text-zinc-600">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
                <div>
                    <p class="font-medium text-zinc-900">Conseils nutrition</p>
                    <p class="text-xs text-zinc-500">{{ number_format($nutritionTipsCount, 0, ',', ' ') }} publié(s)</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-[10px] border border-zinc-200 bg-white px-4 py-3 text-sm shadow-sm">
                <span class="flex size-9 items-center justify-center rounded-lg bg-amber-50 text-amber-700">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </span>
                <div>
                    <p class="font-medium text-zinc-900">Demandes spéciales</p>
                    <p class="text-xs text-zinc-500">{{ $pendingNutritionRequests }} en attente</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-[10px] border border-zinc-200 bg-white px-4 py-3 text-sm shadow-sm">
                <span class="flex size-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
                <div>
                    <p class="font-medium text-zinc-900">Commandes validées</p>
                    <p class="text-xs text-zinc-500">{{ number_format($approvedOrders, 0, ',', ' ') }} / {{ number_format($ordersTotal, 0, ',', ' ') }}</p>
                </div>
            </div>
        </div>

        {{-- Graphiques : CA + commandes --}}
        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <section
                class="animate-admin-stat rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:min-h-[320px]"
                style="animation-delay: 480ms"
            >
                <h2 class="text-base font-semibold text-zinc-900">Chiffre d’affaires</h2>
                <p class="mt-1 text-sm text-zinc-500">Total des commandes par mois (12 derniers mois)</p>
                <div class="relative mt-4 h-64 w-full min-w-0">
                    <canvas id="chart-stat-revenue" aria-label="Graphique du chiffre d’affaires"></canvas>
                </div>
            </section>

            <section
                class="animate-admin-stat rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:min-h-[320px]"
                style="animation-delay: 540ms"
            >
                <h2 class="text-base font-semibold text-zinc-900">Commandes par statut</h2>
                <p class="mt-1 text-sm text-zinc-500">Répartition des états de commande</p>
                @if ($hasOrdersChart)
                    <div class="relative mx-auto mt-4 h-64 max-w-sm">
                        <canvas id="chart-stat-orders" aria-label="Répartition des commandes"></canvas>
                    </div>
                @else
                    <p class="mt-12 text-center text-sm text-zinc-500">Aucune commande enregistrée pour l’instant.</p>
                @endif
            </section>
        </div>

        {{-- Engagement + programmes --}}
        <div class="mt-6 grid gap-6 lg:grid-cols-5">
            <section
                class="animate-admin-stat rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:col-span-3 lg:min-h-[340px]"
                style="animation-delay: 600ms"
            >
                <h2 class="text-base font-semibold text-zinc-900">Engagement</h2>
                <p class="mt-1 text-sm text-zinc-500">Nouveaux membres et vidéos ajoutées par mois</p>
                <div class="relative mt-4 h-56 w-full min-w-[280px]">
                    <canvas id="chart-stat-engagement" aria-label="Graphique d’engagement"></canvas>
                </div>
            </section>

            <section
                class="animate-admin-stat rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)] lg:col-span-2 lg:min-h-[340px]"
                style="animation-delay: 660ms"
            >
                <h2 class="text-base font-semibold text-zinc-900">Répartition par catégorie</h2>
                <p class="mt-1 text-sm text-zinc-500">Pondération par nombre de vidéos</p>
                <div class="mt-6 flex flex-col items-center gap-6 sm:flex-row sm:justify-center">
                    <div class="relative size-44 shrink-0">
                        <canvas id="chart-stat-programs" aria-label="Répartition des programmes"></canvas>
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

        {{-- Top programmes --}}
        <section
            class="animate-admin-stat mt-6 rounded-[10px] border border-zinc-200 bg-white p-5 shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]"
            style="animation-delay: 720ms"
        >
            <h2 class="text-base font-semibold text-zinc-900">Programmes les plus souscrits</h2>
            <p class="mt-1 text-sm text-zinc-500">Nombre d’abonnements actifs par programme (table program_user)</p>
            @if ($hasTopPrograms)
                <div class="relative mt-4 h-[min(28rem,70vh)] w-full min-w-0">
                    <canvas id="chart-stat-top-programs" aria-label="Top programmes"></canvas>
                </div>
            @else
                <p class="mt-8 text-center text-sm text-zinc-500">Aucun abonnement programme enregistré pour l’instant.</p>
            @endif
        </section>
    </div>

    @push('scripts')
        <script type="application/json" id="admin-statistics-config">@json($chartConfig)</script>
        @vite(['resources/js/admin-statistics.js'])
    @endpush
@endsection
