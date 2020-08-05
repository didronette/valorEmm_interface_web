<?php

namespace App\Http\Middleware;

use Closure;
use \App\Repositories\DechetterieRepository;
use Auth;
use App\Dechetterie;



class Commandes
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
        if((Auth::check()) && ((auth()->user()->type == 'Administrateur') || (auth()->user()->type == 'Gérant'))){ // Inclure l'authentification par addrese mac
            if (session()->has('dechetterie')) {
                session()->forget('dechetterie');
            }
            return $next($request);
            
        }
        elseif (session()->has('dechetterie')) {
            if(Auth::check()) {
                Session::flush();
            }
            return $next($request);
        }
            
        return redirect('login')->with('error','Vous n\'avez pas les droits pour gérer les commandes. Veuillez vous authentifier.');
    }
}
