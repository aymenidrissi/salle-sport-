@extends('layouts.admin')

@section('title', $video->title.' — Admin')

@section('content')
    <h1 class="text-2xl font-bold">{{ $video->title }}</h1>
    <p class="mt-2 text-sm text-zinc-600">{{ $video->url }}</p>
@endsection
