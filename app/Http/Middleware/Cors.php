<?php

namespace App\Http\Middleware;

use Closure;

use Response;

class Cors
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

        // echo 111;
        // var_dump($request->ajax());
        // $request->header('Access-Control-Allow-Origin', env('RequestHttp', 'localhost:8080'));
        // $request->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
        // $request->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        // $request->header('Access-Control-Allow-Credentials', 'true');

        $response = $next($request);

        $response->header('Access-Control-Allow-Origin', 'http://localhost:8081');
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        $response->header('Access-Control-Allow-Credentials', 'true');

        return $response;
        // return $next($request);
    }
}
