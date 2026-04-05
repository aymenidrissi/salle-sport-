@extends('layouts.app')

@section('title', 'Accueil — Athleticore')

@section('content')
    <div class="w-full min-w-0 overflow-x-hidden bg-[#0a0b0d]">
        {{-- Hero (style référence : texte à gauche, image salle, CTA blanc + contour) --}}
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/75 to-black/40 lg:to-transparent"></div>
                <img
                    src="{{ asset('images/home-first-force.png') }}"
                    alt=""
                    class="h-[min(70vh,560px)] w-full object-cover object-center sm:h-[min(75vh,620px)] lg:absolute lg:inset-y-0 lg:right-0 lg:h-full lg:w-[58%] lg:max-w-none lg:object-cover"
                    width="1600"
                    height="900"
                    loading="eager"
                    fetchpriority="high"
                >
            </div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
                <div class="max-w-xl lg:max-w-lg">
                    <h1 class="text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl md:text-[2.75rem]">
                        Programmes sportifs à distance
                    </h1>
                    <p class="mt-5 text-[15px] leading-relaxed text-white/90 sm:text-base">
                        <strong class="font-semibold text-white">Athleticore</strong> vous permet de suivre l’un de nos programmes sportifs en ligne,
                        à tout moment de la journée et où que vous soyez. Déclinés selon vos objectifs et votre niveau, ces entraînements ont été
                        conçus par des professionnels du sport, du fitness et de la musculation.
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a
                            href="{{ route('client.programs.index') }}"
                            class="inline-flex min-h-[48px] w-full items-center justify-center rounded-md bg-white px-6 py-3 text-sm font-semibold text-zinc-900 shadow-lg transition hover:bg-zinc-100 sm:w-auto"
                        >
                            Programmes de sport
                        </a>
                        <a
                            href="{{ route('client.about') }}"
                            class="inline-flex min-h-[48px] w-full items-center justify-center rounded-md border-2 border-white/90 bg-transparent px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10 sm:w-auto"
                        >
                            En savoir plus
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4 cartes programmes (ligne desktop) --}}
        <section class="border-t border-white/10 bg-[#0c0d11] py-12 sm:py-16 lg:py-20" aria-labelledby="home-cards-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 id="home-cards-heading" class="sr-only">Programmes phares</h2>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4 lg:gap-5">
                    @forelse ($programs as $program)
                        @php
                            $video = $program->videos?->first();
                            $youtubeId = null;
                            if ($video && $video->url) {
                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', (string) $video->url, $m)) {
                                    $youtubeId = $m[1];
                                }
                            }
                            $coverUrl = $program->publicImageUrl();
                            if (! $coverUrl && $youtubeId) {
                                $coverUrl = 'https://img.youtube.com/vi/'.$youtubeId.'/hqdefault.jpg';
                            }
                            if (! $coverUrl) {
                                $coverUrl = asset('images/home-hero.png');
                            }
                        @endphp
                        <article class="flex min-h-[360px] flex-col overflow-hidden rounded-lg border border-white/10 bg-zinc-900/40 shadow-xl sm:min-h-[380px]">
                            <div class="relative flex min-h-[200px] flex-1 flex-col justify-end">
                                <img src="{{ $coverUrl }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>
                                <div class="relative z-10 flex flex-col gap-3 p-4 sm:p-5">
                                    <h3 class="text-sm font-bold uppercase leading-snug tracking-wide text-white sm:text-base">
                                        {{ $program->title }}
                                    </h3>
                                    <p class="line-clamp-3 text-xs leading-relaxed text-white/95 sm:text-sm">
                                        {{ $program->description ? \Illuminate\Support\Str::limit(strip_tags($program->description), 120) : 'Programme complet avec vidéos et suivi.' }}
                                    </p>
                                    <a
                                        href="{{ route('client.programs.show', $program) }}"
                                        class="mt-1 inline-flex min-h-[44px] w-full items-center justify-center rounded bg-orange-600 px-3 py-2.5 text-center text-[11px] font-bold uppercase tracking-wide text-white transition hover:bg-orange-500 sm:text-xs"
                                    >
                                        Voir le programme
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        @foreach ([
                            ['t' => 'Débutant homme', 'd' => 'Débutez avec des bases solides pour des résultats concrets !', 'b' => 'Programme sport homme débutant'],
                            ['t' => 'Débutant femme', 'd' => 'Un programme qui regroupe l’essentiel pour débuter en douceur !', 'b' => 'Programme sport femme débutant'],
                            ['t' => 'Développement musculaire', 'd' => 'Assurez-vous une prise de masse optimale !', 'b' => 'Programme développement musculaire homme'],
                            ['t' => 'Amincissement femme', 'd' => 'Passez à l’étape supérieure pour affiner votre silhouette !', 'b' => 'Programme amincissement femme'],
                        ] as $card)
                            <article class="flex min-h-[360px] flex-col overflow-hidden rounded-lg border border-white/10 bg-zinc-900/40 shadow-xl sm:min-h-[380px]">
                                <div class="relative flex min-h-[200px] flex-1 flex-col justify-end">
                                    <img src="{{ asset('images/home-hero.png') }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-95" loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>
                                    <div class="relative z-10 flex flex-col gap-3 p-4 sm:p-5">
                                        <h3 class="text-sm font-bold uppercase leading-snug tracking-wide text-white sm:text-base">{{ $card['t'] }}</h3>
                                        <p class="text-xs leading-relaxed text-white/95 sm:text-sm">{{ $card['d'] }}</p>
                                        <a href="{{ route('client.programs.index') }}" class="mt-1 inline-flex min-h-[44px] w-full items-center justify-center rounded bg-orange-600 px-3 py-2.5 text-center text-[11px] font-bold uppercase tracking-wide text-white hover:bg-orange-500 sm:text-xs">{{ $card['b'] }}</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        {{-- 3 arguments (fond blanc, 3 colonnes alignées) --}}
        <section class="bg-white py-12 sm:py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-10 md:grid-cols-3 md:gap-8 lg:gap-12">
                    <div class="text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-600/10 text-red-600">
                            <span class="text-2xl font-bold" aria-hidden="true">A–Z</span>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-zinc-900">Programmes sportifs 100&nbsp;% complets</h3>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">
                            Les premiers programmes de sports qui couvrent tous les éléments entrant en jeu dans votre transformation physique.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-600/10 text-red-600">
                            <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-zinc-900">Créés par des pros de la fitness &amp; musculation</h3>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">
                            Nos programmes ont été réalisés par des coachs diplômés d’État. Ils reposent sur des techniques incontournables du milieu professionnel.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-600/10 text-red-600">
                            <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-zinc-900">Entraînements en ligne adaptés à votre besoin</h3>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600">
                            Que vous soyez sportif débutant ou confirmé, nous avons le programme qui vous correspond pour atteindre vos objectifs.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Vidéos : une seule grille, 3 colonnes dès md (plus de mise en page en V) --}}
        <section class="relative overflow-hidden border-t border-zinc-200 bg-zinc-100 py-12 sm:py-16 lg:py-20" aria-labelledby="home-videos-heading">
            <div
                class="pointer-events-none absolute inset-0 bg-cover bg-center opacity-40"
                style="background-image: linear-gradient(180deg, rgba(250,250,250,0.95), rgba(250,250,250,0.98)), url('{{ asset('images/bg-exercices-videos.png') }}');"
                aria-hidden="true"
            ></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 id="home-videos-heading" class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">
                        Exercices sportifs en vidéo
                    </h2>
                    <div class="mx-auto mt-3 h-0.5 w-16 bg-red-600/90"></div>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-6 sm:mt-12 md:grid-cols-3 md:gap-6 lg:gap-8">
                    @foreach ($homeVideoIds as $index => $ytId)
                        <div class="overflow-hidden rounded-lg border border-zinc-200 bg-black shadow-lg">
                            <div class="relative aspect-video w-full">
                                <iframe
                                    class="absolute inset-0 h-full w-full"
                                    src="https://www.youtube.com/embed/{{ $ytId }}?rel=0"
                                    title="Vidéo {{ $index + 1 }}"
                                    loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Texte + visuel (référence capture) --}}
        <section class="border-t border-zinc-200 bg-zinc-50 py-12 sm:py-16 lg:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">
                    Nos 4 programmes sportifs
                </h2>
                <div class="mt-6 space-y-4 text-left text-sm leading-relaxed text-zinc-700 sm:text-base">
                    <p>
                        Vous l’aurez compris, <strong>Athleticore</strong> vous propose une gamme de programmes conçus par des professionnels de la santé et du sport.
                    </p>
                    <p>
                        Ces programmes ont plusieurs volets : éducation sportive, compréhension des muscles sollicités, alimentation à adopter, et surtout le <em>pourquoi</em> de chaque séance.
                    </p>
                    <p>
                        Il vous reste des doutes ? <a href="{{ route('client.contact') }}" class="font-semibold text-orange-600 underline-offset-2 hover:underline">Contactez-nous</a>, nous vous aidons à lever vos blocages.
                    </p>
                </div>
                <div class="mt-10 overflow-hidden rounded-lg border border-zinc-200 shadow-md">
                    <img
                        src="{{ asset('images/home-hero.png') }}"
                        alt="Salle de sport Athleticore"
                        class="h-auto w-full object-cover"
                        loading="lazy"
                        width="1200"
                        height="500"
                    >
                </div>
            </div>
        </section>

        {{-- Boutique : 4 cartes sur xl --}}
        <section class="bg-[#f0f0f0] py-12 sm:py-16 lg:py-20" aria-labelledby="home-shop-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 id="home-shop-heading" class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">
                        Nos programmes de sport en ligne
                    </h2>
                    <div class="mx-auto mt-3 h-px w-12 bg-zinc-400"></div>
                </div>
                @php
                    $levelCycle = ['Débutant', 'Débutant', 'Confirmé', 'Confirmé'];
                    $priceDemo = [19, 89, 89, 19];
                @endphp
                <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4 lg:gap-6">
                    @forelse ($programs as $i => $program)
                        @php
                            $video = $program->videos?->first();
                            $youtubeId = null;
                            if ($video && $video->url) {
                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', (string) $video->url, $m)) {
                                    $youtubeId = $m[1];
                                }
                            }
                            $thumb = $program->publicImageUrl();
                            if (! $thumb && $youtubeId) {
                                $thumb = 'https://img.youtube.com/vi/'.$youtubeId.'/hqdefault.jpg';
                            }
                            if (! $thumb) {
                                $thumb = asset('images/home-hero.png');
                            }
                            $level = $levelCycle[$i % count($levelCycle)];
                            $levelUrl = strtolower($level) === 'confirmé'
                                ? url('/categorie-produit/confirme')
                                : url('/categorie-produit/debutant');
                            $price = $program->price !== null ? number_format((float) $program->price, 2, ',', ' ') : number_format($priceDemo[$i % count($priceDemo)], 2, ',', ' ');
                        @endphp
                        <article class="flex flex-col overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-zinc-200/80">
                            <div class="relative aspect-[4/3] w-full overflow-hidden bg-zinc-200 sm:aspect-square">
                                <img src="{{ $thumb }}" alt="" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="flex flex-1 flex-col p-4 sm:p-5">
                                <h3 class="line-clamp-2 text-base font-bold text-zinc-900">{{ $program->title }}</h3>
                                <p class="mt-1 text-sm text-zinc-500">
                                    <a href="{{ $levelUrl }}" class="hover:text-red-700 hover:underline">{{ $level }}</a>
                                </p>
                                <p class="mt-3 text-lg font-bold text-zinc-900">{{ $price }} DH</p>
                                <button
                                    type="button"
                                    class="add-to-cart mt-4 inline-flex min-h-[46px] w-full items-center justify-center rounded-lg bg-orange-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-orange-500"
                                    data-slug="{{ $program->slug }}"
                                    data-title="{{ $program->title }}"
                                    data-price="{{ $program->price ?? 0 }}"
                                    data-image="{{ $thumb }}"
                                >
                                    Ajouter au panier
                                </button>
                            </div>
                        </article>
                    @empty
                        @foreach (range(0, 3) as $i)
                            @php
                                $titles = ['Débutant femme', 'Amincissement femme', 'Développement musculaire homme', 'Débutant homme'];
                            @endphp
                            <article class="flex flex-col overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-zinc-200/80">
                                <div class="relative aspect-[4/3] w-full overflow-hidden bg-zinc-200 sm:aspect-square">
                                    <img src="{{ asset('images/home-hero.png') }}" alt="" class="h-full w-full object-cover" loading="lazy">
                                </div>
                                <div class="flex flex-1 flex-col p-4 sm:p-5">
                                    <h3 class="text-base font-bold text-zinc-900">{{ $titles[$i] }}</h3>
                                    <p class="mt-1 text-sm text-zinc-500">
                                        <a href="{{ strtolower($levelCycle[$i % 4]) === 'confirmé' ? url('/categorie-produit/confirme') : url('/categorie-produit/debutant') }}" class="hover:text-red-700 hover:underline">{{ $levelCycle[$i % 4] }}</a>
                                    </p>
                                    <p class="mt-3 text-lg font-bold text-zinc-900">{{ $priceDemo[$i] }},00 DH</p>
                                    <button
                                        type="button"
                                        class="add-to-cart mt-4 inline-flex min-h-[46px] w-full items-center justify-center rounded-lg bg-orange-600 px-4 py-3 text-sm font-semibold text-white hover:bg-orange-500"
                                        data-slug="demo-{{ $i }}"
                                        data-title="{{ $titles[$i] }}"
                                        data-price="{{ $priceDemo[$i] }}"
                                        data-image="{{ asset('images/home-hero.png') }}"
                                    >
                                        Ajouter au panier
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

    </div>
@endsection
