@extends('layouts.default')




@section('title', 'Edit Question')
@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

    <form action="{{ route('questions.update', $question->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <x-form-input type="text" id="title" label="Question Title" name="title" :value="$question->title">
            </x-form-input>
        </div>

        <div class="form-group mb-3">
            <x-form-textarea id="description" label="Question Description" name="description"
                :value="$question->description"></x-form-textarea>
        </div>


        <!-- Tags -->
        <div class="form-group mb-3">
            <label for="description">{{ __('Tags') }}</label>
            <select name="tags[]" id="selectall-tag" class="form-control select2" multiple>
                <option value="" disabled>Select Tags</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, $questionTags))>{{ $tag->name }} </option>
                @endforeach
            </select>

            <br />
            <button id="deselectbtn-tag" type='button' class="m-1">Remove all these tags ⬆</button>
        </div>


        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">Update Question</button>
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
