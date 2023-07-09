@extends('layouts.default')

@section('title' ,'New Question')

@section('content')

    <form action="{{route('questions.store')}}" method="post">
        @csrf
        <div class="form-group mb-3">
            <label for="title">Question Title</label>
            <div>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"  name="title" value="{{old('title')}}">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="description">Question Description</label>
            <div>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{old('description')}}</textarea>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Tags -->
        <div class="form-group mb-3">
            <label for="description">Tags</label>
            @foreach($tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{$tag->id}}" id="{{$tag->id}}">
                    <label class="form-check-label" for="tag--{{$tag->id}}">
                        {{$tag->name}}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">Create Question</button>
            </div>
        </div>

    </form>

@endsection
