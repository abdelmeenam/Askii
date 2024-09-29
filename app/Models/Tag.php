<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, Searchable;


    protected $fillable = ['name', 'slug'];


    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'question_tag',
            'tag_id',
            'question_id',
            'id',
            'id'
        );
    }
}