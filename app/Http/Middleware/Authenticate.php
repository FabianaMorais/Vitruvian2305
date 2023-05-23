<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{

    /**
     * OVERRIDE
     * Overriding handle function to feed default guards
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (empty($guards)) { // feeding default guards
            $guards = array('web', 'new_reg');
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

}
