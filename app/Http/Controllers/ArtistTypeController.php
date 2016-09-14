<?php

namespace App\Http\Controllers;


use App\Http\Requests;

class ArtistTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.custom');
    }

    public function index(){
        return view('artist-type.index');
    }

}
