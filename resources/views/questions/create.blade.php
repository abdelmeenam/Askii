@extends('layouts.default')


@section('title', __('New Question'))
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endpush



@section('content')

    <form action="{{ route('questions.store') }}" method="post">
        @csrf

        {{--        <x-test > --}}
        {{--            <x-slot name="title">php post</x-slot> --}}
        {{--            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad architecto aut dicta, distinctio dolore eos error impedit nisi, pariatur quisquam quo repellat soluta voluptas, voluptates. Alias cum illo minima?</p> --}}
        {{--        </x-test> --}}

        <div class="form-group mb-3">
            <x-form-input type="text" id="title" label="Question Title" name="title" :value="old('title')">
            </x-form-input>
        </div>

        <div class="form-group mb-3">
            <x-form-textarea id="description" label="Question Description" name="description"></x-form-textarea>
        </div>

        <!-- Tags -->
        <div class="form-group mb-3">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label for="description">{{ __('Tags') }}</label>
                    <select name="tags[]" id="selectall-tag" class="form-control select2" multiple>
                        <option value="" disabled>Select Tags</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <button id="deselectbtn-tag" type='button' class="m-1">Remove all these tags ⬆</button>
                    @if ($errors->has('tags'))
                        <div class="text-danger">
                            {{ $errors->first('tags') }}
                        </div>
                    @endif
                </div>

            </div>


        </div>

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">Create Question</button>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#selectbtn-tag").click(function() {
            $("#selectall-tag > option").prop("selected", "selected");
            $("#selectall-tag").trigger("change");
        });
        $("#deselectbtn-tag").click(function() {
            $("#selectall-tag > option").prop("selected", "");
            $("#selectall-tag").trigger("change");
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
