@extends('layouts.admin')

@section('title', 'Conseils nutrition — Admin')

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="mb-5 flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Conseils nutrition</h1>
                <p class="mt-1 text-sm text-zinc-600">
                    Ces conseils s’affichent sur la page client du programme
                    <span class="font-medium text-zinc-800">programme-nutrition-sportive</span>.
                </p>
            </div>
            <a href="{{ route('admin.nutrition-tips.create') }}" class="rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand/90">
                + Ajouter un conseil
            </a>
        </div>

        <div class="overflow-x-auto rounded-[10px] border border-zinc-200 bg-white shadow-sm">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500">
                    <tr>
                        <th class="px-4 py-3 font-medium">Conseil</th>
                        <th class="px-4 py-3 font-medium">Créé</th>
                        <th class="px-4 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($tips as $tip)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-medium text-zinc-900">{{ $tip->title }}</p>
                                <p class="mt-0.5 text-xs text-zinc-500">{{ \Illuminate\Support\Str::limit($tip->content, 90) }}</p>
                            </td>
                            <td class="px-4 py-3 text-zinc-600">
                                {{ $tip->created_at?->locale('fr')->isoFormat('D MMM YYYY') ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.nutrition-tips.show', $tip) }}" class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">
                                        Voir
                                    </a>
                                    <a href="{{ route('admin.nutrition-tips.edit', $tip) }}" class="rounded-lg p-2 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700" title="Modifier">
                                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897l8.992-8.99Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.nutrition-tips.destroy', $tip) }}" onsubmit="return confirm('Supprimer ce conseil ?');">
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
                            <td colspan="3" class="px-4 py-10 text-center text-zinc-500">Aucun conseil pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $tips->links() }}</div>
    </div>
@endsection
