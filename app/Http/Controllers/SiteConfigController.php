<?php

namespace App\Http\Controllers;

use App\SiteOption;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class SiteConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.custom');
    }

    public function index(){

        $options = SiteOption::where('type', '=', DB::raw('\'SITE\''))
            ->orderBy('order', 'ASC')
            ->get();

        return view('site-config.index', compact('options'));
    }

    public function location(){

        $longitude = SiteOption::where('type', '=', DB::raw('\'SITE_LOCATION\''))
                ->where('name','=', DB::raw('\'LOCATION_LONGITUDE\''))
                ->first();

        $latitude = SiteOption::where('type', '=', DB::raw('\'SITE_LOCATION\''))
            ->where('name','=', DB::raw('\'LOCATION_LATITUDE\''))
            ->first();


        return view('site-config.location', compact('longitude', 'latitude'));
    }

    public function company(){

        $options = SiteOption::where('type', '=', DB::raw('\'SITE_DESCRIPTION\''))
            ->orderBy('order', 'ASC')
            ->get();


        return view('site-config.company', compact('options'));
    }



}
