<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use Sluggable;
    protected $table = 'pages';
    protected $guarded = ['deleted_at','_token'];

    protected $sluggable = [

        'build_from' => 'title',

        'save_to'    => 'slug',

    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $rules = [
        'slug' => 'sometimes|required|unique:pages',
    ];

    public function findUser(){
        return $this->belongsTo('App\User', 'user_id');
    }

}
