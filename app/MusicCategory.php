<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class MusicCategory extends Model
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

    protected $hidden = ['id', 'updated_at', 'seo_id', 'pivot'];

    protected $table = 'music_category';

    protected $fillable = ['category_id', 'name', 'slug', 'order'];

    public function type(){
        return $this->hasOne('App\ArtistType', 'id', 'artist_type_id');
    }
}
