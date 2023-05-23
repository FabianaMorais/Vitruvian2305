<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class OrgRequired
{
    /**
     * This middleware only lets Organizations or Professionals WITH organziations pass
     * Any other user, including professionals without organizations shalt not pass
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( Auth::user()->isOrganization() ) {
            return $next($request);

        } else if ( Auth::user()->isProfessional() && isset(Auth::user()->getRoleData()->organization) ) {
            return $next($request);
        }

        // If conditions are not met, we send the user back to his home
        return redirect(RouteServiceProvider::HOME);
    }
}
