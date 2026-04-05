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
        $resourceHttpLink = $program->externalHttpImageField();
        $heroCover = $program->heroOrCardImageUrl();
        if (! $heroCover && $youtubeId) {
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
            @if ($program->imageFieldIsNonDisplayableHttpResource() && $resourceHttpLink)
                <div class="border-b border-white/10 bg-zinc-900/80 px-6 py-3 sm:px-8">
                    <a
                        href="{{ $resourceHttpLink }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#a3ff12] underline decoration-[#a3ff12]/40 underline-offset-2 hover:text-[#b8ff4d]"
                    >
                        <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Ouvrir le lien du programme (document)
                    </a>
                </div>
            @endif
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
                            @if (!empty($assignedProgramPdfLink))
                                <a
                                    href="{{ $assignedProgramPdfLink }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-xl border border-[#a3ff12]/50 bg-[#a3ff12]/10 px-4 py-2 text-xs font-extrabold text-[#a3ff12] transition hover:bg-[#a3ff12]/20"
                                >
                                    Programme complet (PDF)
                                </a>
                            @endif
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
                        @if (!empty($assignedProgramPdfLink))
                            <a
                                href="{{ $assignedProgramPdfLink }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-xl border border-[#a3ff12]/50 bg-[#a3ff12]/10 px-4 py-2 text-xs font-extrabold text-[#a3ff12] transition hover:bg-[#a3ff12]/20"
                            >
                                Programme complet (PDF)
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            @if ($program->description)
                <div class="px-6 py-6 sm:px-8">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500">Présentation</h2>

                    @if ($program->slug === 'programme-nutrition-sportive')
                        <div class="mt-3 rounded-xl border border-white/10 bg-zinc-950/20 p-6">
                            @if (session('status'))
                                <div class="mb-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-semibold text-emerald-200">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm font-semibold text-red-200">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @auth
                                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-white">Conseils nutrition spéciaux</p>
                                        <p class="mt-1 text-xs text-zinc-400">Cliquez pour ajouter la demande au panier puis validez votre commande.</p>
                                    </div>
                                    <button
                                        type="button"
                                        class="add-to-cart inline-flex items-center justify-center rounded-xl bg-[#a3ff12] px-4 py-2 text-xs font-extrabold text-[#0a0b0d] transition hover:bg-[#b8ff4d]"
                                        data-slug="demande-conseil-special-nutrition"
                                        data-title="Demande conseil nutrition special"
                                        data-price="0"
                                        data-image=""
                                    >
                                        Demander un conseil spécial
                                    </button>
                                </div>
                            @endauth

                            @guest
                                <div class="mb-6 rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-zinc-300">
                                    Connectez-vous pour demander un conseil nutrition spécial.
                                </div>
                            @endguest

                            @if (isset($nutritionTips) && $nutritionTips->count() > 0)
                                <div class="space-y-6">
                                    @foreach ($nutritionTips as $tip)
                                        <div>
                                            <h3 class="text-base font-bold tracking-tight text-white">{{ $tip->title }}</h3>
                                            <p class="mt-3 whitespace-pre-wrap leading-relaxed text-zinc-300">{{ $tip->content }}</p>
                                            @if (!empty($tip->image))
                                                <a
                                                    href="{{ $tip->image }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="mt-3 inline-flex items-center gap-2 rounded-lg border border-[#a3ff12]/40 bg-[#a3ff12]/10 px-3 py-1.5 text-xs font-semibold text-[#a3ff12] hover:bg-[#a3ff12]/20"
                                                >
                                                    Ouvrir le PDF
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-zinc-400">
                                    Aucun conseil nutrition pour le moment. Ajoute-en depuis l’admin.
                                </p>
                            @endif
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
        @elseif (! empty($program->video_url))
            @php
                $adminVideoUrl = (string) $program->video_url;
                $adminVideoEmbed = null;
                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', $adminVideoUrl, $am)) {
                    $adminVideoEmbed = 'https://www.youtube.com/embed/'.$am[1];
                }
            @endphp
            <div class="mt-12">
                <h2 class="text-xl font-semibold text-white">Vidéos du programme</h2>
                <p class="mt-1 text-sm text-zinc-500">Vidéo définie depuis l’administration.</p>

                <div class="mt-6">
                    <article class="flex max-w-3xl flex-col overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/40 backdrop-blur">
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-white">{{ $program->title }}</h3>
                            <p class="mt-1 text-xs text-zinc-400">Lecture intégrée</p>
                        </div>
                        @if ($adminVideoEmbed)
                            <div class="border-t border-white/5 bg-black/20">
                                <div class="relative aspect-video w-full overflow-hidden">
                                    <iframe
                                        class="absolute inset-0 h-full w-full"
                                        src="{{ $adminVideoEmbed }}"
                                        title="Vidéo — {{ $program->title }}"
                                        loading="lazy"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            </div>
                        @else
                            <div class="border-t border-white/5 px-4 py-4">
                                <a
                                    href="{{ $adminVideoUrl }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#a3ff12] underline decoration-[#a3ff12]/40 underline-offset-2 hover:text-[#b8ff4d]"
                                >
                                    Ouvrir la vidéo
                                </a>
                            </div>
                        @endif
                    </article>
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
