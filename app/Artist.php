<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Gloudemans\Shoppingcart\Facades\Cart;

class Artist extends Model
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
                'source' => 'full_name'
            ]
        ];
    }

    protected $table = 'artist';

    public function music_category(){
        return $this->hasOne('App\MusicCategory', 'id', 'music_category_id');
    }

    public function seo(){
        return $this->hasOne('App\SeoOption', 'id', 'seo_id');
    }

    public function avatar(){
        return $this->hasOne('App\File', 'id', 'avatar_id');
    }

    public function files(){
        return $this->belongsToMany('App\File', 'artist_file', 'artist_id', 'file_id');
    }
    protected $appends = array('added_cart');

    protected $dates = ['date_of_birth'];

    public static $rules = [
        'file' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'full_name' => 'required',
        //'date_of_birth' => 'required|date_format:d/m/Y'
    ];
    public static $messages = [
        'file.required' => 'Image is required',
        //'date_of_birth.date_format' => 'Invalid Format',
        //'date_of_birth.required' => 'Date Of Birth is required',
        'last_name.required' => 'Last Name is required',
        'first_name.required' => 'First Name is required',
        'full_name.required' =>   'Full Name is required',
    ];
    public $timestamps = true;

    protected $fillable = ['artist_id', 'first_name', 'last_name', 'full_name', 'date_of_birth', 'slug', 'order', 'description', 'extra_information', 'music_category_id'];

    protected $hidden = ['id', 'deleted_at', 'avatar_id', 'seo_id', 'type_id', 'updated_at', 'user_id_edited', 'user_id'];

    public function getExtraInformationAttribute($value){
        return (array) json_decode($value);
    }

    public function getAddedCartAttribute(){
        $added = false;
        foreach(Cart::content() as $row) {
            if($row->id == $this->artist_id){
                $added = true;
                break;
            }
        }
        return $added;
    }
}
