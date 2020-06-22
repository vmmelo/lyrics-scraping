<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoggedUserApi
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
        $user = auth('api')->setRequest($request)->user();

        if(!$user){
            return response()->json(['Credencial incorreta.'], 401);
        }

        return $next($request);
    }
}
