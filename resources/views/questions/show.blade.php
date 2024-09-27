@extends('layouts.default')
@section('title')
    Questions
@endsection

@section('content')
    <x-flash-message />


    <!-- Question Details -->
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $question->title }}</h5>

            <p class="card-text">{{ $question->description }}</p>
            <div class="d-flex justify-content-between">
                <div>
                    @foreach ($question->tags as $tag)
                        <span class="badge bg-info"># {{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="d-flex ">
                    <span class="badge bg-dark">
                        {{ __('Views') }} : {{ $question->views }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Answers -->
    <section>
        <h3> {{ $questionsCount }} Answers</h3>
        @forelse($answers as $answer)
            <div class="card-body">
                @if ($answer->best_answer == true)
                    <span class="badge bg-success">Best Answer</span>
                    </span>
                @endif
                <p class="card-text">{{ $answer->description }}</p>
                <div class="text-muted mb-4">

                    <i class="fas fa-clock me-1"></i>{{ __('Answered') }}:
                    <strong>{{ $answer->created_at->diffForHumans() }}</strong> &bull;
                    <i class="fas fa-user me-1"></i>{{ __('By') }}:
                    <strong>{{ $answer->user->name ?? __('Unknown') }}</strong> &bull;
                </div>

                <div class="d-flex justify-content-between">
                    <div> @auth()
                            @if ($answer->best_answer == false && Auth::id() == $question->user_id)
                                <form action="{{ route('answers.best', $answer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success  btn-sm mb-1">Vote as best answer</button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    @if (Auth::id() == $answer->user_id)
                        <div>
                            <form class="d-inline" action="{{ route('answers.destroy', $answer->id) }}" method="post"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                            <a href="{{ route('answers.edit', $answer->id) }}"
                                class="btn btn-outline-primary btn-sm  ">Edit</a>
                        </div>
                    @endif
                </div>

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
            <form action="{{ route('answers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
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
