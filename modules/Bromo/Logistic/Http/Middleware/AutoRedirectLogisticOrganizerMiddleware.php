<?php

namespace Bromo\Logistic\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Route;
use Auth;

class AutoRedirectLogisticOrganizerMiddleware
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
        \Log::info("AutoRedirectLogisticOrganizerMiddleware middleware");

        if(!Auth::guest()) {
            $user = Auth::user();
            $role_id = $user->role_id;

            // TODO Should use role_name instead of role_id
            if ( $role_id == 8 ) {
                $current_route = Route::currentRouteName();

                if(!startsWith($current_route,'logistic') && $current_route != 'logout' && $current_route != 'update-password') {
                    return redirect( route('logistic.mobile-index'));
                }
            }
        }
        

        return $next($request);
    }
}
