<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    public $timestamps = true;

    protected $fillable = ['customer_id', 'customer_name', 'customer_phone', 'customer_email'];

}
