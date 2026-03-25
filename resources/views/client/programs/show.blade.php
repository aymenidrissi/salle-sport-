@extends('layouts.app')

@section('title', $program->title.' — Athleticore')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-3xl font-bold tracking-tight text-white">{{ $program->title }}</h1>
        @if ($program->description)
            <p class="mt-6 whitespace-pre-wrap leading-relaxed text-zinc-400">{{ $program->description }}</p>
        @endif

        @if ($program->videos && $program->videos->count() > 0)
            <div class="mt-10">
                <h2 class="text-xl font-semibold text-white">Vidéos du programme</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($program->videos as $video)
                        @php
                            $embedUrl = null;
                            $url = (string) ($video->url ?? '');

                            // Support YouTube : watch?v=..., youtu.be/..., shorts/..., live/..., embed/...
                            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', $url, $m)) {
                                $embedUrl = 'https://www.youtube.com/embed/'.$m[1];
                            }
                        @endphp
                        <a href="{{ route('client.videos.show', $video) }}"
                           class="group rounded-2xl border border-white/10 bg-zinc-900/40 p-4 backdrop-blur transition hover:border-[#a3ff12]/50 hover:bg-zinc-900/55">
                            <div class="text-sm font-semibold text-white group-hover:text-[#a3ff12]">
                                {{ $video->title }}
                            </div>
                            @if ($embedUrl)
                                <div class="mt-3 overflow-hidden rounded-xl border border-white/10">
                                    <div class="relative aspect-video w-full overflow-hidden">
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
                                </div>
                            @endif
                            @if ($video->description)
                                <div class="mt-2 text-xs text-zinc-400">
                                    {{ \Illuminate\Support\Str::limit($video->description, 120) }}
                                </div>
                            @endif

                            @if ($video->url)
                                <div class="mt-4">
                                    <a
                                        href="{{ $video->url }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="inline-flex items-center justify-center rounded-xl bg-[#a3ff12] px-4 py-2 text-xs font-semibold text-[#0a0b0d] hover:bg-[#b8ff4d]"
                                    >
                                        Voir sur YouTube
                                    </a>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
