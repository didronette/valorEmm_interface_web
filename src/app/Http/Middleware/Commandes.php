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
            return $next($request);
            
        }
        elseif (session()->has('dechetterie')) {
            if(Auth::check()) {
                Session::flush();
            }
            return $next($request);
        }
        else {
            $MAC = exec('getmac'); 
  
            // Storing 'getmac' value in $MAC 
            $MAC = strtok($MAC, ' '); 
            $dechetteries = Dechetterie::all();
            
            foreach ($dechetteries as $dechetterie) {
                if ($dechetterie->adresse_mac == $MAC) {
                    session()->put(['dechetterie' => $dechetterie->id]);
                    return $next($request);
                }
            }
        }
            
        return redirect('login')->with('error','Vous n\'avez pas les droits pour gérer les commandes. Veuillez vous authentifier.');
    }
}
