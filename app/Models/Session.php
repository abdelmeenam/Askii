<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Session extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];


    public $incrementing = false; // UUIDs are not auto-incrementing
    protected $keyType = 'string'; // Set the primary key type to string
    protected $casts = [
        'last_activity' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}