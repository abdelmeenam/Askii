@extends('layouts.default')



@section('title')
    <div class="d-flex justify-content-between align-items-center">
        <h2>{{ __('Questions List') }} <i class="fa-solid fa-person-circle-question me-2"></i></h2>
        <a href="{{ route('questions.create') }}" class="btn btn-success">+ {{ __('Ask') }}</a>
    </div>
@endsection


@section('content')
    {{-- @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif --}}
    {{-- <aside class="col-md-3 p-2 bg-light">
        <h2>Tags</h2>
        <div class="row">
            <x-tags>
            </x-tags>
        </div>
    </aside> --}}
    <div class="col-md">
        @forelse ($questions as $question)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('questions.show', $question->id) }}" class="text-decoration-none text-dark">
                            <i class=""></i>{{ $question->title }}
                        </a>
                    </h5>
                    <div class="text-muted mb-3">
                        <small>
                            <i class="fas fa-clock me-1"></i>{{ __('Asked') }}:
                            <strong class="me-3">{{ $question->created_at->diffForHumans() }}</strong>
                            <i class="fas fa-user me-1"></i>{{ __('By') }}:
                            <strong class="me-3">{{ $question->user->name ?? __('Unknown') }}</strong>
                            <i class="fas fa-comment-dots me-1"></i>{{ __('Answers') }}:
                            <strong class="me-3">{{ $question->answers_count }}</strong>
                        </small>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            @foreach ($question->tags as $tag)
                                <span class="badge bg-primary me-1"># {{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <div>
                            <span class="badge bg-dark">
                                <i class="fas fa-eye me-1"></i>{{ __('Views') }}: {{ $question->views_count }}
                            </span>
                        </div>
                    </div>
                </div>

                @can('update', $question)
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{--                        <a href="{{route('questions.show' , $question->id) }}" class="btn btn-outline-primary btn-sm">View</a> --}}
                                <a href="{{ route('questions.edit', $question->id) }}"
                                    class="btn btn-outline-info btn-sm">Edit</a>
                            </div>
                            <div>
                                <form id="deleteQuestionForm" action="{{ route('questions.destroy', $question->id) }}"
                                    method="post" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan

            </div>


        @empty
            <!-- Display this if the collection is empty -->
            <div class="text-center ">
                <h1 class="display-4 font-weight-bold">No Questions Found</h1>
                <p class="lead">It looks like there are no questions available right now.</p>
            </div>
        @endforelse

        <div class="container d-flex justify-content-center align-items-center">
            {{ $questions->withQueryString()->links() }}
        </div>

    </div>
    <script>
        /**
                                                                                                                                        setTimeout(function() {
                                                                                                                                            // document.querySelector('.alert').remove();
                                                                                                                                            //document.querySelector('.alert').style.display = 'none';
                                                                                                                                            document.querySelector('.alert') ? document.querySelector('.alert').style.display = 'none' : '';
                                                                                                                                        }, 4000);
                                                                                                                                **/

        document.addEventListener('DOMContentLoaded', function() {
            let deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure?')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
