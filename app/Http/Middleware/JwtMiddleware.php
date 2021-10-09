<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch(Exception $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(["msg"=>"Invalid token"]);
            }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(["msg"=>"Expired token"]);
            }else{
                return response()->json(["msg"=>"token not found"]);
            }
        }
        return $next($request);
    }
}
