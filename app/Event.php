<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = ['event_id', 'event_name', 'event_time', 'event_location', 'description', 'customer_id'];

    public static $rules = [
        'event_name' => 'required',
        'event_time' => 'required|date_format:d/m/Y H:i A',
        'event_location' => 'required',
        'description' => 'required',
    ];
    public static $messages = [
        'event_name.required' => 'Name is required',
        'event_time.date_format' => 'Event Time Format',
        'event_time.required' => 'Event Time is required',
        'event_location.required' => 'Location is required',
        'description.required' => 'Description is required',
    ];

    public $timestamps = true;

    public function customer(){
        return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function artists(){
        return $this->belongsToMany('App\Artist', 'event_artist', 'event_id', 'artist_id');
    }


}
