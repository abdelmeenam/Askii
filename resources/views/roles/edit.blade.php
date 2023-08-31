<x-dashboard-layout>

    <x-slot name="title">
        Edit Role
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active"> Edit Role </li>
    </x-slot>

@include('roles._form' , [
    'action' => route('roles.update' , $role->id),
    'method' => 'PUT',
    'tag' => $role
])


</x-dashboard-layout>
