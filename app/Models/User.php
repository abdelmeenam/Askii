<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail , HasLocalePreference
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'type'
    ];

    /**
     * The attributes that should be appended to serialization.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'photo_url'     //getPhotoUrlAttribute()
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'profile_photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'notification_options' => 'json'
    ];

    //relationship with question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    //relationship with answer
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    //relationship with profile
    public function profile()
    {
        return $this->hasOne(Profile::class)
            ->withDefault();
    }

    // prefered language
    public function preferredLocale(): string
    {
        //return $this->profile->preferred_lang ;
        return 'en';
    }
    public function routeNotificationForVonage($notification)
    {
        return $this->mobile_number;
    }

    //relationship with role
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_user',
            'user_id',
            'role_id',
            'id',
            'id'
        );
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name=' .$this->name ;
    }
}
