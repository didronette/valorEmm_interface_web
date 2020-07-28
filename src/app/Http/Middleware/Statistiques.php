<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Statistiques
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
        if (Auth::check()) {
            if((auth()->user()->type == 'Gérant') || (auth()->user()->type == 'Administrateur') || (auth()->user()->type == 'Agglomération')){

                return $next($request);
                
            }
        }

            
            return redirect('login')->with('error','Vous n\'avez pas les droits pour réaliser cette action. Veuillez vous authentifier.');
    }
}
