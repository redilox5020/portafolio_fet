<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\RoutePermission;
use Spatie\Permission\Models\Permission;

class RouteController extends Controller
{
    public function index()
    {
        // Sincronizar permisos antes de mostrar la vista
        $this->syncRoutePermissions();

        // Obtener todas las rutas registradas
        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(function ($route) {
                return $route->getName() &&
                       !str_starts_with($route->getName(), 'password.') &&
                       !str_starts_with($route->getName(), 'log') &&
                       !str_starts_with($route->getName(), 'sanctum') &&
                       !str_starts_with($route->getName(), 'register') &&
                       !str_starts_with($route->getName(), 'ignition') &&
                       !str_starts_with($route->getName(), 'routes') &&
                       !str_starts_with($route->getName(), 'forgot');
            })
            ->map(function ($route) {
                $dbPermission = RoutePermission::where('route_name', $route->getName())->first();
                $filePermission = $this->extractPermissionFromMiddleware($route);

                return [
                    'name' => $route->getName(),
                    'uri' => $route->uri(),
                    'methods' => $route->methods(),
                    'middleware' => $route->gatherMiddleware(),
                    'file_permission' => $filePermission,
                    'db_permission' => $dbPermission ? $dbPermission->permission_name : null,
                ];
            })
            ->sortBy('name');

        $permissions = Permission::all()->pluck('name');

        return view('routes.index', compact('routes', 'permissions'));
    }

    private function syncRoutePermissions()
    {
        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(fn($route) => $route->getName())
            ->each(function ($route) {
                $routeName = $route->getName();
                $permission = $this->extractPermissionFromMiddleware($route);

                if ($permission) {
                    RoutePermission::updateOrCreate(
                        ['route_name' => $routeName],
                        ['permission_name' => $permission]
                    );
                }
            });
    }

    private function extractPermissionFromMiddleware($route)
    {
        foreach ($route->gatherMiddleware() as $middleware) {
            if (str_starts_with($middleware, 'can:')) {
                return str_replace('can:', '', $middleware);
            }
        }
        return null;
    }

    public function updatePermissions(Request $request)
    {
        $validated = $request->validate([
            'route_name' => 'required|string',
            'permission' => 'nullable|string|exists:permissions,name'
        ]);

        RoutePermission::updateOrCreate(
            ['route_name' => $validated['route_name']],
            ['permission_name' => $validated['permission'] ?? null]
        );

        return back()->with('success', 'Permisos actualizados correctamente');
    }
}
