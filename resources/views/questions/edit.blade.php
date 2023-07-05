@include('questions._form',
    [
        'action' => route('questions.update' , $question->id),
        'method' => 'PUT',
        'title' => 'Edit Question'
    ])
