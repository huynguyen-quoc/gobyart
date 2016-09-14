<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Logic\Image\ImageRepository as ImageRepository;
use App\Http\Requests;
use DB;
class GalleryController extends Controller
{

    protected $image;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->middleware('auth.custom');
        $this->image = $imageRepository;
    }

    public function index(Request $request){
        $group = Group::where('type', 'GALLERY_TYPE')->first();

        $files = ($group) ? $group->files()->orderBy('created_at','DESC')->with('seo')->paginate(20) : NULL;
        $paging_numbers = [];
        if($files) {
            $paging_numbers = range(1, $files->lastPage());
            $paging_numbers = array_slice($paging_numbers, max(0, min(count($paging_numbers) - 5, intval($files->currentPage()) - ceil(5 / 2))), 5);
        }


        if ($request->ajax()) {
            return response(compact('files', 'paging_numbers'), 200);
        }

        return view('gallery.index', compact('files', 'paging_numbers'));
    }

    public function upload(Request $request){
        $image = $request->all();
        $group = Group::where('type', '=','GALLERY_TYPE')->first();
        $id = ($group) ? $group->id : NULL;
        DB::beginTransaction();
        try {
            $response = $this->image->upload($image, $id);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            Log::error($e);
            throw new ApplicationException(500, 'Server error while uploading');
        }
        return $response;

    }

    public function delete($fileId, Request $request){
        $response = $this->image->delete($fileId);
        return $response;

    }
}
