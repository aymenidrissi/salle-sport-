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
        $mainImage = $program->publicImageUrl();
        if (! $mainImage && $youtubeId) {
            $mainImage = 'https://img.youtube.com/vi/'.$youtubeId.'/maxresdefault.jpg';
        }
        $isProduitAmincissementFemme = $program->slug === 'programme-amincissement-et-developpement-musculaire-femme';
        $isProduitHypertrophieHomme = $program->slug === 'programme-hypertrophie-homme';
        $isProduitDebutantFemme = $program->slug === 'debutant-femme';
        $debutantCategoryUrl = url('/categorie-produit/debutant');
        $confirmeCategoryUrl = url('/categorie-produit/confirme');
    @endphp

    <div class="bg-white text-zinc-900">
        {{-- Bannière type boutique --}}
        <div class="relative aspect-[21/9] max-h-56 w-full overflow-hidden bg-zinc-800 sm:max-h-72">
            @if ($mainImage)
                <img
                    src="{{ $mainImage }}"
                    alt=""
                    class="h-full w-full object-cover object-center"
                    loading="eager"
                    width="1600"
                    height="400"
                >
            @else
                <div class="h-full w-full bg-gradient-to-br from-zinc-700 to-zinc-900"></div>
            @endif
            <div class="absolute inset-0 bg-black/45"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <p class="text-center text-2xl font-extrabold uppercase tracking-[0.35em] sm:text-4xl {{ $isProduitAmincissementFemme ? 'text-[#f05a42] drop-shadow-sm' : ($isProduitDebutantFemme ? 'text-[#e89999] drop-shadow-sm' : 'text-white') }}">MERCIEMENTS</p>
            </div>
        </div>

        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            {{-- Galerie aperçu --}}
            @if ($mainImage)
                <div class="grid grid-cols-4 gap-2 sm:gap-3">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="aspect-square overflow-hidden rounded border border-zinc-200 bg-zinc-100">
                            <img src="{{ $mainImage }}" alt="" class="h-full w-full object-cover" loading="lazy" width="200" height="200">
                        </div>
                    @endfor
                </div>
            @endif

            <div class="mt-10 grid gap-10 lg:grid-cols-2 lg:gap-12">
                <div>
                    @if ($mainImage)
                        <div class="relative overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50">
                            <img
                                src="{{ $mainImage }}"
                                alt="{{ $program->title }}"
                                class="w-full object-cover"
                                loading="lazy"
                                width="600"
                                height="600"
                            >
                            @if ($isProduitAmincissementFemme)
                                <div class="absolute bottom-4 right-4 max-w-[220px] bg-[#e63946] px-3 py-2.5 text-left text-[10px] font-bold uppercase leading-snug tracking-wide text-black sm:text-[11px]">
                                    PROGRAMME<br>AMINCISSEMENT ET<br>RENFORCEMENT<br>MUSCULAIRE
                                </div>
                            @elseif ($isProduitDebutantFemme)
                                <div class="absolute bottom-4 right-4 max-w-[240px] bg-[#e8a0a8] px-3 py-3 text-left text-[10px] font-bold uppercase leading-snug tracking-wide text-white sm:text-[11px]">
                                    PROGRAMME<br>FEMME<br>DÉBUTANTE
                                </div>
                            @elseif ($isProduitHypertrophieHomme)
                                <div class="absolute bottom-4 left-4 right-4 sm:left-auto sm:right-4 sm:max-w-[280px]">
                                    <p class="bg-[#e63946] px-3 py-2.5 text-center text-[11px] font-bold uppercase leading-snug tracking-wide text-white sm:text-xs">
                                        PROGRAMME<br>HOMME<br>HYPERTROPHIE
                                    </p>
                                </div>
                            @endif
                            <span class="absolute right-3 top-3 rounded-full bg-white/90 p-2 text-zinc-600 shadow" title="Agrandir" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </span>
                        </div>
                    @endif
                </div>

                <div>
                    <nav class="text-sm text-zinc-500" aria-label="Fil d’Ariane">
                        <a href="{{ route('client.home') }}" class="text-[#c41e3a] hover:underline">Accueil</a>
                        <span class="mx-1.5">/</span>
                        @if ($isProduitAmincissementFemme)
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Femme</a>
                            <span class="mx-1.5">/</span>
                            <span class="text-zinc-700">{{ $program->title }}</span>
                        @elseif ($isProduitDebutantFemme)
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Femme</a>
                            <span class="mx-1.5">/</span>
                            <span class="text-zinc-700">Programme femme débutante</span>
                        @elseif ($isProduitHypertrophieHomme)
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Homme</a>
                            <span class="mx-1.5">/</span>
                            <span class="text-zinc-700">Développement musculaire homme</span>
                        @elseif ($program->slug === 'programme-debutant-homme')
                            <a href="{{ $debutantCategoryUrl }}" class="text-[#c41e3a] hover:underline">Débutant</a>
                            <span class="mx-1.5">/</span>
                            <span class="text-zinc-700">{{ $program->title }}</span>
                        @else
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Programmes</a>
                            <span class="mx-1.5">/</span>
                            <span class="text-zinc-700">{{ $program->title }}</span>
                        @endif
                    </nav>

                    <h1 class="mt-4 text-3xl font-semibold tracking-tight text-zinc-800">{{ $program->title }}</h1>

                    @if ($program->price !== null)
                        <p class="mt-3 text-2xl font-bold text-zinc-900">
                            {{ number_format((float) $program->price, 2, ',', ' ') }} DH
                        </p>
                    @endif

                    @if ($program->slug === 'programme-debutant-homme')
                        <div class="mt-6 text-sm leading-relaxed text-zinc-700">
                            <p class="font-medium text-zinc-900">Le programme débutant homme inclut :</p>
                            <ul class="mt-3 list-disc space-y-1.5 pl-5">
                                <li>Un protocole d’échauffement vidéo pour une pratique en sécurité.</li>
                                <li>Une planification structurée et détaillée sur 10 semaines.</li>
                                <li>17 vidéos d’exercices pour optimiser vos séances.</li>
                                <li>De nombreux conseils nutritionnels.</li>
                                <li>Une journée type basée sur l’apport nutritionnel de l’objectif visé.</li>
                                <li>20 idées de recettes saines et savoureuses.</li>
                                <li>Des méthodes concrètes pour évaluer vos progrès.</li>
                                <li>Et bien plus encore…</li>
                            </ul>
                        </div>
                    @elseif ($isProduitDebutantFemme)
                        <div class="mt-6 text-sm leading-relaxed text-zinc-700">
                            <p class="font-medium text-zinc-900">Le programme femme débutante inclut :</p>
                            <ul class="mt-3 list-disc space-y-1.5 pl-5">
                                <li>3 vidéos d’échauffement adaptées au niveau débutant.</li>
                                <li>Une planification structurée et détaillée sur 12 semaines.</li>
                                <li>40 vidéos d’exercices progressives pour sécuriser la technique.</li>
                                <li>Des conseils nutritionnels simples et applicables au quotidien.</li>
                                <li>Un exemple de journée type selon votre objectif.</li>
                                <li>15 recettes saines et faciles à reproduire.</li>
                                <li>Les bases de l’adaptation nutritionnelle selon le cycle menstruel.</li>
                                <li>Des méthodes simples pour évaluer votre progression.</li>
                                <li>Et bien plus encore…</li>
                            </ul>
                        </div>
                    @elseif ($isProduitHypertrophieHomme)
                        <div class="mt-6 text-sm leading-relaxed text-zinc-700">
                            <p class="font-medium text-zinc-900">Le programme d’hypertrophie musculaire homme inclut :</p>
                            <ul class="mt-3 list-disc space-y-1.5 pl-5">
                                <li>3 protocoles d’échauffement vidéo afin de pratiquer en toute sécurité.</li>
                                <li>Une planification structurée et détaillée sur 15 semaines.</li>
                                <li>47 vidéos d’exercices dans le but d’optimiser vos séances.</li>
                                <li>De nombreux conseils nutritionnels.</li>
                                <li>Une journée type en fonction des apports nutritionnels de l’objectif ciblé.</li>
                                <li>20 idées de recettes saines et gourmandes.</li>
                                <li>Des méthodes concrètes pour évaluer votre progression.</li>
                                <li>Et bien plus encore…</li>
                            </ul>
                        </div>
                    @elseif ($isProduitAmincissementFemme)
                        <div class="mt-6 text-sm leading-relaxed text-zinc-700">
                            <p class="font-medium text-zinc-900">Le programme amincissement femme inclut :</p>
                            <ul class="mt-3 list-disc space-y-1.5 pl-5">
                                <li>3 protocoles d’échauffement vidéo afin de pratiquer en toute sécurité.</li>
                                <li>Une planification structurée et détaillée sur 15 semaines.</li>
                                <li>46 vidéos d’exercices dans le but d’optimiser vos séances.</li>
                                <li>De nombreux conseils nutritionnels.</li>
                                <li>Une journée type en fonction des apports nutritionnels de l’objectif ciblé.</li>
                                <li>20 idées de recettes saines et gourmandes.</li>
                                <li>Des adaptations nutritionnelles par rapport à votre cycle menstruel.</li>
                                <li>Des méthodes concrètes pour évaluer votre progression.</li>
                                <li>Et bien plus encore…</li>
                            </ul>
                        </div>
                    @elseif ($program->description)
                        <p class="mt-6 text-sm leading-relaxed text-zinc-700 whitespace-pre-wrap">{{ $program->description }}</p>
                    @endif

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <label class="sr-only" for="qty">Quantité</label>
                        <input
                            id="qty"
                            type="number"
                            min="1"
                            value="1"
                            class="h-11 w-16 rounded border border-zinc-300 px-2 text-center text-sm font-medium text-zinc-900"
                        >
                        <button
                            type="button"
                            class="add-to-cart inline-flex min-h-11 min-w-[160px] items-center justify-center rounded bg-[#e63946] px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d62f3c]"
                            data-slug="{{ $program->slug }}"
                            data-title="{{ $program->title }}"
                            data-price="{{ $program->price ?? 0 }}"
                            data-image="{{ (string) ($mainImage ?? '') }}"
                            data-qty-input="qty"
                        >
                            Ajouter au panier
                        </button>
                    </div>

                    <p class="mt-6 text-sm text-zinc-600">
                        Catégories :
                        @if ($isProduitAmincissementFemme)
                            <a href="{{ $confirmeCategoryUrl }}" class="text-[#c41e3a] hover:underline">Confirmé</a>,
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Femme</a>
                        @elseif ($isProduitDebutantFemme)
                            <a href="{{ $debutantCategoryUrl }}" class="text-[#c41e3a] hover:underline">Débutant</a>,
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Femme</a>
                        @elseif ($isProduitHypertrophieHomme)
                            <a href="{{ $confirmeCategoryUrl }}" class="text-[#c41e3a] hover:underline">Confirmé</a>,
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Homme</a>
                        @elseif ($program->slug === 'programme-debutant-homme')
                            <a href="{{ $debutantCategoryUrl }}" class="text-[#c41e3a] hover:underline">Débutant</a>,
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Homme</a>
                        @else
                            <a href="{{ route('client.programs.index') }}" class="text-[#c41e3a] hover:underline">Programmes</a>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Onglets Description / Avis --}}
            <div class="produit-tabs mt-14 border-b border-zinc-200">
                <div class="flex gap-8 text-sm font-medium">
                    <button
                        type="button"
                        class="produit-tab border-b-2 border-[#e63946] pb-3 text-zinc-900"
                        data-produit-tab="desc"
                    >
                        Description
                    </button>
                    <button
                        type="button"
                        class="produit-tab border-b-2 border-transparent pb-3 text-zinc-500 hover:text-zinc-800"
                        data-produit-tab="reviews"
                    >
                        Avis (0)
                    </button>
                </div>
            </div>

            <div id="panel-desc" class="produit-panel mt-8">
                <h2 class="text-xl font-semibold text-zinc-900">L’approche Fitness tout en un !</h2>
                <div class="mt-4 space-y-4 text-sm leading-relaxed text-zinc-700">
                    @if ($isProduitHypertrophieHomme)
                        @if ($program->description)
                            <p class="whitespace-pre-wrap">{{ $program->description }}</p>
                        @endif
                        <p class="mt-6 font-medium text-zinc-900">Le programme d’hypertrophie musculaire homme inclut :</p>
                        <ul class="mt-3 list-disc space-y-1.5 pl-5">
                            <li>3 protocoles d’échauffement vidéo afin de pratiquer en toute sécurité.</li>
                            <li>Une planification structurée et détaillée sur 15 semaines.</li>
                            <li>47 vidéos d’exercices dans le but d’optimiser vos séances.</li>
                            <li>De nombreux conseils nutritionnels.</li>
                            <li>Une journée type en fonction des apports nutritionnels de l’objectif ciblé.</li>
                            <li>20 idées de recettes saines et gourmandes.</li>
                            <li>Des méthodes concrètes pour évaluer votre progression.</li>
                            <li>Et bien plus encore…</li>
                        </ul>
                    @elseif ($isProduitDebutantFemme)
                        @php
                            $descParts = explode('|||OBJECTIFS|||', (string) ($program->description ?? ''));
                            $blocPhilosophie = trim($descParts[0] ?? '');
                            $blocObjectifs = trim($descParts[1] ?? '');
                        @endphp
                        <h3 class="text-lg font-semibold text-zinc-900">Notre philosophie</h3>
                        <div class="mt-2 whitespace-pre-wrap">{{ $blocPhilosophie }}</div>
                        <h3 class="mt-8 text-lg font-semibold text-zinc-900">Objectifs et bénéfices</h3>
                        <div class="mt-2 whitespace-pre-wrap">{{ $blocObjectifs }}</div>
                        <p class="mt-6 font-medium text-zinc-900">Le programme femme débutante inclut :</p>
                        <ul class="mt-3 list-disc space-y-1.5 pl-5">
                            <li>3 vidéos d’échauffement adaptées au niveau débutant.</li>
                            <li>Une planification structurée et détaillée sur 12 semaines.</li>
                            <li>40 vidéos d’exercices progressives pour sécuriser la technique.</li>
                            <li>Des conseils nutritionnels simples et applicables au quotidien.</li>
                            <li>Un exemple de journée type selon votre objectif.</li>
                            <li>15 recettes saines et faciles à reproduire.</li>
                            <li>Les bases de l’adaptation nutritionnelle selon le cycle menstruel.</li>
                            <li>Des méthodes simples pour évaluer votre progression.</li>
                            <li>Et bien plus encore…</li>
                        </ul>
                    @elseif ($program->description)
                        <p class="whitespace-pre-wrap">{{ $program->description }}</p>
                    @else
                        <p>
                            Nous avons l’ambition de vous proposer un programme d’entraînement « tout en un » pour les passionnés de musculation.
                        </p>
                        <p>
                            Le programme débutant est spécialement conçu pour les personnes ayant peu d’expérience en musculation : il vous offre des outils concrets pour comprendre le « quoi » et le « pourquoi » de votre entraînement et progresser vers vos objectifs.
                        </p>
                    @endif
                </div>
            </div>

            <div id="panel-reviews" class="produit-panel mt-8 hidden">
                <p class="text-sm text-zinc-600">Aucun avis pour le moment.</p>
            </div>

            @if ($program->videos && $program->videos->count() > 0)
                <div class="mt-14 border-t border-zinc-100 pt-12">
                    <h2 class="text-xl font-semibold text-zinc-900">Vidéos du programme</h2>
                    <p class="mt-1 text-sm text-zinc-500">Lecture intégrée ou ouverture sur YouTube.</p>

                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach ($program->videos as $video)
                            @php
                                $embedUrl = null;
                                $url = (string) ($video->url ?? '');
                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', $url, $m)) {
                                    $embedUrl = 'https://www.youtube.com/embed/'.$m[1];
                                }
                            @endphp

                            <article class="flex flex-col overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 shadow-sm transition hover:border-[#e63946]/40">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold text-zinc-900">
                                        <a href="{{ route('client.videos.show', $video) }}" class="hover:text-[#c41e3a]">
                                            {{ $video->title }}
                                        </a>
                                    </h3>
                                    @if ($video->description)
                                        <p class="mt-2 text-xs leading-relaxed text-zinc-600">
                                            {{ \Illuminate\Support\Str::limit($video->description, 120) }}
                                        </p>
                                    @endif
                                </div>

                                @if ($embedUrl)
                                    <div class="border-t border-zinc-200 bg-black">
                                        <div class="relative aspect-video w-full overflow-hidden">
                                            <iframe
                                                class="absolute inset-0 h-full w-full"
                                                src="{{ $embedUrl }}"
                                                title="{{ $video->title }}"
                                                loading="lazy"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen
                                            ></iframe>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-auto flex flex-wrap gap-2 border-t border-zinc-200 p-4">
                                    <a
                                        href="{{ route('client.videos.show', $video) }}"
                                        class="inline-flex flex-1 items-center justify-center rounded-lg border border-zinc-300 bg-white px-3 py-2 text-xs font-semibold text-zinc-800 transition hover:border-zinc-400"
                                    >
                                        Page vidéo
                                    </a>
                                    @if ($video->url)
                                        <a
                                            href="{{ $video->url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex flex-1 items-center justify-center rounded-lg bg-[#e63946] px-3 py-2 text-xs font-semibold text-white hover:bg-[#d62f3c]"
                                        >
                                            YouTube
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($program->slug === 'programme-debutant-homme')
                <div class="mt-14 border-t border-zinc-100 pt-12 text-sm leading-relaxed text-zinc-700">
                    <p class="font-medium text-zinc-900">Le programme débutant homme inclut :</p>
                    <ul class="mt-4 list-disc space-y-1.5 pl-5">
                        <li>Un protocole d’échauffement vidéo pour une pratique en sécurité.</li>
                        <li>Une planification structurée et détaillée sur 10 semaines.</li>
                        <li>17 vidéos d’exercices pour optimiser vos séances.</li>
                        <li>De nombreux conseils nutritionnels.</li>
                        <li>Une journée type basée sur l’apport nutritionnel de l’objectif visé.</li>
                        <li>20 idées de recettes saines et savoureuses.</li>
                        <li>Des méthodes concrètes pour évaluer vos progrès.</li>
                        <li>Et bien plus encore…</li>
                    </ul>
                    <p class="mt-8 text-center text-base font-semibold text-zinc-900">
                        Alors n’attendez plus, et VENEZ-VOUS ENTRAÎNER AVEC NOUS !
                    </p>
                </div>
            @elseif ($isProduitDebutantFemme)
                <div class="mt-14 border-t border-zinc-100 pt-12 text-sm leading-relaxed text-zinc-700">
                    <p class="font-medium text-zinc-900">Le programme femme débutante inclut :</p>
                    <ul class="mt-4 list-disc space-y-1.5 pl-5">
                        <li>3 vidéos d’échauffement adaptées au niveau débutant.</li>
                        <li>Une planification structurée et détaillée sur 12 semaines.</li>
                        <li>40 vidéos d’exercices progressives pour sécuriser la technique.</li>
                        <li>Des conseils nutritionnels simples et applicables au quotidien.</li>
                        <li>Un exemple de journée type selon votre objectif.</li>
                        <li>15 recettes saines et faciles à reproduire.</li>
                        <li>Les bases de l’adaptation nutritionnelle selon le cycle menstruel.</li>
                        <li>Des méthodes simples pour évaluer votre progression.</li>
                        <li>Et bien plus encore…</li>
                    </ul>
                    <p class="mt-8 text-center text-base font-semibold uppercase tracking-wide text-zinc-900">
                        VENEZ VOUS ENTRAÎNER AVEC NOUS !
                    </p>
                </div>
            @elseif ($isProduitAmincissementFemme)
                <div class="mt-14 border-t border-zinc-100 pt-12 text-sm leading-relaxed text-zinc-700">
                    <p>
                        Ce programme vous aide à développer votre force, à bâtir une base solide et à utiliser la graisse corporelle comme source d’énergie au service de vos séances.
                    </p>
                    <p class="mt-6 font-medium text-zinc-900">Le programme amincissement femme inclut :</p>
                    <ul class="mt-4 list-disc space-y-1.5 pl-5">
                        <li>3 protocoles d’échauffement vidéo afin de pratiquer en toute sécurité.</li>
                        <li>Une planification structurée et détaillée sur 15 semaines.</li>
                        <li>46 vidéos d’exercices dans le but d’optimiser vos séances.</li>
                        <li>De nombreux conseils nutritionnels.</li>
                        <li>Une journée type en fonction des apports nutritionnels de l’objectif ciblé.</li>
                        <li>20 idées de recettes saines et gourmandes.</li>
                        <li>Des adaptations nutritionnelles par rapport à votre cycle menstruel.</li>
                        <li>Des méthodes concrètes pour évaluer votre progression.</li>
                        <li>Et bien plus encore…</li>
                    </ul>
                    <p class="mt-8 text-center text-base font-semibold text-zinc-900">
                        Vous souhaitez concrétiser vos objectifs ? Alors n’attendez plus, et VENEZ VOUS ENTRAÎNER AVEC NOUS !
                    </p>
                </div>
            @elseif ($isProduitHypertrophieHomme)
                <div class="mt-14 border-t border-zinc-100 pt-12 text-sm leading-relaxed text-zinc-700">
                    <p class="text-center text-base font-semibold text-zinc-900">
                        Alors… Venez-vous entraîner avec nous, et accrochez votre ceinture, car à partir de ce moment, le mode : « destruction de fibres musculaires » est activé !!!
                    </p>
                </div>
            @endif

            @if ($related->isNotEmpty())
                <div class="mt-16 border-t border-zinc-200 pt-12">
                    <h2 class="text-lg font-semibold text-zinc-900">Produits associés</h2>
                    <div class="mt-8 grid gap-8 sm:grid-cols-2">
                        @foreach ($related as $rel)
                            @php
                                $rv = $rel->videos?->first();
                                $ryt = null;
                                if ($rv && $rv->url) {
                                    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{10,15})/', (string) $rv->url, $rm)) {
                                        $ryt = $rm[1];
                                    }
                                }
                                $relImg = $rel->publicImageUrl();
                                if (! $relImg && $ryt) {
                                    $relImg = 'https://img.youtube.com/vi/'.$ryt.'/hqdefault.jpg';
                                }
                            @endphp
                            <article class="flex flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
                                <a href="{{ route('client.product.show', $rel) }}" class="relative block aspect-square overflow-hidden bg-zinc-100">
                                    @if ($relImg)
                                        <img src="{{ $relImg }}" alt="" class="h-full w-full object-cover" loading="lazy" width="400" height="400">
                                    @endif
                                    <span class="absolute bottom-3 left-3 right-3 rounded bg-black/55 px-2 py-1 text-center text-xs font-bold uppercase text-white">
                                        {{ $rel->title }}
                                    </span>
                                </a>
                                <div class="flex flex-1 flex-col p-4">
                                    <h3 class="font-semibold text-zinc-900">
                                        <a href="{{ route('client.product.show', $rel) }}" class="hover:text-[#c41e3a]">{{ $rel->title }}</a>
                                    </h3>
                                    <p class="mt-1 text-sm text-zinc-500">
                                        @if (str_contains((string) $rel->slug, 'nutrition'))
                                            Nutrition
                                        @elseif (str_contains((string) $rel->slug, 'debutant'))
                                            Débutant
                                        @else
                                            Confirmé
                                        @endif
                                    </p>
                                    @if ($rel->price !== null)
                                        <p class="mt-2 text-sm font-semibold text-zinc-900">
                                            {{ number_format((float) $rel->price, 2, ',', ' ') }} DH
                                        </p>
                                    @endif
                                    <button
                                        type="button"
                                        class="add-to-cart mt-4 w-full rounded bg-[#e63946] py-2.5 text-sm font-semibold text-white hover:bg-[#d62f3c]"
                                        data-slug="{{ $rel->slug }}"
                                        data-title="{{ $rel->title }}"
                                        data-price="{{ $rel->price ?? 0 }}"
                                        data-image="{{ (string) ($relImg ?? '') }}"
                                    >
                                        Ajouter au panier
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            <p class="mt-12 text-center text-sm text-zinc-500">
                <a href="{{ route('client.programs.index') }}" class="font-medium text-[#c41e3a] hover:underline">← Tous les programmes</a>
            </p>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-produit-tab]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var tab = btn.getAttribute('data-produit-tab');
                document.querySelectorAll('.produit-tab').forEach(function (b) {
                    var active = b.getAttribute('data-produit-tab') === tab;
                    b.classList.toggle('border-[#e63946]', active);
                    b.classList.toggle('border-transparent', !active);
                    b.classList.toggle('text-zinc-900', active);
                    b.classList.toggle('text-zinc-500', !active);
                });
                document.getElementById('panel-desc').classList.toggle('hidden', tab !== 'desc');
                document.getElementById('panel-reviews').classList.toggle('hidden', tab !== 'reviews');
            });
        });
    </script>
@endsection
