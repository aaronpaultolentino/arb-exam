<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use ARB\RolesAndPermission\RolesAndPermissionManager;

class Permission extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next, $action)
    {
        if(RolesAndPermissionManager::hasAccess(auth()->user(), $action)) {
            return $next($request);
        }

        abort(404);
    }
}
