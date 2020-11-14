<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ApiGeneralTrait;

class CheckUserToken
{
    use ApiGeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('E3001','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('E3002','EXPIRED_TOKEN');
            } else {
                return $this -> returnError('E3003','TOKEN_NOTFOUND');
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('E3001','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('E3002','EXPIRED_TOKEN');
            } else {
                return $this -> returnError('E3003','TOKEN_NOTFOUND');
            }
        }

        if (!$user)
        $this -> returnError('E3333','Unauthenticated');
        return $next($request);
    }
}
