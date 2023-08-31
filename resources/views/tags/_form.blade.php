

<form action="{{ $action }}" method="post">
    @csrf
    @if($method == 'PUT')
        @method('PUT')
    @endif
    <div class="form-group mb-3">
        <label for="name" class="form-label">Tag Name</label>
        <div class="mt-3">
            <input type="text" value="{{ old('name' , $tag->name) }}"  class="form-control @error('name') is-invalid @enderror " id="name" name="name" required>

            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
