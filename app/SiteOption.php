<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteOption extends Model
{

    protected $table = 'site_option';

    public $timestamps = true;

    protected $fillable = ['name', 'value'];

}
