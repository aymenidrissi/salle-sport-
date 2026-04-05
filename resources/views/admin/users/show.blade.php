@extends('layouts.admin')

@section('title', $user->name.' — Profil — Admin')

@section('content')
    @php
        $photoUrl = null;
        if ($user->photo) {
            $photoUrl = \Illuminate\Support\Str::startsWith($user->photo, ['http://', 'https://'])
                ? $user->photo
                : asset('storage/'.$user->photo);
        }
    @endphp

    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-brand hover:underline">← Utilisateurs</a>
        </div>

        <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex min-w-0 items-start gap-4">
                @if ($photoUrl)
                    <img
                        src="{{ $photoUrl }}"
                        alt=""
                        class="size-20 shrink-0 rounded-full border border-zinc-200 object-cover sm:size-24"
                        width="96"
                        height="96"
                    >
                @else
                    <span class="flex size-20 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-2xl font-bold text-zinc-600 sm:size-24 sm:text-3xl">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </span>
                @endif
                <div class="min-w-0">
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-900">{{ $user->name }}</h1>
                    <p class="mt-1 truncate text-sm text-zinc-600">{{ $user->email }}</p>
                    <p class="mt-2">
                        <span class="inline-flex rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-700">
                            {{ $user->role?->name ?? '—' }}
                        </span>
                    </p>
                    <p class="mt-2 text-xs text-zinc-500">
                        Inscrit le {{ $user->created_at?->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') ?? '—' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2">
            <section class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Profil physique</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">Âge</dt>
                        <dd class="font-medium text-zinc-900">{{ $user->age !== null ? $user->age.' ans' : '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">Poids</dt>
                        <dd class="font-medium text-zinc-900">{{ $user->weight !== null ? number_format((float) $user->weight, 1, ',', ' ').' kg' : '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">Taille</dt>
                        <dd class="font-medium text-zinc-900">{{ $user->height !== null ? number_format((float) $user->height, 0, ',', ' ').' cm' : '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">IMC</dt>
                        <dd class="font-medium text-zinc-900">
                            @if ($user->bmi() !== null)
                                {{ number_format((float) $user->bmi(), 1, ',', ' ') }}
                                @if ($user->bmiCategoryLabel())
                                    <span class="text-zinc-500">({{ $user->bmiCategoryLabel() }})</span>
                                @endif
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-[10px] border border-zinc-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Coordonnées</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">Ville</dt>
                        <dd class="text-right font-medium text-zinc-900">{{ $user->city ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">E-mail</dt>
                        <dd class="truncate text-right font-medium text-zinc-900" title="{{ $user->email }}">{{ $user->email }}</dd>
                    </div>
                </dl>
            </section>
        </div>

        <section class="mt-6 rounded-[10px] border border-zinc-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Activité</h2>
            <p class="mt-3 text-sm text-zinc-700">
                <span class="font-semibold tabular-nums text-zinc-900">{{ $user->progresses_count }}</span>
                enregistrement{{ $user->progresses_count > 1 ? 's' : '' }} de progression
            </p>
        </section>
    </div>
@endsection
