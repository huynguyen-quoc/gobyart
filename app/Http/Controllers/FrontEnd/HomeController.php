<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\FrontEnd\FrontEndController;
use App\Artist;
use App\ArtistType;
use App\Event;
use DB;
class HomeController extends FrontEndController
{
    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $hotArtists = Artist::query()
            ->select('artist.*')
            ->with('music_category.type')
            ->with('seo')
            ->with('avatar')
            ->inRandomOrder()
            ->limit(10)
            ->get();

//        $partners = File::query()
//            ->join('file_group', 'file.id', '=', 'file_group.file_id')
//            ->join('group as g1', function($join)
//            {
//                $join->on('g1.id', '=', 'file_group.group_id');
//                $join->on('g1.name', '=', DB::raw('\'PARTNER_TYPE\''));
//                $join->on('g1.type', '=', DB::raw('\'FILE_TYPE\''));
//            })
//            ->select('file.*')
//            ->with('seo_option')
//            ->inRandomOrder()
//            ->limit(10)
//            ->get();


        $artistTypes = ArtistType::all();

        return view('frontend.pages.home', compact('hotArtists', 'artistTypes', 'partners'));
    }
}
