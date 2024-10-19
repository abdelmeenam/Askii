@extends('layouts.default')
@section('title')
    Question
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
                <div>
                    <span class="badge bg-dark">
                        {{ __('Views') }} : {{ $viewsCount }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Answers -->
    {{-- <section>
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
                    <strong class="me-3">{{ $answer->created_at->diffForHumans() }}</strong>
                    <i class="fas fa-user me-1"></i>{{ __('By') }}:
                    <strong class="me-3">{{ $answer->user->name ?? __('Unknown') }}</strong>


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
    --}}



    <!-- Answers -->
    <section class="answers-section">
        <h4>{{ $questionsCount }} Answers</h4>
        @forelse($answers as $answer)
            <div class="card mb-3">
                <div class="card-body">
                    @if ($answer->best_answer)
                        <span class="badge bg-success">Best Answer</span>
                    @endif
                    <p class="card-text">{{ $answer->description }}</p>
                    <div class="text-muted mb-3">
                        <i class="fas fa-clock me-1"></i>{{ __('Answered') }}:
                        <strong class="me-3">{{ $answer->created_at->diffForHumans() }}</strong>
                        <i class="fas fa-user me-1"></i>{{ __('By') }}:
                        <strong class="me-3">{{ $answer->user->name ?? __('Unknown') }}</strong>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        @auth()
                            @if (!$answer->best_answer && Auth::id() == $question->user_id)
                                <form action="{{ route('answers.best', $answer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Vote as Best Answer</button>
                                </form>
                            @endif
                        @endauth

                        @if (Auth::id() == $answer->user_id)
                            <div>
                                <form action="{{ route('answers.destroy', $answer->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                                <a href="{{ route('answers.edit', $answer->id) }}"
                                    class="btn btn-outline-primary btn-sm">Edit</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text text-center">No Answers yet.</p>
                </div>
            </div>
        @endforelse
    </section>


    <!-- Create Answer -->
    @auth()
        <section>
            <h4>Add Answer</h4>
            <form action="{{ route('answers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" placeholder="answer.....">{{ old('description') }}</textarea>
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
            Please <a href="{{ route('login') }}">login</a> to answer this question or
            <a href="{{ route('register') }}">Create account</a>.
        </div>
    @endguest
@endsection
