<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_photo',
        'about',
        'facebook',
        'twitter',
        'linkedin',
        'github',
        'youtube',
        'instagram',
    ];

    // Primary key
    protected $primaryKey = 'user_id';

    // incrementing
    public $incrementing = false;

    //relationship with user
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id') ;
    }

}
