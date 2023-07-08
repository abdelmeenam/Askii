@extends('layouts.default')

@section('title' ,'Edit Answer')
@section('content')

    <form action="{{route('answers.update' , $answer->id )}}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="description">answer Description</label>
            <div>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{old('description' , $answer->description)}}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">Update Answer</button>
            </div>
        </div>

    </form>

@endsection
