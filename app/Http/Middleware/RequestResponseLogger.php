<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
class RequestResponseLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info($request->all());
        return $next($request);
    }

    public function terminate($request, $response)
    {
        Log::info('requests', [
            'request' => $request->all(),
            'response' => $response
        ]);
        Log::info('****************************** DONE ******************************');
    }
}
