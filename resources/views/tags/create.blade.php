@extends('layouts.default')

@section('title' , 'Create Tag')

@section('content')

    @include('tags._form' , [
        'action' => route('tags.store'),
        'method' => 'POST'
    ])

@endsection
