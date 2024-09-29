<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['description', 'user_id', 'question_id'];

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