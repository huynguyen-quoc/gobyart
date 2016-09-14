<?php

namespace App\Http\Controllers\FrontEnd;

use App\Artist;
use App\File;
use App\Http\Controllers\FrontEnd\FrontEndController;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use View;

class ArtistController extends FrontEndController  {

    /**
     * Show the application dashboard to the user.
     *
     * @param Request $request
     * @param string $category
     * @param string $letter
     * @return Response
     */
	public function  index(Request $request , $category = '', $letter = ''){

        $filter = ["A", "B", "C", "D", "E", "F", "G", "H", "Y", "G", "K", "L", "M" ,"N", "O", "P", "Q", "S", "T", "U", "V", "W", "X", "Y" ,"Z"];
        $page = $request->input('page');
        $pageSize = 15;
        if(!$page) {
            $page = 0 * $pageSize;
        }else{
            $page = $page * $pageSize;
        }

        $query = Artist::join('music_category', 'music_category.id', '=', 'artist.music_category_id')
            ->join('artist_type', 'artist_type.id', '=', 'music_category.artist_type_id')
            ->select('artist.*')
            ->with('music_category.type')
            ->with('seo')
            ->with('avatar');

        $parameter = [];
        if(isset($letter) && $letter !== 'tat-ca'){
            $query->where('artist.last_name', 'like', DB::raw('CONCAT(LOWER(?), \'%\')'));
            array_push($parameter, $letter);
        }

        if(isset($category) && $category !== 'tat-ca'){
            $query->where(DB::raw('CONCAT(\',\', ?, \',\')'), 'like', DB::raw('CONCAT(\'%,\', artist_type.slug, \',%\')'));
            array_push($parameter, str_replace('_', ',',$category));
        }
        $query->inRandomOrder()
            ->offset($page)
            ->limit($pageSize);
        $query->setBindings($parameter);
        $artists = $query->get();

        $parameter = [];
        $queryTotal = Artist::join('music_category', 'music_category.id', '=', 'artist.music_category_id')
            ->join('artist_type', 'artist_type.id', '=', 'music_category.artist_type_id');
        if(isset($category) && $category !== 'tat-ca'){
            $queryTotal->where(DB::raw("CONCAT('%',?,'%')"),'LIKE',DB::raw("CONCAT('%',artist_type.slug,'%')"));
            array_push($parameter, str_replace('_', ',',$category));
        }
        $total = $queryTotal->setBindings($parameter)
            ->count();

        //$total = json_decode(json_encode($total), true);
        $totalPage = round(($total  - 1) / $pageSize);
		return view('frontend.pages.artists', compact('filter', 'artists', 'totalPage'));
	}

	public function detail($slug = ''){
        //get artist hot
        $detail = Artist::query()
            ->select('artist.*')
            ->with('music_category.type')
            ->with('seo')
            ->where('artist.slug', $slug)
            ->first();

        $image = $detail->files;

        return view('frontend.pages.artist', compact('detail', 'image'));
    }

}