<x-dashboard-layout>

    @push('scripts')
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
    @endpush


    <x-slot name="title">
        Create Role
    </x-slot>



    <x-slot name="title">
        Create Role
        <a href="{{route('roles.create')}}" class="btn btn-outline-dark btn-xs">Create New Role</a>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Create Role</li>
    </x-slot>

    <x-alert />

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
                        <div class="d-flex">
                            <form class="delete-form mr-2 " action="{{ route('roles.destroy' , $role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <a  href="{{ route('roles.edit' , $role->id) }}" class=" btn btn-info btn-sm">Edit</a>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>




</x-dashboard-layout>
