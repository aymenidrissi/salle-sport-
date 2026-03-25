@extends('layouts.admin')

@section('title', 'Utilisateurs — Admin')

@section('content')
    <h1 class="text-2xl font-bold">Utilisateurs</h1>
    <ul class="mt-4 space-y-2">
        @foreach ($users as $user)
            <li>{{ $user->name }} — {{ $user->email }}</li>
        @endforeach
    </ul>
    <div class="mt-6">{{ $users->links() }}</div>
@endsection
