<?php

namespace App\Http\Controllers;

use App\Artist;
use App\ArtistType;
use App\MusicCategory;
use App\SeoOption;
use App\SiteOption;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid as UUID;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Logic\Image\ImageRepository as ImageRepository;
use App\Image;
use Carbon\Carbon;
use DateTime;
use App\File;
class ArtistController extends Controller
{

    protected $image;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->middleware('auth.custom');
        $this->image = $imageRepository;
    }

    public function index(Request $request){

        $artists = Artist::with('music_category.type')
            ->with('avatar')
            ->orderBy('created_at', 'DESC')
            ->paginate(30);

        $paging_numbers = [];
        if($artists) {
            $paging_numbers = range(1, $artists->lastPage());
            $paging_numbers = array_slice($paging_numbers, max(0, min(count($paging_numbers) - 5, intval($artists->currentPage()) - ceil(5 / 2))), 5);
        }

        if ($request->ajax()) {
            return response(compact('artists', 'paging_numbers'), 200);
        }

        return view('artist.index', compact('artists', 'paging_numbers'));
    }

    public function detailNew(){
        $artistTypes = ArtistType::all();

        $musicCategories = MusicCategory::with('type')->get();

        $artistOptions = SiteOption::where('type','=','ARTIST_OPTIONS')->get();

        return view('artist.detail', compact('artistTypes', 'musicCategories', 'artistOptions'));
    }

    public function detailEdit($artistId, Request $request){
        $artistTypes = ArtistType::all();
        $artist = Artist::where('artist_id', '=', $artistId)->with('music_category.type')->with('seo')->first();
        $musicCategories = MusicCategory::with('type')->get();
        $files =$artist->files;
        $edit = true;
        $artistOptions = SiteOption::where('type','=','ARTIST_OPTIONS')->get();
        return view('artist.detail', compact('artistTypes', 'artist', 'edit', 'musicCategories', 'files','artistOptions'));
    }

    public function create(Request $request){
        $form_data = $request->all();

        $validator = Validator::make($form_data, Artist::$rules, Artist::$messages);
        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }
        $date = Carbon::createFromFormat('d/m/Y', $form_data['date_of_birth']);
        $form_data['date_of_birth'] = $date;
        DB::beginTransaction();
        $artist = new Artist($form_data);
        try {
            $seoOption = new SeoOption($form_data);
            $seoOption->seo_id =  Uuid::generate(5,'seo_id_artist'.microtime(true), Uuid::NS_DNS);
            $seoOption->save();
            $response = $this->image->upload($form_data, null, true);
            $artist->artist_id = Uuid::generate(5,'artist_team'.microtime(true), Uuid::NS_DNS);
            $musicCategory = MusicCategory::where('category_id', '=', $form_data['music_category_id'])->first();
            $artist->music_category_id = $musicCategory->id;
            $image = Image::where('file_id','=', $response->getData()->image->file_id)->first();
            $artist->avatar_id = $image->id;
            $artist->seo_id = $seoOption->id;
            $artist->save();
            $images = explode(',', $form_data['file_images']);
            if($images) {
                $filesArtists = [];
                foreach ($images as $image){
                    $imageData = Image::where('file_id','=', $image)->first();
                    if($imageData){
                        $filesArtists[] = [
                           'file_id' => $imageData->id,
                           'artist_id' => $artist->id,
                           'created_at' => new DateTime,
                           'updated_at' => new DateTime
                        ];
                    }
                }
                DB::table('artist_file')->insert($filesArtists);
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            Log::error($e);
            throw new ApplicationException(500, 'Server error while insert');
        }

        return response($artist, 200);
    }

    public function update($artistId, Request $request){
        $form_data = $request->all();
        $artist = Artist::where('artist_id', '=', $artistId)->first();
        $validator = Validator::make($form_data,[
            'first_name' => 'required',
            'last_name' => 'required',
            'full_name' => 'required',
            'date_of_birth' => 'required|date_format:d/m/Y'
        ], Artist::$messages);

        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }
        DB::beginTransaction();
        try {
            if (isset($form_data['file'])) {
                $file = File::find($artist->avatar_id);
                $deleted = $this->image->delete($file->file_id);
                $response = $this->image->upload($form_data, null, true);
                $image = Image::where('file_id', '=', $response->getData()->image->file_id)->first();
                $artist->avatar_id = $image->id;
            }
            $artist->first_name = $form_data['first_name'];
            $artist->last_name = $form_data['last_name'];
            $artist->full_name = $form_data['full_name'];
            $date = Carbon::createFromFormat('d/m/Y', $form_data['date_of_birth']);
            $form_data['date_of_birth'] = $date;
            $artist->date_of_birth = $form_data['date_of_birth'];
            $artist->extra_information = $form_data['extra_information'];
            $musicCategory = MusicCategory::where('category_id', '=', $form_data['music_category_id'])->first();
            $artist->music_category_id = $musicCategory->id;
            $images = explode(',', $form_data['file_images']);
            if($images) {
                $filesArtists = [];
                foreach ($images as $image){
                    $imageData = Image::where('file_id','=', $image)->first();
                    if($imageData){
                        $filesArtists[] = [
                            'file_id' => $imageData->id,
                            'artist_id' => $artist->id,
                            'created_at' => new DateTime,
                            'updated_at' => new DateTime
                        ];
                    }
                }
                DB::table('artist_file')->insert($filesArtists);
            }

            $seo = SeoOption::find($artist->seo_id);
            $seo->meta = $form_data['meta'];
            $seo->keywords = $form_data['keywords'];
            $seo->save();

            $artist->save();
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            Log::error($e);
            throw new ApplicationException(500, 'Server error while update');
        }

        return response($artist, 200);

    }


    public function upload(Request $request){
        $image = $request->all();
//        $group = Group::where('type', '=','GALLERY_TYPE')->first();
//        $id = ($group) ? $group->id : NULL;
        DB::beginTransaction();
        try {
            $response = $this->image->upload($image, NULL);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            Log::error($e);
            throw new ApplicationException(500, 'Server error while uploading');
        }
        return $response;

    }
}
