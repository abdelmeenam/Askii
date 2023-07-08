<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id' , 'question_id'];

    //relationship with question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    //relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
