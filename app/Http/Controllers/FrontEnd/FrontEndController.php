<?php

namespace App\Http\Controllers\FrontEnd;
use Illuminate\Support\Facades\Cache;
use View;
use App\Http\Controllers\Controller;
use App\SiteOption;

class FrontEndController extends Controller
{
    public function __construct() {
        if(!Cache::has('site_options')) {
            Cache::remember('site_options', 15, function () {
                //get site options
                $options = SiteOption::query()
                    ->where("type", "=", "SITE")
                    ->orWhere("type", "=", "SITE_DESCRIPTION")
                    ->orWhere("type", "=", "SITE_LOCATION")
                    ->orderBy('order', 'asc')
                    ->get();
                $jsonOption = [];
                foreach ($options as $option) {
                    $jsonOption[strtolower($option->name)] = htmlentities($option->value, ENT_QUOTES, 'UTF-8', false);
                }
                return $jsonOption;
            });
            $jsonOption = Cache::get('site_options');
            View::share('siteOptions', $jsonOption);
        }else{
            $jsonOption = Cache::get('site_options');
            View::share('siteOptions', $jsonOption);
        }

    }
}
