<x-dashboard-layout>

    <x-slot name="title">
        Create Tag
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Create Tag</li>
    </x-slot>

@section('content')

    @include('tags._form' , [
        'action' => route('tags.store'),
        'method' => 'POST'
    ])

</x-dashboard-layout>
