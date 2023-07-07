<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UserProfile extends Controller
{
    //edit
    public function edit()
    {
        return view('user-profile.user-profile' ,[
            'user' => auth()->user()
        ]);
    }

    //update
    public function update(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'name' => ['required' , 'string' ],
            //'email' => ['required' , 'email' , 'unique:users,email,' . auth()->id()],
            'profile_photo' => ['nullable' , 'image' , 'mimes:jpg,jpeg,png,gif,svg' , 'max:512000'],
        ]);

        $previousProfilePhoto = $user->profile_photo;
        $data = $request->except('image');

        //upload image
        if($request->hasFile('profile_photo')){
            $file = $request->file('profile_photo');
            $path = $file->store('uploads' , ['disk' => 'public']);
            $data['profile_photo'] = $path;
        }

        $user->update($data);

        if ($previousProfilePhoto  && $previousProfilePhoto != $user->profile_photo) {
            Storage::disk('public')->delete($previousProfilePhoto);
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }
}
