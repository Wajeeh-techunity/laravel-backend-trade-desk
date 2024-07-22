<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'user_id', 'message', 'user_name',
    ];

    /**
     * Get the group that owns the message.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the user that sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}