<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Redirect;

class AdminCheck
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
        if (session('user')->type==2) {
            return $next($request);
        } else {
            // $user = DB::table('user')->where('id',1)->first();
            // session(['user'=>$user]);
            // return $next($request);
            // if ($request->ajax()) {
            return response("No authority.（没权限）", 403)->header("X-CSRF-TOKEN", csrf_token());
            // } else {
            //     return response("Unauthorized.（未登录）", 401)->header("X-CSRF-TOKEN", csrf_token());
            // }
        }
    }
}