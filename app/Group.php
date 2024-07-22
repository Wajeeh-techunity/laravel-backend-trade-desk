<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['created_user_id','name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
