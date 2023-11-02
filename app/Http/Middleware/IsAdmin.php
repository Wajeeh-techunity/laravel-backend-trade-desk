<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
class IsAdmin
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
        if(auth()->check()){
            if(auth()->user()->is_admin == 1)
            {
                if(auth()->user()->role_id == 1)
                {
                    return $next($request);
                }
                else {
//                    dd(Route::currentRouteName());
                    if(Route::currentRouteName() == 'admin.dashboard')
                    {
                        return $next($request);
                    }
                    else{
                        $user_permissions = [];
                        if(isset(auth()->user()->permissions))
                        {
                            $user_permissions = json_decode(auth()->user()->permissions);
                        }

                        if(!empty($user_permissions) && in_array(Route::currentRouteName(), $user_permissions)){
                            return $next($request);
                        }
                        else{
                            return back()->with('error',"access denied!");
                        }
                    }

                }

            }
            else{
                return back()->with('error',"Only admin have access!");
            }

        }
        else{
            return redirect()->route('admin.login');
        }

    }
}
