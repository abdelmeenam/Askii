@include('tags._form',
    [
        'action' => route('tags.update' , $tag->id),
        'method' => 'PUT',
        'title' => 'Edit Tag'
    ])
