<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;


class AuthenticationTokensController extends Controller
{
    const TOKEN_NAME= 'personal';
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken(self::TOKEN_NAME, ['*'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ] , 201);

    }

    // store token
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ( $user &&  Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name, ['*']);
            return response()->json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ] , 201);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);

    }

    // destroy token
    public function destroy(Request $request , $token = null)
    {
        $user =Auth::guard('sanctum')->user();
        if (null === $token) {
            $user->currentAccessToken()->delete();
            return;
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);
        if ( $user->id == $personalAccessToken->tokenable_id  && get_class($user) == $personalAccessToken->tokenable_type) {
            $personalAccessToken->delete();
        }

        return response()->json([
            'message' => 'Token deleted'
        ]);

    }

    // update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = Auth::user();

        $user->forceFill([
            'password' => Hash::make($request->input('password'))
        ])->save();

        return response()->json([
            'message' => 'Password changed'
        ]);
    }


}
