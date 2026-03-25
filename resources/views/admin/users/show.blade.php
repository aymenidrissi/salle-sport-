@extends('layouts.admin')

@section('title', $user->name.' — Admin')

@section('content')
    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
    <p class="mt-2 text-zinc-600">{{ $user->email }}</p>
@endsection
