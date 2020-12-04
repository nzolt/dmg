<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class isAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authorized = false;

        if(isset(getallheaders()['X-Api-Key'])) {
            $apiKey = getallheaders()['X-Api-Key'];

            if ($apiKey) {
                $routeFull = explode('/', Request::capture()->getRequestUri());
                $route = $routeFull[1];
                $generic = config('api.generic');
                $rest = config('api.generic');
                $rpc = config('api.rpc');

                $restKeys = array_merge($rest, $generic);
                $rpcKeys = array_merge($rpc, $generic);

                if ($route == 'rpc') {
                    if (in_array($apiKey, $rpcKeys)) {
                        $authorized = true;
                    }
                } elseif ($route == 'api') {
                    if (in_array($apiKey, $restKeys)) {
                        $authorized = true;
                    }
                }
                if ($authorized) {
                    return $next($request);
                }
            }
        }

        return response()->json(['status' => false,'error' => "Unauthorized"], 401);
    }
}
