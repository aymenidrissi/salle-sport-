@extends('layouts.admin')

@section('title', 'Programmes — Admin')

@section('content')
    <h1 class="text-2xl font-bold">Programmes</h1>
    <ul class="mt-4 space-y-2">
        @foreach ($programs as $program)
            <li>{{ $program->title }}</li>
        @endforeach
    </ul>
    <div class="mt-6">{{ $programs->links() }}</div>
@endsection
