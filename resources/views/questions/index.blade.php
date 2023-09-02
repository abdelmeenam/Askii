@extends('layouts.default')

@section('title')
{{__('Questions List')}}
    <a href="{{route('questions.create')}}" class="btn btn-outline-primary ">{{__('Create Question')}}
    </a>
@endsection


@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @foreach($questions as $question)
        <div class="card mb-3" >
            <div class="card-body">
                <h5 class="card-title"><a href="{{route('questions.show' , $question->id) }}">{{ $question->title }}</a></h5>
                <div class="text-muted mb-4">
                    Asked: <strong> {{ $question->created_at->diffForHumans() }}_____</strong>
                    {{__('By')}}: <strong>{{ $question->user->name }}______</strong>
                    # of Answers: <strong> {{ $question->answers_count }} </strong>

                </div>
                <p class="card-text">{{ Str::words($question->description , 20 ) }}</p>
                <div>
                    {{__('Tags')}}: {{$question->tags->pluck('name')->implode(', ')}}
                </div>
            </div>

            @can('update' , $question)
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            {{--                        <a href="{{route('questions.show' , $question->id) }}" class="btn btn-outline-primary btn-sm">View</a>--}}
                            <a href="{{route('questions.edit' , $question->id) }}" class="btn btn-outline-info btn-sm">Edit</a>
                        </div>
                        <div>
                            <form action="{{route('questions.destroy' , $question->id)}}" method="post" class="delete-form">
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


    {{ $questions->withQueryString()->links() }}

    <script>
                setTimeout(function() {
                    // document.querySelector('.alert').remove();
                    document.querySelector('.alert').style.display = 'none';
                },4000);

            </script>

@endsection
