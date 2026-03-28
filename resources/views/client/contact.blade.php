@extends('layouts.app')

@section('title', 'Nous contacter — Athleticore')

@section('content')
    {{-- Bannière héros (image pro fournie + léger voile pour la lisibilité) --}}
    <section class="relative min-h-[38vh] w-full overflow-hidden sm:min-h-[44vh] md:min-h-[52vh]">
        <div
            class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/bg-contact.png') }}');"
            role="img"
            aria-label=""
        ></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0b0d]/90 via-[#0a0b0d]/55 to-[#0a0b0d]/40"></div>
        <div class="relative flex min-h-[38vh] items-center justify-center px-4 sm:min-h-[44vh] md:min-h-[52vh]">
            <h1 class="text-center text-4xl font-black tracking-tight text-white drop-shadow-sm sm:text-5xl md:text-6xl">
                Nous contacter
            </h1>
        </div>
    </section>

    {{-- Zone informations — fond clair, style page pro --}}
    <div class="bg-white text-zinc-900">
        <div class="mx-auto max-w-3xl px-4 py-14 sm:py-16 md:py-20">
            <h2 class="text-2xl font-extrabold leading-tight tracking-tight text-zinc-900 sm:text-3xl md:text-[1.75rem]">
                Des questions, des commentaires&nbsp;?
            </h2>
            <p class="mt-2 text-2xl font-extrabold leading-tight tracking-tight text-zinc-900 sm:text-3xl md:text-[1.75rem]">
                Contactez-nous, on vous répond&nbsp;!
            </p>

            <div class="mt-10 flex items-start gap-4">
                <span class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#e63946]/10 text-[#e63946]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-zinc-500">E-mail</p>
                    <a href="mailto:contact@athleticore.ma" class="mt-1 inline-block text-lg font-semibold text-zinc-900 underline decoration-zinc-300 underline-offset-4 transition hover:text-[#e63946] hover:decoration-[#e63946]/40">
                        contact@athleticore.ma
                    </a>
                </div>
            </div>

            <div class="mt-12 border-t border-zinc-200 pt-12">
                <h3 class="text-lg font-extrabold text-zinc-900">Suivez-nous</h3>
                <p class="mt-1 text-sm text-zinc-600">Actualités, conseils et coulisses sur les réseaux.</p>
                <div class="mt-6 flex flex-wrap gap-4">
                    <a
                        href="https://www.facebook.com/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-[#e63946] text-white shadow-md transition hover:bg-[#d62f3c] hover:shadow-lg"
                        aria-label="Facebook"
                    >
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a
                        href="https://www.instagram.com/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-[#e63946] text-white shadow-md transition hover:bg-[#d62f3c] hover:shadow-lg"
                        aria-label="Instagram"
                    >
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Bloc optionnel : message court pour renforcer le côté pro --}}
            <div class="mt-14 rounded-2xl border border-zinc-200 bg-zinc-50 px-6 py-5 text-sm leading-relaxed text-zinc-600">
                Pour une réponse rapide, indiquez dans votre message le programme qui vous intéresse ou le sujet de votre demande.
            </div>
        </div>
    </div>
@endsection
