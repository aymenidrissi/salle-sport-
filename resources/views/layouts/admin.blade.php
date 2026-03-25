<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin — '.config('app.name', 'Athleticore'))</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-zinc-100 text-zinc-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="w-56 shrink-0 border-r border-zinc-200 bg-white p-4">
            <p class="mb-4 font-semibold">Admin</p>
            <nav class="flex flex-col gap-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="hover:underline">Tableau de bord</a>
                <a href="{{ route('admin.statistics') }}" class="hover:underline">Statistiques</a>
                <a href="{{ route('admin.users.index') }}" class="hover:underline">Utilisateurs</a>
                <a href="{{ route('admin.programs.index') }}" class="hover:underline">Programmes</a>
                <a href="{{ route('admin.videos.index') }}" class="hover:underline">Vidéos</a>
                <a href="{{ route('admin.nutrition-tips.index') }}" class="hover:underline">Conseils nutrition</a>
            </nav>
        </aside>
        <div class="flex-1 flex flex-col p-6">
            @yield('content')

            <footer class="mt-auto border-t border-zinc-200/50 pt-4 text-xs text-zinc-600">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p>© {{ date('Y') }} Athleticore. Tous droits réservés.</p>
                    <a href="{{ route('client.home') }}" class="hover:underline">Retour au site</a>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
