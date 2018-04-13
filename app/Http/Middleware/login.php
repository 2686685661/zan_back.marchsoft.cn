<?php

namespace App\Http\Middleware;

use Closure;

class login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd(emptyId($request->input('code')));
//        dd(empty($request->input('code')));

            if (emptyId($request->input('code')) == 1) {
                return $next($request);
            } else {
               return redirect('/login');
            }


    }
}
