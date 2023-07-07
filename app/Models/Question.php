<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    //mass assignment
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
    ];

    //relationship  with answer
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    //relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relationship with tag
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class ,            // Related model
            'question_tag',          // Pivot table
            'question_id',   // F.K of this current model
            'tag_id',        // F.K of the related model
            'id',
            'id'
        );
    }
}
