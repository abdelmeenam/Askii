<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfile extends Controller
{
    //edit
    public function edit()
    {
        return view('user-profile.edit' ,[
            'user' => auth()->user()
        ]);
    }

    //update
    public function update(Request $request)
    {
        $user = auth()->user();

        //validate
        $this->validate($request, [
            'name' => ['required' , 'string' ],
            'email' => ['required' , 'email' , 'unique:users,email,' . auth()->id()],
            'profile_photo' => ['nullable' , 'image' , 'mimes:jpg,jpeg,png,gif,svg' , 'max:512000'],
        ]);


        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
