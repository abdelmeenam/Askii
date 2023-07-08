@extends('layouts.default')
@section('title')
    Questions
@endsection

@section('content')

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    <!-- Question Details -->
    <div class="card mb-3" >
        <div class="card-body">
            <h5 class="card-title">{{ $question->title }}</h5>
            <div class="text-muted mb-4">
                Asked: <strong> {{ $question->created_at->diffForHumans() }}_____</strong>
                By: <strong>{{ $question->user->name }}</strong>
            </div>
            <p class="card-text">{{ $question->description  }}</p>
        </div>
    </div>

    <!-- Answers -->
    <section>
        <h3> {{$questionsCount}} Answers</h3>
        @forelse($answers as $answer)
            <div class="card-body">
                <p class="card-text">{{ $answer->description }}</p>
                <div class="text-muted mb-4">
                    Asked: <strong> {{ $answer->created_at->diffForHumans() }}_____</strong>
                    By: <strong>{{ $answer->user->name }}</strong>
                </div>

                @if(Auth::id() == $answer->user_id)
                <div>

                    <form class="d-inline" action="{{route('answers.destroy' ,  $answer->id)}}" method="post" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                    <a  href="{{route('answers.edit' ,  $answer->id)}}" class="btn btn-outline-primary btn-sm ">Edit</a>
                </div>
                @endif
            </div>
            <hr>
        @empty
            <div class="card-body">
                <p class="card-text">No Answers yet.</p>
            </div>
        @endforelse
    </section>

    <!-- Create Answer -->
    @auth()
        <section>
            <h3>Answer this question</h3>
            <form action="{{ route('answers.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"  id="description"  name="description"  rows="3"  placeholder="Enter description">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <button type="submit" class="btn btn-outline-primary mt-2">Submit</button>
            </form>
        </section>
    @endauth

    @guest
        <div class="alert alert-info">
            Please <a href="{{ route('login') }}">login</a> to answer this question.
        </div>
    @endguest
@endsection
