<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use League\Flysystem\Exception;
use Log;
use Excel;
use Google_Service_Drive_Permission;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive;
use App\Event;
use Google;
use Carbon\Carbon;
class SendDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:drive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('************** EXPORT CSV GOOGLE DRIVE FILE ******************** ');
        $count =  Event::where('status','=', 0)->count();
        Log::info('[ EVENTS COUNT :'.$count.' ]');
        if($count <= 0) return false;
        $events =  Event::where('status','=', 0)->get();
        $fileName = date('mdY');
        Log::info('[ EXPORT FILE START '.$fileName.']');
        Excel::create($fileName, function ($excel) {
            $sheetName = date('mdY');

            $excel->sheet($sheetName, function ($sheet) {
                $events =  Event::where('event.created_at','>=', DB::raw('NOW() - INTERVAL 1 DAY'))
                    ->with('customer')->get();

                //$events = DB::select("call S_SELECT_EVENT_EXPORT_ALL_DAY()");

                $eventData = [];
                foreach ($events as $event) {
                    $eventDataColumn = array(
                        $event->event_name,
                        $event->event_date,
                        $event->event_time,
                        $event->customer->customer_name,
                        $event->customer->customer_phone,
                        $event->customer->customer_email,
                        $event->description);

                    $artists = $event->artists;
                    Log::info($artists);
                    $index = 0;
                    foreach ($artists as $artist) {
                        $dataString = '';
                        if ($index == 0) {
                            $index++;
                        } else {
                            $eventDataColumn = array('', '', '', '', '', '', '');
                        }
                        $dataString .= $artist->full_name . '|';
                        $dataString .= $artist->date_of_birth->format('d/m/Y'). "|";
                        $dataString .= $artist->music_category->type->name.'('.$artist->music_category->name.')';

                        array_push($eventDataColumn, $dataString);
                        array_push($eventData, $eventDataColumn);
                    }
                }
                Log::info($eventData);
                $sheet->fromArray($eventData);

            });
        })->store('csv', storage_path('exports'));

        Log::info('[ EXPORT FILE '.$fileName.' END ]');
        Log::info('[ QUERY FILE  GOOGLE DRIVE ]');
        $googleClient = Google::getClient();
        $googleClient->setScopes(Google_Service_Drive::DRIVE);
        // $client = new Client($googleClient->getConfig());
        $storageService = new Google_Service_Drive($googleClient);
        $fileResult = $storageService->files->listFiles(array(
            'q' => "name='".$fileName."'",
            'fields' => 'nextPageToken, files(id, name)',
        ));
        Log::info('[ QUERY FILE  GOOGLE DRIVE COUNT : '.count($fileResult->files).']');
        $fileId = -1;
        if(count($fileResult->files) > 0){
            $file = $fileResult->files[0];
            $fileId = $file->id;
            $fileMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => $fileName,
                'mimeType' => 'application/vnd.google-apps.spreadsheet'));
            $content = file_get_contents(storage_path('exports') . '/' . $fileName . '.csv');
            $file = $storageService->files->update($fileId, $fileMetadata, array(
                'data' => $content,
                'mimeType' => 'text/csv',
                'uploadType' => 'multipart',
                'fields' => 'id'));
            $fileId = $file->id;
        }else {
            $fileMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => $fileName,
                'mimeType' => 'application/vnd.google-apps.spreadsheet'));
            $content = file_get_contents(storage_path('exports') . '/' . $fileName . '.csv');
            $file = $storageService->files->create($fileMetadata, array(
                'data' => $content,
                'mimeType' => 'text/csv',
                'uploadType' => 'multipart',
                'fields' => 'id'));
            $fileId = $file->id;
        }
        Log::info('[ SHARE PERMISSION GOOGLE DRIVE TO EMAIL ('.env('EMAIL_SHARING_NAME','nerorain1102@gmail.com').')]');
        $googleClient->setUseBatch(true);
        try {
            $batch = $storageService->createBatch();
            $userPermission = new Google_Service_Drive_Permission(array(
                'type' => 'user',
                'role' => 'reader',
                'emailAddress' => env('EMAIL_SHARING_NAME','nerorain1102@gmail.com')
            ));
            $request = $storageService->permissions->create(
                $fileId, $userPermission, array('fields' => 'id'));
            $batch->add($request, 'user');
            $results = $batch->execute();
            Log::info($results);
            foreach ($results as $result) {
                if ($result instanceof \Google_Service_Exception) {
                    Log::error('[ SHARE PERMISSION ERROR ]');
                    Log::error("ERROR : ".$result);
                    Log::error('[ SHARE PERMISSION ERROR ]');
                } else {
                    Log::info('[ SHARE PERMISSION SUCCESS ]');
                    Log::info("Permission ID: ".$result->id);
                    Log::info('[ SHARE PERMISSION SUCCESS ]');
                }
            }
            Log::info('[ UPDATE STATUS EVENT TO SHARED ]');
            Log::info($events);
            foreach ($events as $event){
                DB::beginTransaction();
                try {
                    $event->status = 1;
                    $event->save();
                    DB::commit();
                } catch (\Exception $e) {
                    Log::error('[ UPDATE STATUS EVENT TO SHARED ERROR ]');
                    Log::error($e);
                    Log::error('[ UPDATE STATUS EVENT TO SHARED ERROR ]');
                    DB::rollback();
                }
            }
            Log::info('[ UPDATE STATUS EVENT TO SHARED ]');
        }catch(\Exception $e) {
            Log::error('[ ERROR ]');
            Log::error($e);
            Log::error('[ ERROR ]');
        } finally {
            $googleClient->setUseBatch(false);
        }
        Log::info('************** END CSV GOOGLE DRIVE FILE ******************** ');

    }
}
