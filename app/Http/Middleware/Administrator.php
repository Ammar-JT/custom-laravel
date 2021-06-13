<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Administrator
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

        if(auth()->check()){
            if(in_array(auth()->user()->email, config('app.administrators'))){
                dd('you are admin!');
                return $next($request);
            }
        }

        dd('you donnot have acces!');

        return redirect()->back();
        
        
    }
}
