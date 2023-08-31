<x-dashboard-layout>

    <x-slot name="title">
        Edit Tag
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Edit Tag</li>
    </x-slot>

    @include('tags._form' , [
        'action' => route('tags.update' , $tag->id),
        'method' => 'PUT',
        'tag' => $tag
    ])

</x-dashboard-layout>
