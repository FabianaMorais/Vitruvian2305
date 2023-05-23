<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use App\Providers\RouteServiceProvider;

class UserAccess
{
    /**
     * Checking user type against legal access types
     * 
     * @param access can be single string or array with the following types:
     *      pro: All Professional types (no admins)
     *      res: Researchers
     *      doc: Medical Professionals (Doctors)
     *      care: Caregivers
     *      admin: Administrators
     */
    public function handle($request, Closure $next, ...$access)
    {

       if (empty($guards)) { // feeding default guards
            $guards = array('web', 'new_reg');
        }

        foreach($guards as $g) {
            if (Auth::guard($g)->check()) { // Once we authenticate the user
                if (Auth::user() != null) {
                    $user = Auth::user(); // We retrieve it
                }
            }
        }

        // If we found a user which matches a guard
        if (isset($user)) {

            // we always process access as an array, so we have to convert single elements
            if (!is_array($access)) {
                $a = $access;
                $access = array($a);
            }

            // We can pass an array of access types to this controller
            foreach($access as $type) {

                switch($type) {
                    case("pro"): // All Professional types (no admins)
                        if ($user->isProfessional()) { return $next($request); }
                        break;

                    case("res"): // Researchers
                        if ($user->isType(User::RESEARCHER)) { return $next($request); }
                        break;

                    case("doc"): // Medical Professionals (Doctors)
                        if ($user->isType(User::DOCTOR)) { return $next($request); }
                        break;

                    case("care"): // Caregivers
                        if ($user->isType(User::CAREGIVER)) { return $next($request); }
                        break;

                    case("admin"): // Administrators
                        if ($user->isType(User::ADMIN)) { return $next($request); }
                        break;

                    case("org"): // Organizations
                        if ($user->isType(User::ORGANIZATION)) { return $next($request); }
                        break;

                }
            }

        }

        // If conditions are not met, we send the user back to his home
        return redirect(RouteServiceProvider::HOME);
    }
}
