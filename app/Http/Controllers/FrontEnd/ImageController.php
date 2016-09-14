<?php

namespace App\Http\Controllers\FrontEnd;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;
use DB;

class ImageController extends FrontEndController
{
    public function getImagePreview($artistId, Request $request){
       // $headers = $request->header('content-type');
        if (!$request->wantsJson() || empty($artistId)) {
            abort(400, 'Invalid Request');
        }
//        //get artist hot
//        $images = DB::select('call SP_GET_IMAGE_PREVIEW(?);', array($slug));
//
//        $images = json_decode(json_encode($images), true);
        $images = Image::join('artist_file', 'artist_file.file_id','file.id')
            ->select('file.*')
            ->join('artist', 'artist_file.artist_id', 'artist.id')
            ->where('artist.artist_id', '=', $artistId)
            ->limit(4)
            ->inRandomOrder()
            ->get();
        return (new Response($images, 200));
    }

}
