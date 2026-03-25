@extends('layouts.app')

@section('title', $video->title.' — Athleticore')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="mb-6">
            @if ($video->program)
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('client.programs.show', $video->program) }}" class="text-sm text-[#a3ff12] hover:underline">← {{ $video->program->title }}</a>
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#a3ff12]/30 bg-[#a3ff12]/5 px-3 py-1 text-xs font-medium text-[#a3ff12]">
                        Programme associé
                    </span>
                </div>

                @if ($video->program->description)
                    <p class="mt-4 whitespace-pre-wrap text-sm leading-relaxed text-zinc-400">
                        {{ $video->program->description }}
                    </p>
                @endif
            @else
                <a href="{{ route('client.programs.index') }}" class="text-sm text-[#a3ff12] hover:underline">← Programmes</a>
            @endif
        </div>

        <h1 class="text-3xl font-bold tracking-tight text-white">{{ $video->title }}</h1>

        @if ($video->description)
            <p class="mt-4 whitespace-pre-wrap leading-relaxed text-zinc-400">{{ $video->description }}</p>
        @endif

        <div class="mt-8 rounded-2xl border border-white/10 bg-zinc-900/40 p-4 backdrop-blur">
            @php
                $embedUrl = null;
                $url = (string) ($video->url ?? '');

                // Support YouTube : watch?v=..., youtu.be/..., shorts/..., live/..., embed/...
                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', $url, $m)) {
                    $embedUrl = 'https://www.youtube.com/embed/'.$m[1];
                }
            @endphp

            @if ($embedUrl)
                <div class="relative aspect-video w-full overflow-hidden rounded-xl">
                    <iframe
                        class="absolute inset-0 h-full w-full"
                        src="{{ $embedUrl }}"
                        title="{{ $video->title }}"
                        frameborder="0"
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            @else
                <a href="{{ $video->url }}" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center rounded-xl bg-[#a3ff12] px-5 py-3 text-sm font-semibold text-[#0a0b0d] hover:bg-[#b8ff4d]">
                    Ouvrir la vidéo
                </a>
            @endif
        </div>

        @if ($video->url)
            <div class="mt-4 text-sm text-zinc-400">
                <a href="{{ $video->url }}" target="_blank" rel="noopener" class="font-semibold text-[#a3ff12] hover:underline">
                    Ouvrir la vidéo sur YouTube
                </a>
            </div>
        @endif
    </div>
@endsection

