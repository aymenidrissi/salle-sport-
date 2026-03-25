<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-[#0a0b0d] px-4 font-sans text-zinc-100 antialiased">
    <div class="w-full max-w-sm rounded-2xl border border-white/10 bg-zinc-900/50 p-8 shadow-2xl backdrop-blur-xl">
        <a href="{{ route('client.home') }}" class="text-sm text-zinc-500 hover:text-[#a3ff12]">← Retour</a>
        <h1 class="mt-4 text-2xl font-bold text-white">Connexion</h1>
        <form method="post" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-400">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1.5 w-full rounded-xl border border-white/10 bg-[#0a0b0d] px-4 py-3 text-sm text-white placeholder-zinc-600 outline-none ring-[#a3ff12]/30 transition focus:border-[#a3ff12]/50 focus:ring-2">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-zinc-400">Mot de passe</label>
                <input id="password" type="password" name="password" required
                    class="mt-1.5 w-full rounded-xl border border-white/10 bg-[#0a0b0d] px-4 py-3 text-sm text-white outline-none focus:border-[#a3ff12]/50 focus:ring-2 focus:ring-[#a3ff12]/30">
            </div>
            <label class="flex items-center gap-2 text-sm text-zinc-400">
                <input type="checkbox" name="remember" value="1" class="rounded border-zinc-600 bg-[#0a0b0d] text-[#a3ff12] focus:ring-[#a3ff12]">
                Se souvenir de moi
            </label>
            <button type="submit" class="w-full rounded-xl bg-[#a3ff12] py-3 text-sm font-semibold text-[#0a0b0d] transition hover:bg-[#b8ff4d]">
                Se connecter
            </button>
        </form>
        <p class="mt-6 text-center text-sm text-zinc-500">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-semibold text-[#a3ff12] hover:underline">Inscription</a>
        </p>
    </div>
</body>
</html>
