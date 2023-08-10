
<form action="{{$action}}" method="post">
    @csrf
    @if($method == 'PUT')
        @method('PUT')
    @endif
    <div class="form-group mb-3">
        <label for="name">{{__('Question title')}}:</label>
        <div class="mt-2">
            <input type="text" name="title" value="{{old('title',$question->title)}}" class="form-control ">
            @error('title')
                <span class="text-danger">{{$errors->first('title')}}</span>
            @enderror
        </div>

        <label for="name">'Question description':</label>
        <div class="mt-2">
            <input type="text" name="description" value="{{old('description',$question->description)}}" class="form-control ">
            @error('description')
            <span class="text-danger">{{$errors->first('description')}}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
