<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Users\User;
use App\Models\PublicApiKey;

class PublicApiAccess
{
    /**
     * Checks public api credentials and adds the current User model
     * to the Request so it can be used in the controllers
     *
     * @return Request with API user as apiUser, accessible by: $request->apiUser
     */
    public function handle($request, Closure $next)
    {
        // Missing parameters
        if ($request->header('key') == NULL || $request->header('username') == NULL) {
            abort(422);
        }

        $key = PublicApiKey::where('key', $request->header('key'))->get()->first();

        // Credentials mismatch
        if (!isset($key) || !isset($key->user) || $key->user->name != $request->header('username')) {
            abort(401);
        }

        // Researchers only
        if (!$key->user->isType(User::RESEARCHER)) {
            abort(401);
        }

        // Passing the found user to the request object
        $request->merge(['apiUser' => $key->user]);

        return $next($request);
    }

}
