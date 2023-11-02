<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class News extends Model
{
    use Sluggable;
    protected $table = 'news';
    protected $guarded = ['_token'];


    protected $sluggable = [

        'build_from' => 'title',

        'save_to'    => 'slug',

    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function findUser(){
        return $this->belongsTo('App\User', 'user_id');
    }


}
