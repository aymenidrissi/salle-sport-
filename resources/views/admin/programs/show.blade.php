@extends('layouts.admin')

@section('title', $program->title.' — Admin')

@section('content')
    <h1 class="text-2xl font-bold">{{ $program->title }}</h1>
    @if ($program->description)
        <p class="mt-4 whitespace-pre-wrap text-zinc-700">{{ $program->description }}</p>
    @endif
@endsection
