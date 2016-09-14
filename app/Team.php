<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Team extends Model
{
    use Sluggable;

    protected $table = 'team';


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public $timestamps = true;

    protected $hidden = ['id', 'updated_at', 'avatar_id'];

    protected $fillable = ['name', 'career', 'team_id'];

    public static $rules = [
        'file' => 'required',
        'name' => 'required',
        'career' => 'required',
    ];
    public static $messages = [
        'file.required' => 'Image is required',
        'career.required' => 'Position is required',
        'name.required' => 'Name is required'
    ];

    public function avatar(){
        return $this->hasOne('App\Image', 'id', 'avatar_id');
    }
}
