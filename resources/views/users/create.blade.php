@extends('layouts.default')

@section('title' , 'Create User Role')

@section('content')

    @include('users._form' , [
        'action' => route('users.store'),
        'method' => 'POST' ,
    ])

@endsection
