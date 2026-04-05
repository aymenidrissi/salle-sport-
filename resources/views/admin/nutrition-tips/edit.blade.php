@extends('layouts.admin')

@section('title', 'Modifier un conseil — Admin')

@section('content')
    <div class="mx-auto max-w-3xl">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Modifier {{ $nutritionTip->title }}</h1>

        <form action="{{ route('admin.nutrition-tips.update', $nutritionTip) }}" method="POST" class="mt-6 space-y-5 rounded-[10px] border border-zinc-200 bg-white p-5 shadow-sm">
            @csrf
            @method('PATCH')

            <div>
                <label for="title" class="mb-1 block text-sm font-medium text-zinc-700">Titre *</label>
                <input id="title" name="title" type="text" value="{{ old('title', $nutritionTip->title) }}" required class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="mb-1 block text-sm font-medium text-zinc-700">Lien PDF (optionnel)</label>
                <input
                    id="image"
                    name="image"
                    type="url"
                    value="{{ old('image', $nutritionTip->image) }}"
                    placeholder="https://exemple.com/guide-nutrition.pdf"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                >
                @error('image')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-zinc-500">Collez un lien vers un PDF. Le client pourra l’ouvrir.</p>
                <a
                    id="pdfPreviewLink"
                    href="#"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-2 hidden inline-flex items-center gap-1 text-xs font-medium text-brand hover:underline"
                >
                    Ouvrir le PDF
                </a>
            </div>

            <div>
                <label for="content" class="mb-1 block text-sm font-medium text-zinc-700">Contenu *</label>
                <textarea id="content" name="content" rows="8" required class="w-full rounded-lg border border-zinc-300 px-3 py-2.5 text-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">{{ old('content', $nutritionTip->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand/90">
                    Mettre à jour
                </button>
                <a href="{{ route('admin.nutrition-tips.index') }}" class="text-sm text-zinc-600 hover:underline">Retour</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            (function () {
                var input = document.getElementById('image');
                var link = document.getElementById('pdfPreviewLink');
                if (!input || !link) return;

                function updatePreview() {
                    var value = String(input.value || '').trim();
                    if (!value) {
                        link.classList.add('hidden');
                        link.setAttribute('href', '#');
                        return;
                    }
                    link.classList.remove('hidden');
                    link.setAttribute('href', value);
                }

                input.addEventListener('input', updatePreview);
                updatePreview();
            })();
        </script>
    @endpush
@endsection
