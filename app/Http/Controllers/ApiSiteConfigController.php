<?php

namespace App\Http\Controllers;

use App\Exceptions\ApplicationException;
use App\SiteOption;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

class ApiSiteConfigController extends Controller
{
    public function store(Request $request){

        $requestData = $request->all();
        if(!$requestData){
            throw  new ApplicationException(400, 'Invalid Request','INVALID_REQUEST');
        }
        DB::beginTransaction();
        try {
            foreach ($requestData as $key => $data) {
                $option = SiteOption::query()->where('type', '=', $requestData['type'])->where('name', '=', strtoupper($key));
                if($option) {
                    $option->update(['value' => ($this->isHtml($data)) ? Purifier::clean($data) : $data] );
                }
            }
            DB::commit();
            return Response::create([], 200);
            // all good
        } catch (Exception $e) {
            DB::rollback();
            Log::error('[ERROR]'. $e);
            Log::info('**************** END WISH LIST DATA ********************');
            return Response::create([], 400);

        }
       // $option = SiteOption::query()->where('type','=','SITE');
        //$option->update($request->all());

    }

    public function update($type, Request $request){

        $requestData = $request->all();
        if(!$requestData){
            throw  new ApplicationException(400, 'Invalid Request','INVALID_REQUEST');
        }
        DB::beginTransaction();
        try {
            foreach ($requestData as $key => $data) {
                $option = SiteOption::query()->where('type', '=', strtoupper($type))->where('name', '=', strtoupper($key));
                if($option) {
                    $option->update(['value' => ($this->isHtml($data)) ? Purifier::clean($data) : $data ]);
                }
            }
            DB::commit();
            return Response::create([], 200);
            // all good
        } catch (Exception $e) {
            DB::rollback();
            Log::error('[ERROR]'. $e);
            Log::info('**************** END WISH LIST DATA ********************');
            return Response::create([], 400);

        }
        // $option = SiteOption::query()->where('type','=','SITE');
        //$option->update($request->all());

    }

    private function isHtml($string)
    {
        return preg_match("/<[^<]+>/",$string,$m) != 0;
    }
}
