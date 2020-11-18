<?php

namespace App\Http\Middleware;

use App\Helpers\ApiGeneralTrait;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Request;

class Authenticate extends Middleware
{
    use ApiGeneralTrait;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(Request::is('api/*'))
            return route('login');
            else
            return route('login');
        }
    }
}
