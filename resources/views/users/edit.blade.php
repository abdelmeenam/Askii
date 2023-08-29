@extends('layouts.default')

@section('title' , 'Edit Role')

@section('content')

    @include('roles._form' , [
        'action' => route('roles.update' , $role->id),
        'method' => 'PUT',
        'tag' => $role
    ])

@endsection
