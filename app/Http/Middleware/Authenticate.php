<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
// use App\Http\Middleware\Request;
// use Illuminate\Http\Request;
use Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        /*
            explination:
            law hwa authenticated w da5el awdeh fen
            admin awdeh fen
            user awdeh fen
        */
        if (! $request->expectsJson()) {

            if(Request::is('admin/*'))
                 return route('admin.get.login');
            // else
            //     return route('login');

            elseif(Request::is('supplier/*'))
                return route('supplier-login-form');
           else
               return route('login');
        }
    }
}
