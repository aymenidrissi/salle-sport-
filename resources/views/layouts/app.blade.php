<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Athleticore'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-[#0a0b0d] font-sans text-zinc-100 antialiased">
    <header class="sticky top-0 z-50 border-b border-white/5 bg-[#0a0b0d]/80 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 lg:px-6">
            <a href="{{ route('client.home') }}" class="flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#a3ff12]/15 text-[#a3ff12]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M6 7h2v10H6V7zm8 0h2v10h-2V7z" />
                        <path d="M8 12h8M4 12H2M22 12h-2" stroke-linecap="round" />
                    </svg>
                </span>
                <span class="text-lg font-bold tracking-tight">
                    Athletic<span class="text-[#a3ff12]">ore</span>
                </span>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-medium text-zinc-300 lg:flex lg:gap-8">
                <a href="{{ route('client.home') }}" class="transition hover:text-white">Accueil</a>
                <a href="{{ route('client.dashboard') }}" class="transition hover:text-white">Tableau de bord</a>
                <a href="{{ route('client.programs.index') }}" class="transition hover:text-white">Programmes</a>
                <a href="{{ route('client.profile') }}" class="transition hover:text-white">Profil</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <button type="button" class="rounded-lg p-2 text-zinc-400 transition hover:bg-white/5 hover:text-white" aria-label="Rechercher">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <button type="button" class="relative rounded-lg p-2 text-zinc-400 transition hover:bg-white/5 hover:text-white" aria-label="Notifications">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-[#0a0b0d]"></span>
                </button>
                @auth
                    <div class="flex items-center gap-2">
                        <a href="{{ route('client.profile') }}" class="h-9 w-9 overflow-hidden rounded-full ring-2 ring-white/10 transition hover:ring-[#a3ff12]/50" title="Profil">
                            <span class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-600 to-zinc-800 text-xs font-semibold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-zinc-200 transition hover:bg-white/5 hover:text-white sm:block">
                                Déconnexion
                            </button>
                            <button type="submit" class="sm:hidden rounded-xl p-2 text-zinc-200 transition hover:bg-white/5 hover:text-white" aria-label="Déconnexion" title="Déconnexion">
                                <span class="text-lg leading-none">↩</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-zinc-800 text-xs font-semibold text-zinc-400 ring-2 ring-white/10 transition hover:text-[#a3ff12] hover:ring-[#a3ff12]/40" title="Connexion">?</a>
                @endauth
            </div>
        </div>
        <nav class="flex justify-center gap-4 overflow-x-auto border-t border-white/5 px-4 py-2.5 text-xs font-medium text-zinc-400 lg:hidden">
            <a href="{{ route('client.home') }}" class="shrink-0 hover:text-white">Accueil</a>
            <a href="{{ route('client.dashboard') }}" class="shrink-0 hover:text-white">Tableau de bord</a>
            <a href="{{ route('client.programs.index') }}" class="shrink-0 hover:text-white">Programmes</a>
            <a href="{{ route('client.profile') }}" class="shrink-0 hover:text-white">Profil</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-white/5 bg-[#0a0b0d]/80 px-4 py-8 text-sm text-zinc-400 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <p>© {{ date('Y') }} Athleticore. Tous droits réservés.</p>
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                <a href="{{ route('client.home') }}" class="hover:text-white">Accueil</a>
                <a href="{{ route('client.programs.index') }}" class="hover:text-[#a3ff12]">Programmes</a>
                <a href="{{ route('client.contact') }}" class="hover:text-white">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
