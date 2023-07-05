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
}
