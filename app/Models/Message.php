<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'source', 'doctor_id', 'name', 'email', 'phone', 'specialty', 'subject', 'message',
    ];
}
