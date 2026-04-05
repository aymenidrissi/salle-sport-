@extends('layouts.admin')

@section('title', 'Modifier une vidéo — Admin')

@section('content')
    <div class="mx-auto max-w-3xl">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Modifier {{ $video->title }}</h1>

        <form action="{{ route('admin.videos.update', $video) }}" method="POST" class="mt-6 space-y-5 rounded-[10px] border border-zinc-200 bg-white p-5 shadow-sm">
            @csrf
            @method('PATCH')

            <div>
                <label for="title" class="mb-1 block text-sm font-medium text-zinc-700">Titre *</label>
                <input id="title" name="title" type="text" value="{{ old('title', $video->title) }}" required class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="program_id" class="mb-1 block text-sm font-medium text-zinc-700">Programme (optionnel)</label>
                <select id="program_id" name="program_id" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                    <option value="">Aucun</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" @selected(old('program_id', $video->program_id) == $program->id)>{{ $program->title }}</option>
                    @endforeach
                </select>
                @error('program_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="url" class="mb-1 block text-sm font-medium text-zinc-700">URL vidéo *</label>
                <input id="url" name="url" type="url" value="{{ old('url', $video->url) }}" required class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('url')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-zinc-700">Description</label>
                <textarea id="description" name="description" rows="5" class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">{{ old('description', $video->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand/90">
                    Mettre à jour
                </button>
                <a href="{{ route('admin.videos.index') }}" class="text-sm text-zinc-600 hover:underline">Retour</a>
            </div>
        </form>
    </div>
@endsection
