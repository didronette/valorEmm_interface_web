<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Gerant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if((Auth::check()) && ((auth()->user()->type == 'Administrateur') || (auth()->user()->type == 'Gérant'))){ 
            return $next($request);
            
        }
            
        return back();
    }
}
