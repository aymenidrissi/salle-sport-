@extends('layouts.admin')

@section('title', 'Créer un programme — Admin')

@section('content')
    <div class="mx-auto max-w-3xl">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Créer un programme</h1>

        <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5 rounded-[10px] border border-zinc-200 bg-white p-5 shadow-sm">
            @csrf

            <div>
                <label for="title" class="mb-1 block text-sm font-medium text-zinc-700">Titre *</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" required class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="mb-1 block text-sm font-medium text-zinc-700">Slug (optionnel)</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug') }}" placeholder="ex: programme-debutant-homme" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="mb-1 block text-sm font-medium text-zinc-700">Prix (DH)</label>
                <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price') }}" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('price')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image_file" class="mb-1 block text-sm font-medium text-zinc-700">Image du programme (fichier)</label>
                <input id="image_file" name="image_file" type="file" accept="image/*" class="block w-full text-sm text-zinc-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-muted file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand">
                <p class="mt-1 text-xs text-zinc-500">JPG, PNG, WebP… (max ~4 Mo). Prioritaire sur l’URL si les deux sont renseignés.</p>
                @error('image_file')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image_url" class="mb-1 block text-sm font-medium text-zinc-700">Image (URL externe)</label>
                <input id="image_url" name="image_url" type="url" value="{{ old('image_url') }}" placeholder="https://exemple.com/image-programme.jpg" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                <p class="mt-1 text-xs text-zinc-500">Utilisé si aucun fichier n’est envoyé. Lien direct vers une image (HTTPS recommandé).</p>
                @error('image_url')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-zinc-700">Description</label>
                <textarea id="description" name="description" rows="6" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-zinc-700">
                <input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', '1')) class="size-4 rounded border-zinc-300 text-brand focus:ring-brand/30">
                Afficher la carte sur la page client
            </label>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand/90">
                    Enregistrer
                </button>
                <a href="{{ route('admin.programs.index') }}" class="text-sm text-zinc-600 hover:underline">Annuler</a>
            </div>
        </form>
    </div>
@endsection
