@extends('layouts.admin')

@section('title', 'Modifier un programme — Admin')

@section('content')
    <div class="mx-auto max-w-3xl">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Modifier {{ $program->title }}</h1>

        <form action="{{ route('admin.programs.update', $program) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5 rounded-[10px] border border-zinc-200 bg-white p-5 shadow-sm">
            @csrf
            @method('PATCH')

            <div>
                <label for="title" class="mb-1 block text-sm font-medium text-zinc-700">Titre *</label>
                <input id="title" name="title" type="text" value="{{ old('title', $program->title) }}" required class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="mb-1 block text-sm font-medium text-zinc-700">Slug</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $program->slug) }}" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="mb-1 block text-sm font-medium text-zinc-700">Prix (DH)</label>
                <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $program->price) }}" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('price')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($program->image)
                <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-3">
                    <p class="mb-2 text-xs font-medium text-zinc-500">Aperçu actuel</p>
                    @php
                        $imgSrc = \Illuminate\Support\Str::startsWith((string) $program->image, ['http://', 'https://'])
                            ? $program->image
                            : asset('storage/'.$program->image);
                    @endphp
                    <img src="{{ $imgSrc }}" alt="" class="max-h-40 w-auto rounded-md object-contain" loading="lazy">
                </div>
            @endif

            <div>
                <label for="image_file" class="mb-1 block text-sm font-medium text-zinc-700">Nouvelle image (fichier)</label>
                <input id="image_file" name="image_file" type="file" accept="image/*" class="block w-full text-sm text-zinc-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-muted file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand">
                <p class="mt-1 text-xs text-zinc-500">
                    @if ($program->slug === 'programme-yoga')
                        Laissez vide pour conserver l’image actuelle.
                    @else
                        Laissez vide pour conserver l’image actuelle (sauf si vous remplissez une URL ci‑dessous).
                    @endif
                </p>
                @error('image_file')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($program->slug !== 'programme-yoga')
                @php
                    $imageUrlDefault = \Illuminate\Support\Str::startsWith((string) $program->image, ['http://', 'https://'])
                        ? $program->image
                        : '';
                @endphp
                <div>
                    <label for="image_url" class="mb-1 block text-sm font-medium text-zinc-700">Image (URL externe)</label>
                    <input id="image_url" name="image_url" type="url" value="{{ old('image_url', $imageUrlDefault) }}" placeholder="https://exemple.com/image-programme.jpg" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                    <p class="mt-1 text-xs text-zinc-500">Utilisé si aucun nouveau fichier n’est envoyé. L’URL remplace l’image stockée si renseignée.</p>
                    @error('image_url')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-zinc-700">Description</label>
                <textarea id="description" name="description" rows="6" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">{{ old('description', $program->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($program->slug === 'programme-yoga' || filled($program->video_url))
                <div>
                    <label for="video_url" class="mb-1 block text-sm font-medium text-zinc-700">URL de la vidéo</label>
                    <input id="video_url" name="video_url" type="url" value="{{ old('video_url', $program->video_url) }}" placeholder="https://www.youtube.com/watch?v=… ou lien Vimeo" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                    <p class="mt-1 text-xs text-zinc-500">Lien vers une vidéo (YouTube, Vimeo, etc.). Affiché sur la page programme côté client.</p>
                    @error('video_url')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <label class="inline-flex items-center gap-2 text-sm text-zinc-700">
                <input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', $program->is_visible)) class="size-4 rounded border-zinc-300 text-brand focus:ring-brand/30">
                Afficher la carte sur la page client
            </label>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand/90">
                    Mettre à jour
                </button>
                <a href="{{ route('admin.programs.index') }}" class="text-sm text-zinc-600 hover:underline">Retour</a>
            </div>
        </form>
    </div>
@endsection
