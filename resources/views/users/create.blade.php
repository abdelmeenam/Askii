<x-dashboard-layout>

    <x-slot name="title">
        Create User
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Create User</li>
    </x-slot>


    @include('users._form' , [
        'action' => route('users.store'),
        'method' => 'POST' ,
    ])

    </x-dashboard-layout>
