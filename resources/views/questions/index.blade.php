<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
<h1>
    @auth()
        hello , {{Auth::user()->name}}
    @endauth
</h1>
<h2>
<a href="{{route('questions.create')}}">Create Question</a>
</h2>
<table class="table" style="">
    <thead>
    <tr>
        <th>title</th>
        <th>description</th>
        <th>status</th>
        <th>views</th>
        <th>Asked by</th>

        <th>Created At</th>

        <th>DELETE</th>
        <th>EDIT</th>

    </tr>
    </thead>
    <tbody>
    @foreach($questions as $question)
        <tr>
            <td><a href="{{route( 'questions.show',$question->id )}}">{{ $question->title }}</a></td>
            <td>{{ Str::words($question->description , 20) }}</td>
            <td>{{ $question->status }}</td>
            <td>{{ $question->views }}</td>
            <td>{{ $question->user_name }}</td>


            <td>{{ $question->created_at->diffForHumans() }}</td>
            @if(Auth::id() == $question->user_id)
            <td>
                <form class="delete-form" action="{{route('questions.destroy' , $question->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>

            <td>
                <a href="{{route('questions.edit' , $question->id)}}" class="btn btn-primary btn-sm">Edit</a>
            </td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>

{{$questions->links()}}


</body>
</html>
