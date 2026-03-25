@extends('layouts.admin')

@section('title', $nutritionTip->title.' — Admin')

@section('content')
    <h1 class="text-2xl font-bold">{{ $nutritionTip->title }}</h1>
    <div class="mt-4 whitespace-pre-wrap text-zinc-700">{{ $nutritionTip->content }}</div>
@endsection
