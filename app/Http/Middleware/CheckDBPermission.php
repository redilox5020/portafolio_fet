<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RoutePermission;
use Illuminate\Support\Facades\Gate;
class CheckDBPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();

        if (!$route->getName()){
            return $next($request);
        }

        $hasExplicitCan = collect($route->gatherMiddleware())->contains(
            fn($m) => str_starts_with($m, 'can:')
        );

        if (!$hasExplicitCan) {
            $permission = RoutePermission::where('route_name', $route->getName())->value('permission_name');

            if ($permission && !auth()->user()->can($permission)) {
                abort(403);
            }
        }


        return $next($request);
    }
}
