<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeoOption extends Model
{

    protected $table = 'seo_option';

    protected  $hidden = ['id', 'created_at', 'updated_at'];

    public $timestamps = true;

    protected  $fillable = ['seo_id', 'meta', 'keywords'];
}
