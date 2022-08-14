<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // shu joyga userga nimadir qo'shsa bo'ladi productga dostupni hozircha faqat id 1 ga teng bulgani ishledi
        if(auth('api')->check() and auth('api')->user()->id  == 1){
            return response()->json(["status"=>0],Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
