@extends('layouts.default')

@section('title' ,'New Question')

@section('content')

    <form action="{{route('questions.store')}}" method="post">
        @csrf

{{--        <x-test >--}}
{{--            <x-slot name="title">php post</x-slot>--}}
{{--            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad architecto aut dicta, distinctio dolore eos error impedit nisi, pariatur quisquam quo repellat soluta voluptas, voluptates. Alias cum illo minima?</p>--}}
{{--        </x-test>--}}

        <div class="form-group mb-3">
            <x-form-input  type="text" id="title"  label="Question Title" name="title" :value="old('title')">
            </x-form-input>
        </div>

        <div class="form-group mb-3">
            <x-form-textarea id="description" label="Question Description" name="description"></x-form-textarea>
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
