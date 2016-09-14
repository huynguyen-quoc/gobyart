<?php

namespace App\Http\Controllers\FrontEnd;

use App\Contact;
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

class ContactController extends FrontEndController {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('frontend.pages.contact');
	}

    /**
     * Show the application dashboard to the user.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $rules = array(
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'contact_email' => 'required|email',
            'contact_title' => 'required',
            'contact_content'=> 'required'
        );

        //Validate data
        $validator = Validator::make($request->all(), $rules);

        //If everything is correct than run passes.
        if ($validator -> passes()) {
            Log::info('**************** INSERT CONTACT  DATA ********************');
            Log::info($request->all());
            // $eventName =  \Input::
            DB::beginTransaction();

            try {

                $contact = Contact::create([
                    'contact_id' =>  Uuid::generate(5,'contact_data'.microtime(true), Uuid::NS_DNS),
                    'contact_name' =>   $request->input('contact_name'),
                    'contact_phone' =>  $request->input('contact_phone'),
                    'contact_email' =>$request->input('contact_email'),
                    'contact_title' => $request->input('contact_title'),
                    'contact_content' => $request->input('contact_content')
                ]);

                DB::commit();
                Log::info(' INSERT SUCCESS WITH CONTACT ID '.$contact->contact_id);
                Log::info('**************** END CONTACT DATA ********************');
                Cart::destroy();

                return Redirect::route('lien-he')->with('messages', 'THÔNG TIN LIÊN HỆ CỦA BẠN ĐÃ ĐƯỢC GHI NHẬN CHÚNG TÔI SẼ LIÊN HỆ VỚI BẠN SỚM NHẤT CÓ THỂ.');

                // all good
            } catch (Exception $e) {
                DB::rollback();
                Log::error('[ERROR]'. $e);
                Log::info('**************** END WISH LIST DATA ********************');
                return Redirect::route('lien-he')
                    ->with('errors', ['Có lỗi xảy ra vui lòng thử lại sau.'])->withInput();

            }
        }else{
            //return contact form with errors
            return Redirect::route('lien-he')
                ->with('errors',  $validator->errors()->all())->withInput();

        }
    }


}