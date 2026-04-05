@extends('layouts.admin')

@section('title', 'Utilisateurs — Admin')

@section('content')
    <div class="mx-auto max-w-5xl">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Utilisateurs</h1>

        <div class="mt-6 overflow-x-auto rounded-[10px] border border-zinc-200 bg-white shadow-sm">
            <table class="w-full min-w-[560px] text-left text-sm">
                <thead class="border-b border-zinc-100 bg-zinc-50 text-xs font-semibold uppercase tracking-wide text-zinc-500">
                    <tr>
                        <th class="w-14 px-4 py-3" scope="col">ID</th>
                        <th class="w-16 px-4 py-3" scope="col">Profil</th>
                        <th class="px-4 py-3" scope="col">Utilisateur</th>
                        <th class="hidden px-4 py-3 sm:table-cell" scope="col">Rôle</th>
                        <th class="w-28 px-4 py-3 text-right" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach ($users as $user)
                        @php
                            $photoUrl = null;
                            if ($user->photo) {
                                $photoUrl = \Illuminate\Support\Str::startsWith($user->photo, ['http://', 'https://'])
                                    ? $user->photo
                                    : asset('storage/'.$user->photo);
                            }
                            $initial = mb_strtoupper(mb_substr($user->name, 0, 1));
                        @endphp
                        <tr class="transition hover:bg-zinc-50/80">
                            <td class="px-4 py-3 align-middle">
                                <span class="tabular-nums font-medium text-zinc-600" title="Identifiant">{{ $user->id }}</span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <a href="{{ route('admin.users.show', $user) }}" class="inline-flex shrink-0" title="Voir le profil">
                                    @if ($photoUrl)
                                        <img
                                            src="{{ $photoUrl }}"
                                            alt=""
                                            class="size-10 rounded-full border border-zinc-200 object-cover"
                                            width="40"
                                            height="40"
                                        >
                                    @else
                                        <span class="flex size-10 items-center justify-center rounded-full bg-zinc-200 text-sm font-semibold text-zinc-700">
                                            {{ $initial }}
                                        </span>
                                    @endif
                                </a>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <a href="{{ route('admin.users.show', $user) }}" class="group block">
                                    <span class="font-medium text-zinc-900 group-hover:text-brand">{{ $user->name }}</span>
                                    <span class="block truncate text-zinc-500">{{ $user->email }}</span>
                                    @if ($user->role)
                                        <span class="mt-0.5 inline-block text-xs text-zinc-400 sm:hidden">{{ $user->role->name }}</span>
                                    @endif
                                </a>
                            </td>
                            <td class="hidden px-4 py-3 align-middle text-zinc-700 sm:table-cell">
                                {{ $user->role?->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="flex items-center justify-end gap-1">
                                    <a
                                        href="{{ route('admin.users.show', $user) }}"
                                        class="rounded-lg p-2 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-800"
                                        title="Voir le profil"
                                        aria-label="Profil de {{ $user->name }}"
                                    >
                                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            method="post"
                                            class="inline"
                                            onsubmit="return confirm('Supprimer définitivement ce compte ?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="rounded-lg p-2 text-zinc-400 transition hover:bg-red-50 hover:text-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                                title="Supprimer le compte"
                                                aria-label="Supprimer le compte {{ $user->name }}"
                                            >
                                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $users->links() }}</div>
    </div>
@endsection
