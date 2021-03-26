<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ApiGeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use ApiGeneralTrait;
   /**
    * Undocumented function
    *
    * @param [type] $request
    * @param Closure $next
    * @return void
    */
    public function handle($request, Closure $next)
    {
        $admin = null;
        try {
            $admin = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('E3001','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('E3001','EXPIRED_TOKEN');
            } else {
                return $this -> returnError('E3001','TOKEN_NOTFOUND');
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('E3001','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('E3001','EXPIRED_TOKEN');
            } else {
                return $this -> returnError('E3001','TOKEN_NOTFOUND');
            }
        }

        if (!$admin)
        $this -> returnError(404, 'Unauthenticated');
        return $next($request);
    }
}
