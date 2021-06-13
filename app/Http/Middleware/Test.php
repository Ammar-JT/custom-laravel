<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Test
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
        session()->flash('test', 'test key from test middleware');

        //after making your middleware (نقطة تفتيش) you have to make the request continue: 
        return $next($request);
    }
}
