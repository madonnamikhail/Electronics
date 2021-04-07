<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //law hwa login w zar al route bta3 al login hyro7 fen
        //ba3d lma 23mel al tinker w 23mel login agrab 23mel login w aktb f al url al /admin/login hla2eh mra7sh lel form w fdel
        // f al dashboard l2en maynf3sh ykon 3mel login w yro7 lel form tany 
        if (Auth::guard($guard)->check()) {
            if($guard=='admin')
                 return redirect(RouteServiceProvider::DASHBOARD);
            else
                return redirect(RouteServiceProvider::ADMINLOGIN);

            if($guard=='supplier')
                return redirect(RouteServiceProvider::SUPPLIERDASHBOARD);
            else
               return redirect(RouteServiceProvider::SUPPLIERLOGIN);
        }

        return $next($request);
    }
}
