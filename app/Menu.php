<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $guarded = ['_token'];

    public function findChildMenus(){
        return $this->hasMany('App\Menu', 'parent_id')->orderBy('position','ASC');
    }
}
