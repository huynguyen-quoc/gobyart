<?php

namespace App\Http\Controllers\FrontEnd;

use App\Customer;
use App\Event;
use App\Artist;
use App\EventArtist;
use App\EventCustomer;
use Redirect;
use Validator;
use View;
use Gloudemans\Shoppingcart\Facades\Cart;
use DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;
use Exception;
use Carbon\Carbon;
use DateTime;


class WishListController extends FrontEndController  {

    public function index()
    {
        $arrayId = [];
        foreach (Cart::content() as $row) {
            array_push($arrayId, $row->id);
        }
        $listId = implode(",", $arrayId);
        $artists = Artist::query()
            ->select('artist.*')
            ->with('music_category.type')
            ->with('seo')
            ->with('avatar')
            ->where(DB::raw('CONCAT(\',\', ?, \',\')'), 'like', DB::raw('CONCAT(\'%,\', artist.artist_id, \',%\')'))
            ->setBindings([$listId])
            ->get();

        return View::make('frontend.pages.wishlist', [ 'artists' => $artists]);
    }


    public function add(Request $request){
        if (!$request->wantsJson()) {
            abort(400, 'Invalid Request');
        }
        $artistId = $request->input('artist_id');
        $name = $request->input('full_name');
        Cart::add([
            ['id' =>  $artistId, 'name' => $name, 'qty' => 1, 'price'=> 0]
        ]);
        return (new Response(['total_cart' => Cart::count()], 200));
    }

    public function remove(Request $request, $artistId = ''){
        if (!$request->wantsJson()) {
            abort(400, 'Invalid Request');
        }
        $id = '';
        foreach(Cart::content() as $row) {
            if($row->id == $artistId){
                $id = $row->rowId;
                break;
            }
        }
        if($id != '') {
            Cart::remove($id);
        }
        return (new Response(['total_cart' => Cart::count()], 200));
    }


    public function create(Request $request) {

        //Validate data
        $validator = Validator::make($request->all(), Event::$rules, Event::$messages);
//
//        //If everything is correct than run passes.
        if ($validator -> passes()) {

            if(count(Cart::content()) <= 0){
                return \Redirect::route('quan-tam')
                    ->with('errors',  ['Xin hãy chọn nghệ sĩ.'])->withInput();
            }
            Log::info('**************** INSERT WISH LIST  DATA ********************');
            Log::info($request->all());
            // $eventName =  \Input::
            DB::beginTransaction();

            try {
                $date = Carbon::createFromFormat('d/m/Y H:i A', $request->input('event_time'));
                $customer = Customer::create([
                    'customer_name' =>   $request->input('customer_name'),
                    'customer_phone' =>  $request->input('phone_number'),
                    'customer_email' =>$request->input('email_address')
                ]);
                $event = Event::create([
                    'event_id' =>  Uuid::generate(5,'artist'.microtime(true), Uuid::NS_DNS),
                    'event_name' =>   $request->input('event_name'),
                    'event_time' =>  $date,
                    'event_location' =>$request->input('event_location'),
                    'description' => $request->input('description'),
                    'customer_id'=> $customer->id,
                    'order' => DB::raw('(select ifnull(max(e.order), 0) + 1 from `event` as e)'),
                ]);


//                $eventCustomer = [
//                    'customer_id' => $customer->id,
//                    'event_id' => $event->id,
//                    'created_at' => new DateTime,
//                    'updated_at' => new DateTime
//                ];
//                DB::table('event_customer')->insert($eventCustomer);
//                $eventCustomer = EventCustomer::create([
//                    'customer_id' =>   $customer->id,
//                    'event_id' =>  $event->id
//                ]);

//                DB::statement("call SP_EVENTS_INSERT(?, ?, ?)" ,array( $data['event_name'], $data['event_time'], $data['extra_information']));
//                $eventId = DB::select('SELECT LAST_INSERT_ID() AS ID');
//                $id = reset($eventId)->ID;
//                DB::statement("call S_INSERT_CUSTOMER(?, ?, ?)" ,array( $data['customer_name'], $data['phone_number'], $data['email_address']));
//                $customerId = DB::select('SELECT LAST_INSERT_ID() AS ID');
//                $custId = reset($customerId)->ID;
//                DB::statement("call S_INSERT_EVENT_CUSTOMER(?, ?)" ,array($custId, $id));
                foreach (Cart::content() as $row) {
                    $artist = Artist::query()->where('artist_id', '=', $row->id)->first();
                    $artistEvent = [
                        'artist_id' => $artist->id,
                        'event_id' => $event->id,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime
                    ];
                    DB::table('event_artist')->insert($artistEvent);
//                    EventArtist::create([
//                       'artist_id' => $artist->id,
//                        'event_id' => $event->id
//                    ]);
                }
                DB::commit();
                Log::info(' INSERT SUCCESS WITH EVENT ID '.$event->event_id);
                Log::info('**************** END WISH LIST DATA ********************');
                Cart::destroy();

                return Redirect::route('quan-tam')->with('messages', 'CHÚC MỪNG QUÝ KHÁCH ĐÃ ĐĂNG KÝ THÀNH CÔNG. TIẾP TỤC KHÁM PHÁ THẾ GIỚI NGHỆ SĨ GOBY ART');

                // all good
            } catch (Exception $e) {
                DB::rollback();
                Log::error('[ERROR]'. $e);
                Log::info('**************** END WISH LIST DATA ********************');
                return Redirect::route('quan-tam')
                    ->with('errors', ['Có lỗi xảy ra vui lòng thử lại sau.'])->withInput();

            }
        }else{
            //return contact form with errors
            return Redirect::route('quan-tam')
                ->with('errors',  $validator->errors()->all())->withInput();

        }

    }

}
