@extends('layouts.app')

@section('title', 'Programmes — Athleticore')

@section('content')
    <div class="bg-white text-zinc-900">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
            {{-- Fil d’Ariane --}}
            <nav class="text-sm text-zinc-500" aria-label="Fil d’Ariane">
                <a href="{{ route('client.home') }}" class="hover:text-orange-600">Accueil</a>
                <span class="mx-2 text-zinc-400">/</span>
                <span class="text-zinc-700">Séances de sport en ligne</span>
            </nav>

            <div class="mt-8 max-w-3xl">
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">Séances de sport en ligne</h1>
                <p class="mt-3 text-sm leading-relaxed text-zinc-600 sm:text-base">
                    Suivez votre programme d’entraînement à distance : des séances structurées, des contenus clairs et un accès
                    pratique pour progresser chez vous ou en salle, à votre rythme.
                </p>
                <p class="mt-4 text-sm text-zinc-500">
                    Affichage de
                    <span class="font-semibold text-zinc-800">{{ $programs->total() }}</span>
                    résultat{{ $programs->total() > 1 ? 's' : '' }}
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
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

                    <article class="flex flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm transition hover:shadow-md">
                        <a
                            href="{{ route('client.programs.show', $program) }}"
                            class="group relative block aspect-square w-full overflow-hidden bg-zinc-100"
                        >
                            @if ($coverUrl)
                                <img
                                    src="{{ $coverUrl }}"
                                    alt=""
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]"
                                    loading="lazy"
                                    width="400"
                                    height="400"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-200 to-zinc-300">
                                    <svg class="h-16 w-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            {{-- Effet « vitre brisée » léger + voile --}}
                            <div
                                class="pointer-events-none absolute inset-0 opacity-40 mix-blend-overlay"
                                style="background-image: repeating-linear-gradient(
                                    -45deg,
                                    transparent,
                                    transparent 3px,
                                    rgba(255,255,255,0.12) 3px,
                                    rgba(255,255,255,0.12) 4px
                                ), repeating-linear-gradient(
                                    45deg,
                                    transparent,
                                    transparent 8px,
                                    rgba(0,0,0,0.06) 8px,
                                    rgba(0,0,0,0.06) 9px
                                );"
                                aria-hidden="true"
                            ></div>
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-white/10"></div>

                            {{-- Bandeau titre programme (style maquette) --}}
                            <div class="absolute inset-x-0 bottom-0 bg-rose-600/92 px-2 py-3 sm:px-3">
                                <p class="text-center text-[0.65rem] font-bold uppercase leading-tight tracking-wide text-white sm:text-[0.7rem]">
                                    {{ $program->overlayBannerText() }}
                                </p>
                            </div>
                        </a>

                        <div class="flex flex-1 flex-col px-4 pb-4 pt-4">
                            <h2 class="text-base font-bold text-zinc-900">
                                <a href="{{ route('client.programs.show', $program) }}" class="hover:text-orange-600">
                                    {{ $program->listingTitle() }}
                                </a>
                            </h2>
                            @if ($program->levelLabel() !== '—')
                                <p class="mt-1 text-sm text-zinc-500">{{ $program->levelLabel() }}</p>
                            @else
                                <p class="mt-1 text-sm text-zinc-400">—</p>
                            @endif

                            @if ($program->price)
                                <p class="mt-3 text-base font-bold text-zinc-900">
                                    {{ number_format((float) $program->price, 2, ',', ' ') }} DH
                                </p>
                            @endif

                            <button
                                type="button"
                                class="add-to-cart mt-4 w-full rounded-md bg-orange-600 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700"
                                data-slug="{{ $program->slug }}"
                                data-title="{{ $program->title }}"
                                data-price="{{ $program->price ?? 0 }}"
                                data-image="{{ (string) ($coverUrl ?? '') }}"
                            >
                                Ajouter au panier
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-lg border border-zinc-200 bg-zinc-50 py-16 text-center text-zinc-500">
                        Aucun programme pour le moment.
                    </div>
                @endforelse
            </div>

            @if ($programs->hasPages())
                <div class="mt-10 text-sm text-zinc-600 [&_a]:text-orange-600 [&_a]:hover:underline">
                    {{ $programs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
