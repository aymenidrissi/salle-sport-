@extends('layouts.app')

@section('title', 'À propos — Athleticore')

@section('content')
    <div class="bg-white text-zinc-900">
        {{-- Hero : même visuel que la référence (image + titre) --}}
        <section class="relative overflow-hidden">
            <div
                class="h-64 w-full bg-cover bg-center sm:h-72 lg:h-80"
                style="background-image: url('{{ asset('images/about-team-bg.png') }}');"
                role="img"
                aria-hidden="true"
            ></div>
            <div class="absolute inset-0 bg-black/45"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center">
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Entraînements sportifs à distance
                    </h1>
                    <div class="mx-auto mt-3 h-px w-16 bg-white/80"></div>
                </div>
            </div>
        </section>

        {{-- Contenu principal --}}
        <section class="mx-auto max-w-4xl px-4 py-14 sm:py-16">
            <div class="mx-auto mb-8 h-px w-10 bg-zinc-900/70"></div>
            <p class="text-center text-xl font-semibold text-zinc-800">Il était une fois…</p>

            <h2 class="mt-10 text-3xl font-extrabold leading-tight text-zinc-900 sm:text-4xl">
                Athleticore
                <br>
                <span class="text-2xl font-bold sm:text-3xl">La naissance des programmes de sport</span>
            </h2>

            <div class="mt-8 space-y-5 text-sm leading-relaxed text-zinc-700 sm:text-base">
                <p>
                    Athleticore est né d’une idée simple : rendre l’entraînement accessible, structuré et sérieux,
                    comme en salle — mais à distance. Notre équipe s’appuie sur une expérience terrain et une approche
                    pédagogique pour vous guider pas à pas.
                </p>
                <p>
                    Nos contenus s’inspirent des standards d’un centre comme
                    <span class="font-semibold text-[#e63946]">Complexe Fitness</span>
                    : exigence, clarté des séances, et suivi des progrès sans promesses irréalistes.
                </p>
                <p>
                    Chaque programme relie musculation, récupération et repères nutritionnels pour que vous sachiez
                    <em>pourquoi</em> vous faites chaque exercice, et comment avancer en sécurité.
                </p>
            </div>

            <h2 class="mt-14 text-2xl font-extrabold text-zinc-900 sm:text-3xl">
                Suivre un programme sportif en ligne
            </h2>

            <div class="mt-6 space-y-5 text-sm leading-relaxed text-zinc-700 sm:text-base">
                <p>
                    Sur Athleticore, vous accédez à des séances détaillées, des vidéos et un parcours cohérent selon votre niveau.
                    L’objectif est de rendre
                    <span class="font-semibold text-[#e63946]">l’entraînement de sport en ligne</span>
                    aussi lisible qu’en présentiel : consignes, alternatives, et progression mesurable.
                </p>
                <p>
                    Vous progressez à votre rythme, avec des repères concrets (charge, volume, régularité) pour ancrer des habitudes durables.
                </p>
                <p class="text-zinc-800">
                    Merci de votre confiance — on avance ensemble 💛
                </p>
            </div>
        </section>

        {{-- Bannière Suivez-nous (image rouge / salle + encadré central) --}}
        <section class="relative overflow-hidden">
            <div
                class="min-h-[220px] w-full bg-cover bg-center sm:min-h-[260px] lg:min-h-[300px]"
                style="background-image: url('{{ asset('images/about-suite.png') }}');"
                role="img"
                aria-hidden="true"
            ></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/55 via-black/35 to-black/55"></div>
            <div class="absolute inset-0 bg-[#e63946]/20"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4 py-10">
                <div class="rounded-2xl bg-zinc-50/95 px-10 py-8 text-center shadow-xl ring-1 ring-black/5 backdrop-blur-sm">
                    <div class="mx-auto mb-4 h-px w-12 bg-zinc-900/80"></div>
                    <p class="text-2xl font-extrabold tracking-tight text-zinc-900 sm:text-3xl">Suivez-nous</p>
                    <div class="mt-5 flex justify-center gap-4">
                        <a
                            href="https://www.facebook.com/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-zinc-900 text-white transition hover:bg-zinc-700"
                            aria-label="Facebook"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a
                            href="https://www.instagram.com/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-zinc-900 text-white transition hover:bg-zinc-700"
                            aria-label="Instagram"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Grille coachs (image fournie) --}}
        <section class="mx-auto max-w-6xl px-4 py-14 sm:py-16">
            <h2 class="text-center text-2xl font-black uppercase tracking-tight text-zinc-900 sm:text-3xl md:text-4xl">
                Les coachs sportifs professionnels
            </h2>
            <div class="mt-8 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
                <img
                    src="{{ asset('images/about-coachs.png') }}"
                    alt="Les coachs sportifs professionnels"
                    class="w-full object-cover"
                    loading="lazy"
                    width="1200"
                    height="600"
                >
            </div>
        </section>
    </div>
@endsection
