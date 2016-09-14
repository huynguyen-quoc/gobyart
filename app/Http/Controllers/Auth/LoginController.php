<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ApplicationException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Lang as Lang;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\URL as URL;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/quan-tri/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $user = $this->guard()->user();
        $this->clearLoginAttempts($request);
        if ($request->ajax() || $request->wantsJson()) {
            return $this->authenticated($request, $user)
                ?: response([
                'intended' => $this->redirectPath()
            ], 200)->withCookie(cookie('api_token',$user->api_token, 0, null, null, false, false));
        };

        return $this->authenticated($request, $user)
            ?: redirect()->intended($this->redirectPath())->withCookie(cookie('api_token', $user->api_token, 0, null, null, false, false));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->api_token = str_random(60);
        $user->save();
    }



    protected function sendFailedLoginResponse(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
           throw new ApplicationException(401, Lang::get('auth.failed'), 'UNAUTHORIZED');
        }
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => Lang::get('auth.failed'),
            ]);
    }

    protected function sendLockoutResponse(Request $request)
    {

        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        if ($request->ajax() || $request->wantsJson()) {
            return response([
                'message' => $message
            ], 409);
        };

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([$this->username() => $message]);
    }

    public function logout(Request $request)
    {
        $user = $this->guard()->user();
        if($user) {
            $user->api_token = NULL;
            $user->save();
        }
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect(URL::route('auth.login'));
    }


    public function username(){
        return 'user_name';
    }
}
