@extends('layouts.default')

@section('name' ,'Edit Profile')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <img src="{{asset('storage/'.$user->profile_photo)}}" class="img-fluid" alt="{{ $user->name }}">

        </div>
        <div class="col-md-9">
            <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <div>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"  name="name" value="{{old('name' , $user->name)}}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <div>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"  name="email" value="{{old('email' , $user->email)}}" disabled>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="profile_photo">Profile Photo</label>
                    <div>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"  name="profile_photo">
                        @error('profile_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection
