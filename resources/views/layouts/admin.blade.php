<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin — '.config('app.name', 'Athleticore'))</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-zinc-100 font-sans text-zinc-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="flex w-64 shrink-0 flex-col border-r border-zinc-200 bg-white">
            <div class="flex items-center gap-3 border-b border-zinc-100 px-5 py-5">
                <span class="flex size-10 shrink-0 items-center justify-center rounded bg-brand text-lg font-bold text-white">A</span>
                <span class="text-lg font-bold tracking-tight text-zinc-900">ATHLETICORE</span>
            </div>

            <nav class="flex flex-1 flex-col gap-1 overflow-y-auto px-3 py-4 text-sm">
                <a
                    href="{{ route('admin.dashboard') }}"
                    @class([
                        'flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition',
                        'bg-brand-muted text-brand' => request()->routeIs('admin.dashboard'),
                        'text-zinc-600 hover:bg-zinc-50' => ! request()->routeIs('admin.dashboard'),
                    ])
                >
                    <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Tableau de bord
                </a>

                <p class="mb-1 mt-4 px-3 text-xs font-semibold uppercase tracking-wider text-zinc-400">Gestion</p>

                @foreach ([
                    ['pattern' => 'admin.users.*', 'route' => 'admin.users.index', 'label' => 'Utilisateurs', 'icon' => 'users'],
                    ['pattern' => 'admin.programs.*', 'route' => 'admin.programs.index', 'label' => 'Programmes', 'icon' => 'programs'],
                    ['pattern' => 'admin.videos.*', 'route' => 'admin.videos.index', 'label' => 'Vidéos', 'icon' => 'video'],
                    ['pattern' => 'admin.nutrition-tips.*', 'route' => 'admin.nutrition-tips.index', 'label' => 'Conseils nutrition', 'icon' => 'book'],
                ] as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition',
                            'bg-brand-muted text-brand' => request()->routeIs($item['pattern']),
                            'text-zinc-600 hover:bg-zinc-50' => ! request()->routeIs($item['pattern']),
                        ])
                    >
                        @if ($item['icon'] === 'users')
                            <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        @elseif ($item['icon'] === 'programs')
                            <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                            </svg>
                        @elseif ($item['icon'] === 'video')
                            <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        @else
                            <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <p class="mb-1 mt-4 px-3 text-xs font-semibold uppercase tracking-wider text-zinc-400">Analyses</p>

                <a
                    href="{{ route('admin.statistics') }}"
                    @class([
                        'flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition',
                        'bg-brand-muted text-brand' => request()->routeIs('admin.statistics'),
                        'text-zinc-600 hover:bg-zinc-50' => ! request()->routeIs('admin.statistics'),
                    ])
                >
                    <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.75ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    Statistiques
                </a>

                <a
                    href="{{ route('admin.subscriptions.index') }}"
                    @class([
                        'flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition',
                        'bg-brand-muted text-brand' => request()->routeIs('admin.subscriptions.*'),
                        'text-zinc-600 hover:bg-zinc-50' => ! request()->routeIs('admin.subscriptions.*'),
                    ])
                >
                    <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    <span class="flex min-w-0 flex-1 items-center justify-between gap-2">
                        Abonnements
                        @if (($pendingSubscriptionCount ?? 0) > 0)
                            <span class="rounded-full bg-brand px-1.5 py-0.5 text-[10px] font-bold leading-none text-white">{{ min(99, $pendingSubscriptionCount) }}</span>
                        @endif
                    </span>
                </a>
            </nav>

            <div class="flex flex-col gap-2 border-t border-zinc-100 px-3 py-4">
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-zinc-600 hover:bg-zinc-50">
                    <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.99l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.99l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Paramètres
                </a>

                <div class="flex items-center gap-3 rounded-lg px-3 py-2">
                    @php
                        $avatarInitial = mb_strtoupper(mb_substr(auth()->user()->name, 0, 1));
                    @endphp
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-sm font-semibold text-zinc-700">{{ $avatarInitial }}</span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-zinc-900">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-zinc-500">{{ auth()->user()->isAdmin() ? 'Super Admin' : auth()->user()->role?->name }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex shrink-0 items-center gap-4 border-b border-zinc-200 bg-white px-4 py-4 lg:px-8">
                <form action="{{ route('admin.users.index') }}" method="get" class="flex flex-1 flex-col sm:flex-row sm:items-center sm:gap-4" role="search">
                    <label class="relative block flex-1">
                        <span class="sr-only">Rechercher</span>
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </span>
                        <input
                            type="search"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Rechercher utilisateurs, programmes…"
                            class="w-full rounded-[10px] border border-zinc-200 bg-zinc-50 py-2.5 pl-10 pr-4 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                        >
                    </label>
                </form>
                <div class="flex shrink-0 items-center gap-2">
                    <details class="relative">
                        <summary
                            class="relative flex cursor-pointer list-none items-center justify-center rounded-[10px] p-2.5 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-700 [&::-webkit-details-marker]:hidden"
                            aria-label="Notifications"
                        >
                            <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.082A2.25 2.25 0 0 0 21.75 14v-4.5a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 8.25 9.5V14a2.25 2.25 0 0 0 2.25 2.25h9.5a2.25 2.25 0 0 0 2.25-2.25V9.5m-16.5 5.25V9.5m0 0a2.25 2.25 0 0 1 2.25-2.25h9A2.25 2.25 0 0 1 21.75 9.5V14a2.25 2.25 0 0 1-2.25 2.25h-9A2.25 2.25 0 0 1 8.25 14V9.5Z" />
                            </svg>
                            @if ($notificationBadgeCount > 0)
                                <span class="absolute right-1 top-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-brand px-1 text-[10px] font-bold leading-none text-white">
                                    {{ $notificationBadgeCount }}
                                </span>
                            @endif
                        </summary>
                        <div
                            class="absolute right-0 z-50 mt-2 w-[min(calc(100vw-2rem),22rem)] max-h-[min(70vh,28rem)] overflow-y-auto rounded-[10px] border border-zinc-200 bg-white py-2 shadow-lg"
                        >
                            <p class="px-4 pb-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Nouvelles inscriptions</p>
                            <div class="max-h-48 overflow-y-auto">
                                @forelse ($recentSignups as $signup)
                                    <a
                                        href="{{ route('admin.users.show', $signup) }}"
                                        class="block border-b border-zinc-50 px-4 py-2.5 last:border-0 hover:bg-zinc-50"
                                    >
                                        <span class="font-medium text-zinc-900">{{ $signup->name }}</span>
                                        <span class="block truncate text-xs text-zinc-500">{{ $signup->email }}</span>
                                        <span class="mt-0.5 text-xs text-zinc-400">{{ $signup->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}</span>
                                    </a>
                                @empty
                                    <p class="px-4 py-3 text-sm text-zinc-500">Aucune inscription récente.</p>
                                @endforelse
                            </div>

                            <p class="mt-3 border-t border-zinc-100 px-4 pb-2 pt-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Programmes (commandes / paiement)</p>
                            <div class="max-h-56 overflow-y-auto">
                                @forelse ($recentOrders as $order)
                                    <div class="border-b border-zinc-50 px-4 py-2.5 last:border-0">
                                        <p class="text-sm font-medium text-zinc-900">
                                            @if ($order->user)
                                                <a href="{{ route('admin.users.show', $order->user) }}" class="hover:text-brand">{{ $order->user->name }}</a>
                                            @else
                                                <span>{{ $order->billing_email }}</span>
                                                <span class="text-xs font-normal text-zinc-500"> (invité)</span>
                                            @endif
                                        </p>
                                        <p class="mt-1 text-xs leading-relaxed text-zinc-600">
                                            @foreach ($order->items as $item)
                                                <span>{{ $item->title }} × {{ $item->qty }}</span>@if (! $loop->last)<span class="text-zinc-300"> · </span>@endif
                                            @endforeach
                                        </p>
                                        <p class="mt-1 text-xs text-zinc-400">
                                            {{ $order->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}
                                            · {{ number_format((float) $order->total, 2, ',', ' ') }} DH
                                        </p>
                                    </div>
                                @empty
                                    <p class="px-4 py-3 text-sm text-zinc-500">Aucune commande enregistrée.</p>
                                @endforelse
                            </div>

                            <p class="mt-3 border-t border-zinc-100 px-4 pb-2 pt-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Demandes conseils spéciaux</p>
                            <div class="max-h-56 overflow-y-auto">
                                @forelse ($recentSpecialRequests as $req)
                                    <div class="border-b border-zinc-50 px-4 py-2.5 last:border-0">
                                        <p class="text-sm font-medium text-zinc-900">
                                            @if ($req->user)
                                                <a href="{{ route('admin.users.show', $req->user) }}" class="hover:text-brand">{{ $req->user->name }}</a>
                                            @else
                                                <span>Client supprimé</span>
                                            @endif
                                        </p>
                                        <p class="mt-1 text-xs text-zinc-600">
                                            {{ $req->program?->title ?? 'Programme' }}
                                        </p>
                                        <p class="mt-1 text-xs leading-relaxed text-zinc-500">{{ \Illuminate\Support\Str::limit($req->message ?? 'Sans message', 90) }}</p>
                                        <p class="mt-1 text-xs text-zinc-400">{{ $req->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}</p>
                                        <a
                                            href="{{ route('admin.nutrition-tips.create', ['request_id' => $req->id]) }}"
                                            class="mt-2 inline-flex text-xs font-medium text-brand hover:underline"
                                        >
                                            Traiter cette demande
                                        </a>
                                    </div>
                                @empty
                                    <p class="px-4 py-3 text-sm text-zinc-500">Aucune demande spéciale en attente.</p>
                                @endforelse
                            </div>

                            <div class="border-t border-zinc-100 px-4 pt-3">
                                <a href="{{ route('admin.subscriptions.index') }}" class="text-xs font-medium text-brand hover:underline">Abonnements à traiter</a>
                                <span class="mx-2 text-zinc-300">·</span>
                                <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-brand hover:underline">Tous les utilisateurs</a>
                            </div>
                        </div>
                    </details>
                    <a
                        href="{{ route('admin.videos.create') }}"
                        class="inline-flex items-center gap-1.5 rounded-[10px] bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90"
                    >
                        <span class="text-lg leading-none">+</span>
                        Nouveau
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-auto p-4 lg:p-8">
                @yield('content')

                <footer class="mt-12 border-t border-zinc-200/50 pt-6 text-xs text-zinc-600">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <p>© {{ date('Y') }} Athleticore. Tous droits réservés.</p>
                        <a href="{{ route('client.home') }}" class="hover:underline">Retour au site</a>
                    </div>
                </footer>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
