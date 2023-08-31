<x-dashboard-layout>

    <x-slot name="title">
        Create Role
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Create Tag</li>
    </x-slot>

    @include('roles._form' , [
        'action' => route('roles.store'),
        'method' => 'POST' ,
    ])

</x-dashboard-layout>
