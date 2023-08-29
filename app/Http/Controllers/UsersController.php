<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    // show all users with their roles
    public function index()
    {
        //Gate::authorize('users.view');
        $users = User::with('roles')
            ->whereIn('type',['admin' , 'super-admin'])
            ->paginate(8);
        return view('users.index', compact('users'));
    }

    // create user role
    public function create()
    {
        //Gate::authorize('users.create');
        return view('users.create' , [
            'user' => new User(),
            'roles' => Role::all()
        ]);
    }

    // store user role
    public function store(Request $request)
    {
        //Gate::authorize('users.create');
        //conn.miracle@example.net
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'type' => 'required',
            'roles' => 'required|array',
        ]);

        $user = User::whereEmail($request->email)->first();
        if (!$user){
            return back()->with('error' , 'User not found');
        }

        // DB Transaction
        DB::beginTransaction();
        try{
            $user->update($request->only('type'));
            $user->roles()->attach($request->roles);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }
        return redirect()->route('users.index')->with('success' , 'User created successfully');
    }

    // edit user role
    public function edit(User $user)
    {
        //Gate::authorize('users.edit');
        return view('users.edit' , [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    // update user role
    public function update(Request $request, User $user)
    {
        //Gate::authorize('users.edit');
        $request->validate([
            'type' => 'required',
            'roles' => 'required|array',
        ]);

        // DB Transaction
        DB::beginTransaction();
        try{
            $user->update($request->only('type'));
            $user->roles()->sync($request->roles);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }
        return redirect()->route('users.index')->with('success' , 'User updated successfully');
    }

    // delete user role
    public function destroy(User $user)
    {
        //Gate::authorize('users.delete');
        $user->delete();
        return redirect()->route('users.index')->with('success' , 'User deleted successfully');
    }

}
