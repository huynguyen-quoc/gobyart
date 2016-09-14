<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtistType extends Model
{
    protected $table = 'artist_type';

    protected $fillable = ['name', 'type_id', 'slug', 'order'];

    protected $hidden = ['id', 'created_at', 'updated_at'];
}
