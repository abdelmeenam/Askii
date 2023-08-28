<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth' ,'checkUserType:admin,super-admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('roles.view');
        $roles = Role::Paginate();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('roles.create');
        return view('roles.create', [
            'role' => new Role(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('roles.create');
        $request->validate([
            'name' => ['required' , 'string'],
            'abilities' => ['required' , 'array']
        ]);

        $role = Role::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('roles.edit');

        $role = Role::findOrFail($id);
        return view('roles.edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('roles.edit');

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id ,
            'abilities.php' => ['required|array'],
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('roles.delete');

        Role::destroy($id);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
