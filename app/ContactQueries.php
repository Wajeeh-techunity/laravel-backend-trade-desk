<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactQueries extends Model
{
    protected $table = 'contact_queries';
    protected $guarded = ['_token'];
}
