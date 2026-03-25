@extends('layouts.admin')

@section('title', 'Vidéos — Admin')

@section('content')
    <h1 class="text-2xl font-bold">Vidéos</h1>
    <ul class="mt-4 space-y-2">
        @foreach ($videos as $video)
            <li>{{ $video->title }}</li>
        @endforeach
    </ul>
    <div class="mt-6">{{ $videos->links() }}</div>
@endsection
