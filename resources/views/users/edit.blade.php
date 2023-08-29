@extends('layouts.default')

@section('title' , 'Edit Role')

@section('content')

    @include('users._form' , [
        'action' => route('users.update' , $user->id),
        'method' => 'PUT',
        'roles' => $roles,
    ])

@endsection
