@extends('layouts.app')

@section('title', 'Mon compte — Athleticore')

@section('content')
    <div class="bg-white">
        {{-- Header "Mon compte" --}}
        <div class="relative">
            <img
                src="{{ asset('images/bg-mon-compte.png') }}"
                alt=""
                class="h-44 w-full object-cover"
                loading="lazy"
            >
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center">
                    <h1 class="text-3xl font-bold tracking-wide text-white">Mon compte</h1>
                    <div class="mx-auto mt-3 h-1 w-14 rounded-full bg-white/70"></div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            @auth
                @php
                    /** @var \App\Models\User $user */
                    $user = auth()->user();
                    $profileBmi = $user->bmi();
                    $profileBmiCategoryLabel = $user->bmiCategoryLabel();
                @endphp

                <div class="grid gap-8 md:grid-cols-2 md:gap-10">
                    <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold text-zinc-900">Modifier mon profil</h2>

                        @if (session('status'))
                            <div class="mt-4 rounded-lg bg-[#e63946]/10 px-4 py-3 text-sm text-[#b91c1c]" role="status">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form
                            method="post"
                            action="{{ route('client.profile.update') }}"
                            class="mt-6 space-y-5"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @method('PUT')

                            <div class="flex items-center gap-4">
                                <div class="h-16 w-16 overflow-hidden rounded-full border border-zinc-200 bg-zinc-50">
                                    @if ($user->photo)
                                        <img
                                            src="{{ asset('storage/'.$user->photo) }}"
                                            alt="Photo de profil"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-zinc-900/5 text-zinc-900 text-sm font-semibold">
                                            {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <label for="photo" class="block text-sm font-medium text-zinc-600">Photo de profil</label>
                                    <input
                                        id="photo"
                                        type="file"
                                        name="photo"
                                        accept="image/*"
                                        class="mt-1 block w-full text-sm text-zinc-600"
                                    >
                                    @error('photo')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="age" class="block text-sm font-medium text-zinc-600">Âge</label>
                                <input
                                    id="age"
                                    type="number"
                                    name="age"
                                    min="0"
                                    max="120"
                                    value="{{ old('age', $user->age) }}"
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                                @error('age')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-zinc-600">Poids (kg)</label>
                                    <input
                                        id="weight"
                                        type="number"
                                        name="weight"
                                        step="0.1"
                                        min="20"
                                        max="300"
                                        placeholder="ex. 70"
                                        value="{{ old('weight', $user->weight) }}"
                                        class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                    >
                                    @error('weight')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="height" class="block text-sm font-medium text-zinc-600">Taille (cm)</label>
                                    <input
                                        id="height"
                                        type="number"
                                        name="height"
                                        step="0.1"
                                        min="100"
                                        max="250"
                                        placeholder="ex. 175"
                                        value="{{ old('height', $user->height) }}"
                                        class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                    >
                                    @error('height')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-zinc-600">Ville</label>
                                <input
                                    id="city"
                                    type="text"
                                    name="city"
                                    maxlength="120"
                                    autocomplete="address-level2"
                                    placeholder="ex. Casablanca"
                                    value="{{ old('city', $user->city) }}"
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                                @error('city')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-[#a3ff12] py-3 text-sm font-semibold text-[#0a0b0d] transition hover:bg-[#b8ff4d]"
                            >
                                Enregistrer
                            </button>
                        </form>
                    </section>

                    <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold text-zinc-900">Informations</h2>

                        <div class="mt-6 space-y-4 text-sm text-zinc-700">
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-500">Nom</span>
                                <span class="font-semibold text-zinc-900">{{ $user->name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-500">E-mail</span>
                                <span class="font-semibold text-zinc-900">{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-500">Ville</span>
                                <span class="ml-4 min-w-0 flex-1 text-right font-semibold text-zinc-900">{{ $user->city ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-500">Âge</span>
                                <span class="font-semibold text-zinc-900">{{ $user->age ?? '—' }}</span>
                            </div>
                            <p class="text-sm leading-relaxed text-zinc-700">
                                <span class="text-zinc-500">Poids :</span>
                                @if ($user->weight !== null)
                                    <span class="font-semibold text-zinc-900">{{ number_format((float) $user->weight, 1, ',', ' ') }} kg</span>
                                @else
                                    <span class="font-semibold text-zinc-400">—</span>
                                @endif
                            </p>
                            <p class="text-sm leading-relaxed text-zinc-700">
                                <span class="text-zinc-500">Taille :</span>
                                @if ($user->height !== null)
                                    <span class="font-semibold text-zinc-900">{{ number_format((float) $user->height, 1, ',', ' ') }} cm</span>
                                @else
                                    <span class="font-semibold text-zinc-400">—</span>
                                @endif
                            </p>
                            @if ($profileBmi !== null && $profileBmiCategoryLabel)
                                <div class="rounded-xl border border-zinc-100 bg-zinc-50/80 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Indice de masse corporelle (IMC)</p>
                                    <p class="mt-2 text-sm leading-relaxed text-zinc-700">
                                        <span class="text-zinc-500">IMC :</span>
                                        <span class="font-bold text-zinc-900">{{ number_format($profileBmi, 1, ',', ' ') }}</span>
                                        <span class="text-zinc-500"> — </span>
                                        <span class="font-semibold text-zinc-800">{{ $profileBmiCategoryLabel }}</span>
                                    </p>
                                    <p class="mt-2 text-xs text-zinc-500">Calcul : poids (kg) ÷ (taille en m)²</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8 rounded-xl bg-zinc-50 p-4 text-xs text-zinc-500">
                            Les informations sont utilisées pour personnaliser votre espace et améliorer l’expérience.
                        </div>
                    </section>
                </div>
            @else
                <div class="grid gap-8 md:grid-cols-2 md:gap-10">
                    {{-- Login --}}
                    <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold text-zinc-900">Login</h2>

                        <form method="post" action="{{ route('login') }}" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label for="email" class="block text-sm font-medium text-zinc-600">E-mail</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-zinc-600">Mot de passe</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                            </div>

                            <label class="flex items-center gap-2 text-sm text-zinc-600">
                                <input type="checkbox" name="remember" value="1" class="rounded border-zinc-300">
                                Se souvenir de moi
                            </label>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-red-600 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                Log in
                            </button>
                        </form>
                    </section>

                    {{-- Register --}}
                    <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold text-zinc-900">Register</h2>

                        <form method="post" action="{{ route('register') }}" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium text-zinc-600">Nom</label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email_register" class="block text-sm font-medium text-zinc-600">E-mail</label>
                                <input
                                    id="email_register"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_register" class="block text-sm font-medium text-zinc-600">Mot de passe</label>
                                <input
                                    id="password_register"
                                    type="password"
                                    name="password"
                                    required
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-zinc-600">Confirmation</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="mt-1.5 w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none focus:border-[#a3ff12]/70"
                                >
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-[#a3ff12] py-3 text-sm font-semibold text-[#0a0b0d] transition hover:bg-[#b8ff4d]"
                            >
                                Register
                            </button>
                        </form>
                    </section>
                </div>
            @endauth
        </div>
    </div>
@endsection
