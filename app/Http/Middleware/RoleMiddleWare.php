<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next,...$role)
    {
       
        $user_role = Auth::User()->role;
        if(in_array($user_role, $role))
        {
          return $next($request);
        }
        abort(403);
    }

}
