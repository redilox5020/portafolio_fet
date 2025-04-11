<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RoutePermission;

class CheckRoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();

        if ($route->getName()) {
            $routePermission = RoutePermission::where('route_name', $route->getName())->first();

            if ($routePermission && $routePermission->permission_name) {
                if (!auth()->user()->can($routePermission->permission_name)) {
                    abort(403);
                }
            }
        }

        return $next($request);
    }
}
