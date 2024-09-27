@extends('layouts.default')


@push('styles')
@endpush

@section('title')
    <div class="d-flex justify-content-between align-items-center">
        <h2>{{ __('Questions List ') }}<i class="fa-solid fa-person-circle-question me-2"></i></h2>
        <a href="{{ route('questions.create') }}" class="btn btn-success">{{ __('+ Ask') }}</a>
    </div>
@endsection


@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    @foreach ($questions as $question)
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
                        <strong>{{ $question->created_at->diffForHumans() }}</strong> &bull;
                        <i class="fas fa-user me-1"></i>{{ __('By') }}:
                        <strong>{{ $question->user->name ?? __('Unknown') }}</strong> &bull;
                        <i class="fas fa-comment-dots me-1"></i>{{ __('Number of Answers') }}:
                        <strong>{{ $question->answers_count }}</strong>
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
                            <i class="fas fa-eye me-1"></i>{{ __('Views') }}: {{ $question->views }}
                        </span>
                    </div>
                </div>
            </div>

            @can('update', $question)
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            {{--                        <a href="{{route('questions.show' , $question->id) }}" class="btn btn-outline-primary btn-sm">View</a> --}}
                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-outline-info btn-sm">Edit</a>
                        </div>
                        <div>
                            <form action="{{ route('questions.destroy', $question->id) }}" method="post" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

        </div>
    @endforeach




    <div class="container d-flex justify-content-center align-items-center">
        {{ $questions->withQueryString()->links() }}
    </div>

    <script>
        setTimeout(function() {
            // document.querySelector('.alert').remove();
            //document.querySelector('.alert').style.display = 'none';
            document.querySelector('.alert') ? document.querySelector('.alert').style.display = 'none' : '';
        }, 4000);
    </script>
@endsection
