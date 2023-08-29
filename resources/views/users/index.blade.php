@extends('layouts.default')

@section('title')
    Users List
    <a href="{{route('users.create')}}" class="btn btn-outline-dark btn-xs">Create New Admin</a>
@endsection

@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif


    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->type }}</td>
                    <td>{{ $user->roles->pluck('name')->implode(', ')  }}</td>
                    <td>
                        <form class="delete-form " action="{{ route('users.destroy' , $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a  href="{{ route('users.edit' , $user->id) }}" class="mt-1 btn btn-info btn-sm">Edit</a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->withQueryString()->links() }}

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
