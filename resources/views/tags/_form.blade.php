
<form action="{{$action}}" method="post">
    @csrf
    @if($method == 'PUT')
        @method('PUT')
    @endif
    <div class="form-group mb-3">
        <label for="name">Tag Name:</label>
        <div class="mt-2">
            <input type="text" name="name" value="{{old('name',$tag->name)}}" class="form-control ">
            @error('name')
                <span class="text-danger">{{$errors->first('name')}}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
