@extends('layouts.admin')

@section('title', 'Programmes — Admin')

@section('content')
    <div class="mx-auto max-w-6xl">
        @if (session('status'))
            <div class="mb-4 rounded-[10px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-[10px] border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-5 flex items-center justify-between gap-3">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Programmes</h1>
            <a href="{{ route('admin.programs.create') }}" class="rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand/90">
                + Ajouter un programme
            </a>
        </div>

        <div class="overflow-x-auto rounded-[10px] border border-zinc-200 bg-white shadow-sm">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500">
                    <tr>
                        <th class="px-4 py-3 font-medium">Programme</th>
                        <th class="px-4 py-3 font-medium">Prix</th>
                        <th class="px-4 py-3 font-medium">Statut carte client</th>
                        <th class="px-4 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($programs as $program)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-medium text-zinc-900">{{ $program->title }}</p>
                                <p class="text-xs text-zinc-500">{{ $program->slug }}</p>
                            </td>
                            <td class="px-4 py-3 text-zinc-700">
                                {{ $program->price ? number_format((float) $program->price, 2, ',', ' ') . ' DH' : '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($program->is_visible)
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">Affichée</span>
                                @else
                                    <span class="rounded-full bg-zinc-200 px-2 py-1 text-xs font-medium text-zinc-700">Masquée</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.programs.edit', $program) }}" class="rounded-lg p-2 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700" title="Modifier">
                                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897l8.992-8.99Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" onsubmit="return confirm('Supprimer ce programme ? La carte disparaîtra côté client.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg p-2 text-zinc-400 hover:bg-red-50 hover:text-red-600" title="Supprimer">
                                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-zinc-500">Aucun programme pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $programs->links() }}</div>

        <section class="mt-8 rounded-[10px] border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-100 px-4 py-3">
                <h2 class="text-base font-semibold text-zinc-900">Demandes clients depuis panier</h2>
                <p class="mt-0.5 text-sm text-zinc-500">Attribuer un programme commandé directement au client (comme le flux conseils nutrition).</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500">
                        <tr>
                            <th class="px-4 py-3 font-medium">Date</th>
                            <th class="px-4 py-3 font-medium">Client</th>
                            <th class="px-4 py-3 font-medium">Programme demandé</th>
                            <th class="px-4 py-3 font-medium">Commande</th>
                            <th class="px-4 py-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($pendingProgramRequests as $item)
                            <tr>
                                <td class="px-4 py-3 text-zinc-600">
                                    {{ $item->created_at?->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($item->order?->user)
                                        <a href="{{ route('admin.users.show', $item->order->user) }}" class="font-medium text-zinc-900 hover:text-brand">{{ $item->order->user->name }}</a>
                                        <p class="text-xs text-zinc-500">{{ $item->order->user->email }}</p>
                                    @else
                                        <span class="text-zinc-500">Client introuvable</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-zinc-900">{{ $item->title }}</p>
                                    <p class="text-xs text-zinc-500">{{ $item->program_slug }}</p>
                                </td>
                                <td class="px-4 py-3 text-zinc-700">
                                    #{{ $item->order_id }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.programs.cart-requests.assign', $item) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        <input
                                            type="url"
                                            name="pdf_link"
                                            placeholder="Lien PDF complet (optionnel)"
                                            class="w-64 rounded-lg border border-zinc-300 px-2.5 py-1.5 text-xs focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                                        >
                                        <button type="submit" class="rounded-lg bg-brand px-3 py-2 text-xs font-semibold text-white hover:bg-brand/90">
                                            Traiter + Ajouter au client
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-zinc-500">Aucune demande panier en attente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
