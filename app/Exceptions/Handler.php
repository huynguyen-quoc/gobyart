<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException as AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException as AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException as HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Session\TokenMismatchException as TokenMismatchException;
use Illuminate\Session\ValidationException as ValidationException;
use Illuminate\Support\Facades\Log as Log;
use Illuminate\Database\QueryException as QueryException;
use App\Exceptions\ApplicationException as ApplicationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = array(
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
        QueryException::class
    );

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Exception $e
     * @return \Illuminate\Http\Response
     * @internal param Exception $exception
     */
    public function render($request, Exception $e)
    {

        $response = [
            'code' => $e->getCode(),
            'error' => true,
            'message' => $e->getMessage()
        ];

        if (config('app.debug'))
        {
            $response['exception'] = get_class($e);
            $response['message'] = $e->getMessage();
        }
        // Default response of 400
        $status = 400;

        switch ($e){
            case ($e instanceof ApplicationException):
                $status = $e->getCode();
                // do nothing
                break;
            case ($e instanceof AuthenticationException):
                return $this->unauthenticated($request, $e);
                // do nothing
                break;
            case ($e instanceof HttpException):
                $status = $e->getStatusCode();
                break;
            default:
                Log::error($e);
                break;
        }
//        $response['code'] = $status;
//        Log::info('[ RESPONSE ] '. $status);
//        Log::info('[ RESPONSE BODY ] ', $response);



        if ($request->expectsJson())
        {
            return response()->json($response, $status);
        }else{
            return parent::render($request, $e);
        }

    }


    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
