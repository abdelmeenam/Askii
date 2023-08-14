<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    // edit password form
    public function edit()
    {
        return view('user-profile.change-password');
    }

    // update password
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = Auth::user();

        $user->forceFill([
            'password' => Hash::make($request->input('password'))
        ])->save();

        return redirect()->route('password.edit')
            ->with('success', 'Password changed');
    }
}
