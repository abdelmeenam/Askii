<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;


class UserProfile extends Controller
{
    //edit
    public function edit()
    {
        return view('user-profile.user-profile' ,[
            'countries' => Countries::getNames(),
            'user' => auth()->user()
        ]);
    }

    //update
    public function update(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'name' => ['required' , 'string' ],
            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'phone_number' => ['required' , 'string' , 'max:255'],
            'date_of_birt' => [  'date' , 'before:today'],
            'city' => [ 'string' , 'max:255'],
            'gender' => 'required|in:male,female',
            'country' => [ 'string' , 'max:255'],
            'profile_photo' => ['nullable' , 'image' , 'mimes:jpg,jpeg,png,gif,svg' , 'max:512000'],
        ]);

        //upload image
        $previousProfilePhoto = $user->profile_photo;
        $data = $request->except('image');
        if($request->hasFile('profile_photo')){
            $file = $request->file('profile_photo');
            $path = $file->store('uploads' , ['disk' => 'public']);
            $data['profile_photo'] = $path;
        }

        $request->merge(['name' => $request->first_name . ' ' . $request->last_name]);
        $user->update($data);
        $user->profile()->updateOrCreate(['user_id' => $user->id] , $request->all());

        if ($previousProfilePhoto  && $previousProfilePhoto != $user->profile_photo) {
            Storage::disk('public')->delete($previousProfilePhoto);
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }
}
