@extends('layouts.admin')

@section('title', 'Abonnements — Admin')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Abonnements</h1>
            <p class="mt-1 text-zinc-600">Commandes payées en attente d’acceptation : les programmes choisis sont listés ci-dessous. Accepter attribue l’accès au client.</p>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-[10px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-[10px] border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <section class="rounded-[10px] border border-zinc-200 bg-white shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]">
            <div class="border-b border-zinc-100 px-5 py-4">
                <h2 class="text-base font-semibold text-zinc-900">En attente d’acceptation</h2>
                <p class="mt-0.5 text-sm text-zinc-500">Nouvelles commandes (statut « en attente »)</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 text-xs font-medium uppercase tracking-wide text-zinc-400">
                            <th class="px-5 py-3 font-medium">Date</th>
                            <th class="px-5 py-3 font-medium">Client</th>
                            <th class="px-5 py-3 font-medium">Programmes choisis</th>
                            <th class="px-5 py-3 font-medium">Total</th>
                            <th class="px-5 py-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50">
                        @forelse ($pendingOrders as $order)
                            <tr class="align-top transition hover:bg-zinc-50/80">
                                <td class="px-5 py-4 text-zinc-600">
                                    {{ $order->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}
                                </td>
                                <td class="px-5 py-4">
                                    @if ($order->user)
                                        <a href="{{ route('admin.users.show', $order->user) }}" class="font-medium text-zinc-900 hover:text-brand">{{ $order->user->name }}</a>
                                        <span class="block text-xs text-zinc-500">{{ $order->billing_email }}</span>
                                    @else
                                        <span class="font-medium text-zinc-900">{{ $order->billing_name ?? '—' }}</span>
                                        <span class="block text-xs text-zinc-500">{{ $order->billing_email }}</span>
                                        <span class="mt-1 inline-block rounded bg-amber-100 px-2 py-0.5 text-[11px] font-medium text-amber-800">Sans compte connecté</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <ul class="space-y-1.5 text-zinc-700">
                                        @foreach ($order->items as $item)
                                            <li class="flex flex-wrap items-baseline gap-x-2">
                                                <span class="font-medium text-zinc-900">{{ $item->title }}</span>
                                                @if ($item->qty > 1)
                                                    <span class="text-xs text-zinc-500">× {{ $item->qty }}</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-5 py-4 tabular-nums text-zinc-800">
                                    {{ number_format((float) $order->total, 2, ',', ' ') }} DH
                                </td>
                                <td class="px-5 py-4 text-right">
                                    @if ($order->user_id)
                                        <form action="{{ route('admin.subscriptions.approve', $order) }}" method="post" class="inline">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-[10px] bg-brand px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90"
                                            >
                                                Accepter
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-zinc-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-zinc-500">
                                    Aucune commande en attente. Les nouvelles commandes clients apparaîtront ici.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pendingOrders->hasPages())
                <div class="border-t border-zinc-100 px-5 py-4">
                    {{ $pendingOrders->links() }}
                </div>
            @endif
        </section>

        @if ($recentApproved->isNotEmpty())
            <section class="mt-8 rounded-[10px] border border-zinc-200 bg-white shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]">
                <div class="border-b border-zinc-100 px-5 py-4">
                    <h2 class="text-base font-semibold text-zinc-900">Récemment acceptées</h2>
                    <p class="mt-0.5 text-sm text-zinc-500">Dernières commandes validées par l’administration</p>
                </div>
                <ul class="divide-y divide-zinc-50 px-5 py-2">
                    @foreach ($recentApproved as $order)
                        <li class="flex flex-col gap-2 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-medium text-zinc-900">
                                    @if ($order->user)
                                        <a href="{{ route('admin.users.show', $order->user) }}" class="hover:text-brand">{{ $order->user->name }}</a>
                                    @else
                                        {{ $order->billing_email }}
                                    @endif
                                    <span class="font-normal text-zinc-500">· {{ $order->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}</span>
                                </p>
                                <p class="mt-1 text-sm text-zinc-600">
                                    @foreach ($order->items as $item)
                                        <span>{{ $item->title }}</span>@if (! $loop->last)<span class="text-zinc-300"> · </span>@endif
                                    @endforeach
                                </p>
                            </div>
                            <p class="shrink-0 text-sm tabular-nums text-zinc-700">{{ number_format((float) $order->total, 2, ',', ' ') }} DH</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="mt-8 rounded-[10px] border border-zinc-200 bg-white shadow-[0_4px_6px_-1px_rgb(0_0_0_/_0.07)]">
            <div class="border-b border-zinc-100 px-5 py-4">
                <h2 class="text-base font-semibold text-zinc-900">Demandes de conseils nutrition spéciaux</h2>
                <p class="mt-0.5 text-sm text-zinc-500">Demandes envoyées depuis le bouton client “Demander un conseil spécial”.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 text-xs font-medium uppercase tracking-wide text-zinc-400">
                            <th class="px-5 py-3 font-medium">Date</th>
                            <th class="px-5 py-3 font-medium">Client</th>
                            <th class="px-5 py-3 font-medium">Programme</th>
                            <th class="px-5 py-3 font-medium">Message</th>
                            <th class="px-5 py-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50">
                        @forelse ($pendingNutritionRequests as $req)
                            <tr class="align-top transition hover:bg-zinc-50/80">
                                <td class="px-5 py-4 text-zinc-600">{{ $req->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                <td class="px-5 py-4">
                                    @if ($req->user)
                                        <a href="{{ route('admin.users.show', $req->user) }}" class="font-medium text-zinc-900 hover:text-brand">{{ $req->user->name }}</a>
                                        <span class="block text-xs text-zinc-500">{{ $req->user->email }}</span>
                                    @else
                                        <span class="text-zinc-400">Client supprimé</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-zinc-700">{{ $req->program?->title ?? '—' }}</td>
                                <td class="px-5 py-4 text-zinc-700">
                                    <p class="max-w-xl whitespace-pre-wrap">{{ \Illuminate\Support\Str::limit($req->message ?? '—', 180) }}</p>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a
                                        href="{{ route('admin.nutrition-tips.create', ['request_id' => $req->id]) }}"
                                        class="inline-flex items-center justify-center rounded-[10px] bg-brand px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90"
                                    >
                                        Traiter
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-zinc-500">
                                    Aucune demande spéciale en attente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
