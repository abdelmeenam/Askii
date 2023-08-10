@extends('layouts.default')

@section('title')
    Tags List
    <a href="{{route('tags.create')}}" class="btn btn-outline-dark btn-xs">Create New Tag</a>
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Tag id</th>
                <th>Tag Name</th>
                <th>Tag Slug</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td>{{ $tag->created_at }}</td>
                    <td>{{ $tag->updated_at }}</td>
                    <td>
                        <form class="delete-form" action="{{ route('tags.destroy' , $tag->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a  href="{{ route('tags.edit' , $tag->id) }}" class="mt-2 btn btn-info btn-sm">Edit</a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        setTimeout(function() {
            document.querySelector('.alert').remove();
        },4000);

        document.querySelector('.delete-form').addEventListener('submit' , function(e){
            e.preventDefault();
            if(confirm("Are you sure you want to delete this item ?")){
                // this.submit();
                e.target.submit();
            }
        })
    </script>


@endsection
