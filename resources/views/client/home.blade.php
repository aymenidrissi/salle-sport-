@extends('layouts.app')

@section('title', 'Accueil — Athleticore')

@section('content')
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0a0b0d] via-[#0a0b0d]/92 to-[#0a0b0d]/75 lg:via-[#0a0b0d]/88 lg:to-transparent"></div>
            <div class="absolute inset-0 bg-[#0a0b0d]/40 lg:bg-transparent"></div>
            <img
                src="{{ asset('images/hero-athlete.png') }}"
                alt=""
                class="h-[420px] w-full object-cover object-top opacity-90 sm:h-[480px] lg:absolute lg:right-0 lg:top-0 lg:h-full lg:w-[55%] lg:max-w-none lg:object-right"
                width="1200"
                height="800"
            >
        </div>

        <div class="relative z-10 mx-auto grid max-w-7xl gap-10 px-4 pb-16 pt-10 lg:grid-cols-2 lg:items-center lg:gap-8 lg:px-6 lg:pb-24 lg:pt-16">
            <div class="max-w-xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-[#a3ff12]/35 bg-[#a3ff12]/5 px-3 py-1.5 text-xs font-medium text-[#a3ff12]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#a3ff12]"></span>
                    Plateforme fitness intelligente
                </div>

                <h1 class="mt-6 text-4xl font-extrabold leading-[1.1] tracking-tight text-white sm:text-5xl lg:text-[3.25rem]">
                    Forgez votre
                    <span class="text-[#a3ff12]">physique ultime</span>
                </h1>

                <p class="mt-5 text-base leading-relaxed text-zinc-400 sm:text-lg">
                    Rejoignez une communauté motivée et progressez avec des programmes d’entraînement pensés pour vous,
                    le suivi de vos séances et des conseils nutrition adaptés.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a
                        href="{{ route('client.dashboard') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#a3ff12] px-6 py-3.5 text-center text-sm font-semibold text-[#0a0b0d] shadow-[0_0_24px_-4px_rgba(163,255,18,0.45)] transition hover:bg-[#b8ff4d] focus:outline-none focus:ring-2 focus:ring-[#a3ff12] focus:ring-offset-2 focus:ring-offset-[#0a0b0d]"
                    >
                        Commencer l’entraînement
                    </a>
                    <a
                        href="{{ route('client.programs.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-zinc-600 bg-zinc-900/50 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:border-zinc-500 hover:bg-zinc-800/80"
                    >
                        Découvrir les programmes
                    </a>
                </div>

                <p class="mt-8 text-sm text-zinc-500">
                    Déjà un compte ?
                    <a href="{{ route('login') }}" class="font-semibold text-[#a3ff12] underline-offset-4 hover:underline">Connectez-vous</a>
                </p>
            </div>

            <div class="relative flex justify-center lg:justify-end">
                <div class="w-full max-w-md rounded-2xl border border-white/10 bg-zinc-900/40 p-5 shadow-2xl backdrop-blur-xl sm:p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-white">Activité récente</h2>
                        <button type="button" class="rounded-lg p-1 text-zinc-500 hover:bg-white/5 hover:text-white" aria-label="Menu">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        </button>
                    </div>

                    <div class="relative mt-5 h-40 w-full">
                        <svg class="h-full w-full" viewBox="0 0 400 140" preserveAspectRatio="none" aria-hidden="true">
                            <defs>
                                <linearGradient id="chartFill" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#a3ff12" stop-opacity="0.35" />
                                    <stop offset="100%" stop-color="#a3ff12" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <path
                                d="M0,110 L40,95 L80,100 L120,70 L160,75 L200,45 L240,55 L280,35 L320,40 L360,20 L400,25 L400,140 L0,140 Z"
                                fill="url(#chartFill)"
                            />
                            <path
                                d="M0,110 L40,95 L80,100 L120,70 L160,75 L200,45 L240,55 L280,35 L320,40 L360,20 L400,25"
                                fill="none"
                                stroke="#a3ff12"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4 border-t border-white/10 pt-4">
                        <div>
                            <p class="text-xs text-zinc-500">Calories brûlées</p>
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="text-2xl font-bold tabular-nums text-white">2 450</span>
                                <span class="rounded-md bg-[#a3ff12]/15 px-1.5 py-0.5 text-xs font-semibold text-[#a3ff12]">+12 %</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-zinc-500">Temps actif</p>
                            <p class="mt-1 text-2xl font-bold tabular-nums text-white">4h 20m</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
