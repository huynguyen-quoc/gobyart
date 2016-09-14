<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class File extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'original_name'
            ]
        ];
    }

    public $timestamps = true;

    protected $table = 'file';

    protected $hidden = ['id', 'updated_at', 'seo_id', 'pivot'];

    public function groups(){
       return $this->belongsToMany('App\Group', 'file_group', 'file_id', 'group_id');
    }

    public function seo(){
        return $this->belongsTo('App\SeoOption','seo_id','id');
    }
}
