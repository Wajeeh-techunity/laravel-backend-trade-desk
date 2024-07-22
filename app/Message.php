<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'username', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

