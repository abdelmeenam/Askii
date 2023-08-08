@extends('layouts.default')

@section('title' ,'Edit Question')
@section('content')

    <form action="{{route('questions.update' , $question->id )}}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <x-form-input  type="text" id="title"  label="Question Title" name="title" :value="$question->title">
            </x-form-input>
        </div>

        <div class="form-group mb-3">
            <x-form-textarea id="description" label="Question Description" name="description" :value="$question->description"></x-form-textarea>
        </div>


        <!-- Tags -->
        <div class="form-group mb-3">
            <label for="description">Tags</label>
            @foreach($tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{$tag->id}}" id="{{$tag->id}}" @checked(in_array($tag->id , $questionTags)) >
                    <label class="form-check-label" for="tag--{{$tag->id}}">
                        {{$tag->name}}
                    </label>
                </div>
            @endforeach
        </div>


        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">Update Question</button>
            </div>
        </div>

    </form>

@endsection
