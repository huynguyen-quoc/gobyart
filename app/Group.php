<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';

    public function files(){
        return $this->belongsToMany('App\File', 'file_group', 'group_id', 'file_id');
    }
}
