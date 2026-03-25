@extends('layouts.admin')

@section('title', 'Conseils nutrition — Admin')

@section('content')
    <h1 class="text-2xl font-bold">Conseils nutrition</h1>
    <ul class="mt-4 space-y-2">
        @foreach ($tips as $tip)
            <li>{{ $tip->title }}</li>
        @endforeach
    </ul>
    <div class="mt-6">{{ $tips->links() }}</div>
@endsection
