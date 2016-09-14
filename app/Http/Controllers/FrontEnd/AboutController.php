<?php

namespace App\Http\Controllers\FrontEnd;

use App\ArtistGroup;
use App\File;
use App\Team;
use DB;

class AboutController extends FrontEndController  {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $galleries = File::query()
            ->join('file_group', 'file.id', '=', 'file_group.file_id')
            ->join('group as g1', function($join)
            {
                $join->on('g1.id', '=', 'file_group.group_id');
                $join->on('g1.name', '=', DB::raw('\'FILE_TYPE\''));
                $join->on('g1.type', '=', DB::raw('\'GALLERY_TYPE\''));
            })
            ->select('file.*')
            ->with('seo')
            ->inRandomOrder()
            ->limit(20)
            ->get();

        $teams = Team::query()
            ->with('avatar')
            ->inRandomOrder()
            ->limit(5)
            ->get();

		return view('frontend.pages.about', compact('galleries', 'teams'));
	}

}