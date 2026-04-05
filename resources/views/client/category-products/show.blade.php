@extends('layouts.app')

@section('title', $categoryLabel.' — Catégorie de produits')

@section('content')
    <div class="relative overflow-hidden">
        <div
            class="pointer-events-none absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: linear-gradient(rgba(245, 245, 245, 0.92), rgba(245, 245, 245, 0.92)), url('{{ asset('images/bg-category.png') }}');"
            aria-hidden="true"
        ></div>

        <div class="relative mx-auto max-w-7xl px-4 py-10 text-zinc-900">
        <div class="grid gap-8 lg:grid-cols-[300px_1fr]">
            <aside class="space-y-9 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm">
                <form action="{{ url('/categorie-produit/'.$category) }}" method="get" class="flex gap-2">
                    <input
                        type="text"
                        value=""
                        placeholder="Rechercher des produits..."
                        class="min-w-0 flex-1 rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-[#e63946]"
                    >
                    <button type="submit" class="rounded-md bg-[#f04c3d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#e63946]">Rechercher</button>
                </form>

                <section>
                    <h3 class="text-4xl font-semibold text-zinc-900">Nos meilleures ventes</h3>
                    <div class="mt-6 space-y-4">
                        @foreach ($bestSellers as $item)
                            @php
                                $img = $item->image ? asset('storage/'.$item->image) : '';
                            @endphp
                            <div class="flex gap-3 border-b border-zinc-200 pb-4">
                                <div class="h-16 w-16 shrink-0 overflow-hidden bg-zinc-100">
                                    @if ($img)
                                        <img src="{{ $img }}" alt="" class="h-full w-full object-cover" loading="lazy">
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('client.product.show', $item) }}" class="text-2xl text-[#e63946] underline hover:text-[#c72c3a]">
                                        {{ $item->title }}
                                    </a>
                                    <div class="mt-1 text-[#e63946]">☆☆☆☆☆</div>
                                    <p class="mt-1 text-2xl font-semibold text-zinc-900">{{ number_format((float) ($item->price ?? 0), 2, ',', ' ') }} DH</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section>
                    <h3 class="text-4xl font-semibold text-zinc-900">Parcourir par catégories</h3>
                    <ul class="mt-5 space-y-3 text-2xl">
                        <li class="flex items-center justify-between">
                            <a href="{{ url('/categorie-produit/confirme') }}" class="text-[#e63946] underline hover:text-[#c72c3a]">Confirmé</a>
                            <span>({{ $counts['confirme'] }})</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <a href="{{ url('/categorie-produit/debutant') }}" class="text-[#e63946] underline hover:text-[#c72c3a]">Débutant</a>
                            <span>({{ $counts['debutant'] }})</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span class="text-[#e63946] underline">Femme</span>
                            <span>({{ $counts['femme'] }})</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span class="text-[#e63946] underline">Homme</span>
                            <span>({{ $counts['homme'] }})</span>
                        </li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-4xl font-semibold text-zinc-900">Filtrer par prix</h3>
                    <form action="{{ url('/categorie-produit/'.$category) }}" method="get" class="mt-5 space-y-4">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" step="0.01" name="min_price" value="{{ $minPrice }}" class="rounded-md border border-zinc-300 px-2 py-2 text-sm">
                            <input type="number" step="0.01" name="max_price" value="{{ $maxPrice }}" class="rounded-md border border-zinc-300 px-2 py-2 text-sm">
                        </div>
                        <button type="submit" class="rounded-md bg-[#f04c3d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#e63946]">Filtrer</button>
                        <p class="text-sm text-zinc-600">
                            Prix : {{ number_format((float) $minPrice, 2, ',', ' ') }} — {{ number_format((float) $maxPrice, 2, ',', ' ') }} DH
                        </p>
                    </form>
                </section>
            </aside>

            <section>
                <nav class="text-sm text-zinc-500">
                    <a href="{{ route('client.home') }}" class="underline hover:text-zinc-700">Accueil</a>
                    <span>/</span>
                    <span>{{ $categoryLabel }}</span>
                </nav>
                <h1 class="mt-3 text-6xl font-light text-[#f04c3d]">{{ $categoryLabel }}</h1>
                <p class="mt-8 text-2xl text-zinc-700">Affichage de {{ $filtered->count() }} résultat(s)</p>

                <div class="mt-6 grid gap-7 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse ($filtered as $program)
                        @php
                            $img = $program->publicImageUrl() ?? '';
                        @endphp
                        <article class="max-w-[280px]">
                            <a href="{{ route('client.product.show', $program) }}" class="block aspect-square overflow-hidden bg-zinc-100">
                                @if ($img)
                                    <img src="{{ $img }}" alt="" class="h-full w-full object-cover" loading="lazy">
                                @endif
                            </a>
                            <h3 class="mt-3 text-4xl font-semibold text-zinc-900">{{ $program->title }}</h3>
                            <p class="mt-1 text-2xl text-zinc-500">{{ $categoryLabel }}</p>
                            <p class="mt-1 text-3xl font-semibold text-zinc-900">{{ number_format((float) ($program->price ?? 0), 2, ',', ' ') }} DH</p>
                            <button
                                type="button"
                                class="add-to-cart mt-4 inline-flex rounded bg-[#f04c3d] px-6 py-3 text-2xl font-semibold text-white hover:bg-[#e63946]"
                                data-slug="{{ $program->slug }}"
                                data-title="{{ $program->title }}"
                                data-price="{{ $program->price ?? 0 }}"
                                data-image="{{ $img }}"
                            >
                                Ajouter au panier
                            </button>
                        </article>
                    @empty
                        <p class="text-zinc-600">Aucun programme trouvé dans cette catégorie.</p>
                    @endforelse
                </div>
            </section>
        </div>
        </div>
    </div>
@endsection

