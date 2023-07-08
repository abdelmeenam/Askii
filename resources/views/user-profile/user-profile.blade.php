@extends('layouts.default')

@section('name' ,'Edit Profile')

@section('content')

    <!-- sucess message -->
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif

    <div class="row">

        <!-- profile photo -->
        <div class="col-md-3">
            <img src="{{asset('storage/'.$user->profile_photo)}}" class="img-fluid" alt="{{ $user->name }}">
        </div>

        <!-- profile form -->
        <div class="col-md-9">
            <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!--name input-->
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <div>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"  name="name" value="{{old('name' , $user->name)}}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--first name input-->
                <div class="form-group mb-3">
                    <label for="name">First name</label>
                    <div>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"  name="first_name" value="{{old('first_name' , $user->profile->first_name)}}">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--last name input-->
                <div class="form-group mb-3">
                    <label for="name">Last name</label>
                    <div>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"  name="last_name" value="{{old('last_name' , $user->profile->last_name)}}">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--phone input-->
                <div class="form-group mb-3">
                    <label for="name">Phone</label>
                    <div>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"  name="phone_number" value="{{old('phone' , $user->profile->phone_number)}}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--Gender input-->
                <div class="form-group mb-3">
                    <label for="name">Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value = 'male'  id="flexRadioDefault1" @checked($user->profile->gender == 'male')>
                        <label class="form-check-label" for="male">
                            male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value = 'female' id="flexRadioDefault2" @checked($user->profile->gender == 'female')>
                        <label class="form-check-label" for="female">
                            female
                        </label>
                    </div>
                </div>

                <!--date of birth input-->
                 <div class="form-group mb-3">
                    <label for="name">Date of birth</label>
                    <div>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth"  name="date_of_birth" value="{{old('date_of_birth' , $user->profile->date_of_birth)}}">
                        @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--city input-->
                <div class="form-group mb-3">
                    <label for="name">City</label>
                    <div>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"  name="city" value="{{old('city' , $user->profile->city)}}">
                        @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--country input-->
                <div class="form-group mb-3">
                    <label for="name">Country</label>
                    <select class="form-select @error('country') is-invalid @enderror" aria-label="Default select example" name="country">
                        <option value="">Open this select menu</option>
                        @foreach($countries as $code =>$name)
                            <option value="{{$code}}" @selected($user->profile->country == $code)>{{$name}}</option>
                        @endforeach
                    </select>
                </div>

                <!--Email input-->
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <div>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"  name="email" value="{{old('email' , $user->email)}}" disabled>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--Profile input-->
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
