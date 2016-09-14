<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MusicCategoryController extends Controller
{
    public function index(){
        return view('music-category.index');
    }
}
