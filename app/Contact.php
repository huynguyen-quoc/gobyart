<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $fillable = ['contact_id', 'contact_name', 'contact_phone', 'contact_email', 'contact_title', 'contact_content'];

    public $timestamps = true;
}
