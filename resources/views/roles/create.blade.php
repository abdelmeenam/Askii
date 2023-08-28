@extends('layouts.default')

@section('title' , 'Create ROle')

@section('content')

    @include('roles._form' , [
        'action' => route('roles.store'),
        'method' => 'POST' ,
    ])

@endsection
