@extends('layouts.default')

@section('title')
    Questions List
    <a href="{{route('questions.create')}}" class="btn btn-outline-primary btn-xs">Create New Question</a>
@endsection


@section('content')
    <div class="card mb-3" >
        <div class="card-body">
            <h5 class="card-title">{{ $question->title }}</h5>
            <div class="text-muted mb-4">
                Asked: <strong> {{ $question->created_at->diffForHumans() }}_____</strong>
                By: <strong>{{ $question->user->name }}______</strong>
                # of Answers: <strong> {{$question->answers_count  }} </strong>
            </div>
            <p class="card-text">{{ $question->description  }}</p>
        </div>
    </div>
@endsection
