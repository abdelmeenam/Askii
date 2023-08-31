<x-dashboard-layout>

    <x-slot name="title">
        Edit User
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">edit user</li>
    </x-slot>


    @include('users._form' , [
        'action' => route('users.update' , $user->id),
        'method' => 'PUT',
        'roles' => $roles,
    ])


    </x-dashboard-layout>
