@extends('layouts.default')

@section('title')
    Tags List
    <a href="{{route('roles.create')}}" class="btn btn-outline-dark btn-xs">Create New Role</a>
@endsection

@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif



    <table class="table">
        <thead>
            <tr>
                <th>Role Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        <form class="delete-form " action="{{ route('roles.destroy' , $role->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a  href="{{ route('roles.edit' , $role->id) }}" class="mt-1 btn btn-info btn-sm">Edit</a>
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
