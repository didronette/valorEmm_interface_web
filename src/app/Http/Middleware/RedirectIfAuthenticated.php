<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if((auth()->user()->type == 'Administrateur')){

                return redirect('admin');
            }
            else if((auth()->user()->type == 'Gérant')){

                return redirect('saisie/commandes');
            }
            else if((auth()->user()->type == 'Agglomération')){

                return redirect('statistiques');
            }
            else if ((auth()->user()->type == 'Agent')) {
                Session::flush();
                return redirect('login')->with('error','Vous ne pouvez pas vous identifier en tant qu\'agent.');
            }
                
        
        }

        return $next($request);
    }
}
