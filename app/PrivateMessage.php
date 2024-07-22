<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'sender_name', 'reciever_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
