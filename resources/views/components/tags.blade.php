<?php $tags = config('tags'); ?>
@foreach ($tags as $tag)
    <div class="col-md-6 form-check">
        <input type="checkbox" class="form-check-input tag-checkbox" value="{{ $tag }}" id="{{ $tag }}">
        <label class="form-check-label" for="{{ $tag }}">{{ $tag }}</label>
    </div>
@endforeach
