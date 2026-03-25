@extends('layouts.admin')

@section('title', 'Modifier une vidéo — Admin')

@section('content')
    <h1 class="text-2xl font-bold">Modifier {{ $video->title }}</h1>
    <p class="mt-2 text-zinc-600">Formulaire à compléter.</p>
@endsection
