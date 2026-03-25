@extends('layouts.app')

@section('title', 'Nutrition — Athleticore')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-3xl font-bold tracking-tight text-white">Conseils nutrition</h1>
        <ul class="mt-8 space-y-4">
            @forelse ($tips as $tip)
                <li class="rounded-xl border border-white/10 bg-zinc-900/40 p-5 backdrop-blur">
                    <h2 class="font-semibold text-white">{{ $tip->title }}</h2>
                    <p class="mt-2 text-sm text-zinc-400">{{ \Illuminate\Support\Str::limit($tip->content, 200) }}</p>
                </li>
            @empty
                <li class="text-zinc-500">Aucun conseil pour le moment.</li>
            @endforelse
        </ul>
        <div class="mt-8 text-zinc-400 [&_a]:text-[#a3ff12]">{{ $tips->links() }}</div>
    </div>
@endsection
