<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Log;
use Redirect;

class LoginCheck
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
        if (get_session_user_id()) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                return response("Unauthorized.（未登录）", 401)->header("X-CSRF-TOKEN", csrf_token());
            } else {
                return 401;
            }
        }
    }
}