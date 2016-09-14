<?php

namespace App\Http\Controllers;

use App\ArtistType;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid as Uuid;
use DB;
use DateTime;

class ApiArtistTypeController extends Controller
{
    private $rules = [
        'name' => ['required'],
    ];

    public function __construct()
    {
        $this->middleware('auth.custom:api');
    }

    public function index(Request $request){
        $artistType = ArtistType::paginate(20);
        return response($artistType, 200);

    }

    public function store(Request $request){

        $this->validate($request, $this->rules);

        $data = $request->all();

        $artistData = [
            'type_id' => Uuid::generate(5,'artist_type'.microtime(true), Uuid::NS_DNS),
            'name' => $data['name'],
            'slug' => str_slug($data['name'], '-'),
            'order' =>  DB::raw('(select ifnull(max(at.order), 0) + 1 from `artist_type` as at)'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ];

        $data = ArtistType::create($artistData);
        $data = ArtistType::find($data->id);
        return response($data, 200);


    }

    public function update($id, Request $request){

        $this->validate($request, $this->rules);

        $data = $request->all();
        $artistType = ArtistType::query()->where('type_id','=', $id)->get()->first();
        $artistType->update($data);
        $data = ArtistType::find($artistType->id);
        return response($data, 200);


    }

    public function destroy($id, Request $request){

        //$this->validate($request, $this->rules);

        $data = $request->all();
        $artistType = ArtistType::query()->where('type_id','=', $id)->get()->first();
        $artistType->delete();
        return response([], 200);


    }
}
