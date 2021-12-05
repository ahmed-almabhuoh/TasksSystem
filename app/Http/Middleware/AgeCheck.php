<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $age)
    {
        // $age = 17;
        if ($age < 18) {
            // dd("NOT ALLOW TO BE HERE");
            abort(Response::HTTP_UNAUTHORIZED);
        }else {
            // abort(Response::HTTP_OK);
            dd("VERY WELCOME TO YOU");
        }
        return $next($request);
    }
}
