<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $question->title }}</h5>
        <p class="card-text">{{ $question->description }}</p>
        <p class="card-text"><small class="text-muted">{{ $question->created_at->diffForHumans() }}</small></p>
        <p> created by {{$question->user_name}} </p>
    </div>
</div>

</body>
</html>
