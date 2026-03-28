@extends('layouts.app')

@section('title', $program->title.' — Athleticore')

@section('content')
    @php
        $youtubeId = null;
        $firstVideo = $program->videos?->first();
        if ($firstVideo && $firstVideo->url) {
            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', (string) $firstVideo->url, $m)) {
                $youtubeId = $m[1];
            }
        }
        $heroCover = null;
        if ($program->image) {
            $heroCover = \Illuminate\Support\Str::startsWith($program->image, ['http://', 'https://'])
                ? $program->image
                : asset('storage/'.$program->image);
        } elseif ($youtubeId) {
            $heroCover = 'https://img.youtube.com/vi/'.$youtubeId.'/hqdefault.jpg';
        }
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-12">
        <nav class="text-sm text-zinc-500" aria-label="Fil d’Ariane">
            <a href="{{ route('client.home') }}" class="hover:text-[#a3ff12]">Accueil</a>
            <span class="mx-2 text-zinc-600">/</span>
            <a href="{{ route('client.programs.index') }}" class="hover:text-[#a3ff12]">Programmes</a>
            <span class="mx-2 text-zinc-600">/</span>
            <span class="text-zinc-300">{{ $program->title }}</span>
        </nav>

        <div class="mt-8 overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/40">
            @if ($heroCover)
                <div class="relative aspect-[21/9] max-h-72 w-full overflow-hidden bg-zinc-800 sm:aspect-[2.4/1]">
                    <img
                        src="{{ $heroCover }}"
                        alt=""
                        class="h-full w-full object-cover object-center"
                        loading="lazy"
                        width="1200"
                        height="500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0b0d] via-[#0a0b0d]/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                        <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">{{ $program->title }}</h1>
                        @if ($program->price)
                            <p class="mt-2 text-sm font-semibold text-[#a3ff12]">
                                {{ number_format((float) $program->price, 2, ',', ' ') }} DH
                            </p>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-3">
                            <a
                                href="{{ route('client.product.show', $program) }}"
                                class="inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-xs font-semibold text-white transition hover:border-[#a3ff12]/50 hover:bg-[#a3ff12]/10"
                            >
                                Voir la fiche produit
                            </a>
                            <button
                                type="button"
                                class="add-to-cart inline-flex items-center justify-center rounded-xl bg-[#e63946] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#d62f3c]"
                                data-slug="{{ $program->slug }}"
                                data-title="{{ $program->title }}"
                                data-price="{{ $program->price ?? 0 }}"
                                data-image="{{ (string) ($heroCover ?? '') }}"
                            >
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="border-b border-white/10 px-6 py-8 sm:px-8">
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">{{ $program->title }}</h1>
                    @if ($program->price)
                        <p class="mt-2 text-sm font-semibold text-[#a3ff12]">
                            {{ number_format((float) $program->price, 2, ',', ' ') }} DH
                        </p>
                    @endif

                    <div class="mt-4 flex flex-wrap gap-3">
                        <a
                            href="{{ route('client.product.show', $program) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-xs font-semibold text-white transition hover:border-[#a3ff12]/50 hover:bg-[#a3ff12]/10"
                        >
                            Voir la fiche produit
                        </a>
                        <button
                            type="button"
                            class="add-to-cart inline-flex items-center justify-center rounded-xl bg-[#e63946] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#d62f3c]"
                            data-slug="{{ $program->slug }}"
                            data-title="{{ $program->title }}"
                            data-price="{{ $program->price ?? 0 }}"
                            data-image="{{ (string) ($heroCover ?? '') }}"
                        >
                            Ajouter au panier
                        </button>
                    </div>
                </div>
            @endif

            @if ($program->description)
                <div class="px-6 py-6 sm:px-8">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Présentation</h2>

                    @if ($program->slug === 'programme-nutrition-sportive')
                        @php
                            $nutrition = trim((string) $program->description);
                            $lines = preg_split('/\r\n|\n|\r/', $nutrition) ?: [];

                            $headingPrefixes = ['💪', '🎯', '🍳', '🍗', '🥤', '🏋️', '🍽️', '🌙', '📊'];
                            $sections = [];
                            $currentHeading = null;
                            $currentItems = [];

                            foreach ($lines as $line) {
                                $t = trim((string) $line);
                                if ($t === '') {
                                    continue;
                                }

                                $isHeading = false;
                                foreach ($headingPrefixes as $prefix) {
                                    if (str_starts_with($t, $prefix)) {
                                        $isHeading = true;
                                        break;
                                    }
                                }

                                if ($isHeading) {
                                    if ($currentHeading !== null) {
                                        $sections[] = ['heading' => $currentHeading, 'items' => $currentItems];
                                    }
                                    $currentHeading = $t;
                                    $currentItems = [];
                                } else {
                                    $currentItems[] = $t;
                                }
                            }

                            if ($currentHeading !== null) {
                                $sections[] = ['heading' => $currentHeading, 'items' => $currentItems];
                            }
                        @endphp

                        <div class="mt-3 rounded-xl border border-white/10 bg-zinc-950/20 p-6">
                            <div class="space-y-6">
                                @foreach ($sections as $section)
                                    <div>
                                        <h3 class="text-base font-bold tracking-tight text-white">{{ $section['heading'] }}</h3>
                                        @if (!empty($section['items']))
                                            <ul class="mt-3 list-disc space-y-1.5 pl-6 text-zinc-300">
                                                @foreach ($section['items'] as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="mt-3 whitespace-pre-wrap leading-relaxed text-zinc-300">{{ $program->description }}</p>
                    @endif
                </div>
            @endif
        </div>

        @if ($program->videos && $program->videos->count() > 0)
            <div class="mt-12">
                <h2 class="text-xl font-semibold text-white">Vidéos du programme</h2>
                <p class="mt-1 text-sm text-zinc-500">Lecture intégrée ou ouverture sur YouTube.</p>

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($program->videos as $video)
                        @php
                            $embedUrl = null;
                            $url = (string) ($video->url ?? '');
                            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', $url, $m)) {
                                $embedUrl = 'https://www.youtube.com/embed/'.$m[1];
                            }
                        @endphp

                        <article class="flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/40 backdrop-blur transition hover:border-[#a3ff12]/40">
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-white">
                                    <a href="{{ route('client.videos.show', $video) }}" class="hover:text-[#a3ff12]">
                                        {{ $video->title }}
                                    </a>
                                </h3>
                                @if ($video->description)
                                    <p class="mt-2 text-xs leading-relaxed text-zinc-400">
                                        {{ \Illuminate\Support\Str::limit($video->description, 120) }}
                                    </p>
                                @endif
                            </div>

                            @if ($embedUrl)
                                <div class="border-t border-white/5 bg-black/20">
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

                            <div class="mt-auto flex flex-wrap gap-2 border-t border-white/5 p-4">
                                <a
                                    href="{{ route('client.videos.show', $video) }}"
                                    class="inline-flex flex-1 items-center justify-center rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-xs font-semibold text-white transition hover:border-[#a3ff12]/50 hover:bg-[#a3ff12]/10"
                                >
                                    Page vidéo
                                </a>
                                @if ($video->url)
                                    <a
                                        href="{{ $video->url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#a3ff12] px-3 py-2 text-xs font-semibold text-[#0a0b0d] hover:bg-[#b8ff4d]"
                                    >
                                        YouTube
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @else
            <p class="mt-10 text-sm text-zinc-500">Aucune vidéo n’est encore associée à ce programme.</p>
        @endif

        <div class="mt-10">
            <a href="{{ route('client.programs.index') }}" class="text-sm font-semibold text-[#a3ff12] hover:underline">← Retour aux programmes</a>
        </div>
    </div>
@endsection
