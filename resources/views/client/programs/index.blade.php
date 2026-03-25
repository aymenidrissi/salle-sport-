@extends('layouts.app')

@section('title', 'Programmes — Athleticore')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="max-w-2xl">
            <h1 class="text-3xl font-bold tracking-tight text-white">Programmes</h1>
            <p class="mt-2 text-sm text-zinc-400">Choisissez un programme et accédez aux vidéos d’entraînement.</p>
        </div>

        <div class="mt-10 grid gap-8 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($programs as $program)
                @php
                    $video = $program->videos?->first();
                    $youtubeId = null;
                    if ($video && $video->url) {
                        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', (string) $video->url, $m)) {
                            $youtubeId = $m[1];
                        }
                    }

                    $coverUrl = null;
                    if ($program->image) {
                        $coverUrl = \Illuminate\Support\Str::startsWith($program->image, ['http://', 'https://'])
                            ? $program->image
                            : asset('storage/'.$program->image);
                    } elseif ($youtubeId) {
                        $coverUrl = 'https://img.youtube.com/vi/'.$youtubeId.'/hqdefault.jpg';
                    }
                @endphp

                <article
                    class="group flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/50 shadow-lg shadow-black/30 transition hover:border-[#a3ff12]/45 hover:shadow-[#a3ff12]/5"
                >
                    <a
                        href="{{ route('client.programs.show', $program) }}"
                        class="relative block aspect-[16/10] w-full overflow-hidden bg-zinc-800"
                    >
                        @if ($coverUrl)
                            <img
                                src="{{ $coverUrl }}"
                                alt="{{ $program->title }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                loading="lazy"
                                width="640"
                                height="400"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-800 via-zinc-900 to-[#0a0b0d]">
                                <svg class="h-14 w-14 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#0a0b0d]/80 via-transparent to-transparent"></div>

                        @if ($program->price)
                            <span class="absolute right-3 top-3 rounded-full border border-white/10 bg-black/55 px-3 py-1 text-xs font-bold text-[#a3ff12] backdrop-blur-sm">
                                {{ number_format((float) $program->price, 0, ',', ' ') }} DH
                            </span>
                        @endif
                    </a>

                    <div class="flex flex-1 flex-col p-5">
                        <h2 class="text-lg font-semibold leading-snug text-white">
                            <a href="{{ route('client.programs.show', $program) }}" class="hover:text-[#a3ff12]">
                                {{ $program->title }}
                            </a>
                        </h2>

                        @if ($program->description)
                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-zinc-400">
                                {{ $program->description }}
                            </p>
                        @endif

                        @if ($video)
                            <p class="mt-3 text-xs text-zinc-500">
                                Vidéo : <span class="text-zinc-300">{{ $video->title }}</span>
                            </p>
                        @endif

                        <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <a
                                href="{{ route('client.programs.show', $program) }}"
                                class="inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-4 py-2.5 text-sm font-semibold text-white transition hover:border-[#a3ff12]/50 hover:bg-[#a3ff12]/10"
                            >
                                Voir le programme
                            </a>
                            @if ($video && $video->url)
                                <a
                                    href="{{ $video->url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#a3ff12] px-4 py-2.5 text-sm font-semibold text-[#0a0b0d] shadow-[0_0_20px_-4px_rgba(163,255,18,0.35)] transition hover:bg-[#b8ff4d]"
                                >
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    YouTube
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-white/10 bg-zinc-900/30 p-8 text-center text-zinc-500">
                    Aucun programme pour le moment.
                </div>
            @endforelse
        </div>

        <div class="mt-10 text-zinc-400 [&_a]:text-[#a3ff12]">
            {{ $programs->links() }}
        </div>
    </div>
@endsection
