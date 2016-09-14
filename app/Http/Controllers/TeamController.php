<?php

namespace App\Http\Controllers;

use App\File;
use App\Team;
use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Logic\Image\ImageRepository as ImageRepository;
use Webpatser\Uuid\Uuid as UUID;
use App\Image;
use DB;
class TeamController extends Controller
{
    protected $image;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->middleware('auth.custom');
        $this->image = $imageRepository;
    }

    public function index(){
        $teams = Team::with('avatar')->paginate(30);
        return view('team.index', compact('teams'));
    }

    public function detailNew(){
        return view('team.detail');
    }

    public function detailEdit($teamId, Request $request){
        $team = Team::where('team_id', '=', $teamId)->first();
        $edit = true;
        return view('team.detail', compact('team', 'edit'));
    }


    public function create(Request $request){
        $form_data = $request->all();
        $validator = Validator::make($form_data, Team::$rules, Team::$messages);
        if ($validator->fails()) {
            return response([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }
        DB::beginTransaction();
        try {
            $response = $this->image->upload($form_data, null, true);
            $team = new Team($request->all());
            $team->team_id = Uuid::generate(5,'team_id'.microtime(true), Uuid::NS_DNS);
            $image = Image::where('file_id','=', $response->getData()->image->file_id)->first();
            $team->avatar_id = $image->id;
            $team->save();
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            Log::error($e);
            throw new ApplicationException(500, 'Server error while insert');
        }

        return response($team, 200);
    }

    public function update($teamId, Request $request){
        $form_data = $request->all();
        $team = Team::where('team_id', '=', $teamId)->first();
        $validator = Validator::make($form_data,[
            'name' => 'required',
            'career' => 'required',
        ], Team::$messages);

        if ($validator->fails()) {
            return response([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }
        DB::beginTransaction();
        try {
            if (isset($form_data['file'])) {
                $response = $this->image->upload($form_data, null, true);
                $file = File::find($team->avatar_id);
                $file->delete();
                $image = Image::where('file_id', '=', $response->getData()->image->file_id)->first();
                $team->avatar_id = $image->id;
            }
            $team->name = $form_data['name'];
            $team->career = $form_data['career'];
            $team->save();
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            Log::error($e);
            throw new ApplicationException(500, 'Server error while update');
        }

        return response($team, 200);
    }

    public function delete($teamId, Request $request){
        $team = Team::where('team_id', '=', $teamId)->first();

        DB::beginTransaction();
        try {
            $team->delete();
            $file = Image::find($team->avatar_id);
            $this->image->delete($file->file_id);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            Log::error($e);
            throw new ApplicationException(500, 'Server error while delete');
        }

        return response($team, 200);
    }
}
