

<div>
    <img src="{{asset('storage/'.$user->profile_photo)}}">
</div>

<hr>
<form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <label for="name">user Name:</label>
        <div class="mt-2">
            <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control ">
            @error('name')
            <span class="text-danger">{{$errors->first('name')}}</span>
            @enderror
        </div>


        <label for="name">user Email:</label>
        <div class="mt-2">
            <input type="text" name="email" value="{{old('email',$user->email)}}" class="form-control ">
            @error('email')
            <span class="text-danger">{{$errors->first('email')}}</span>
            @enderror
        </div>


        <label for="name">user Photo:</label>
        <div class="mt-2">
            <input type="file" name="profile_photo" class="form-control ">
            @error('profile_photo')
            <span class="text-danger">{{$errors->first('profile_photo')}}</span>
            @enderror
        </div>




    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
