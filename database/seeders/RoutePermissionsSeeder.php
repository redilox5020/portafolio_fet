<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoutePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiamos la tabla antes de llenarla para evitar duplicados si se corre db:seed varias veces
        DB::table('route_permissions')->truncate();

        $now = Carbon::now();

        // Mapeo exacto basado en tu SQL
        $routes = [
            // Proyectos
            ['route_name' => 'proyectos.create',      'permission_name' => 'proyecto.create'],
            ['route_name' => 'proyectos.store',       'permission_name' => 'proyecto.create'],
            ['route_name' => 'proyectos.delete',      'permission_name' => 'proyecto.delete'],
            ['route_name' => 'proyecto.por.codigo',   'permission_name' => 'proyecto.view'],
            ['route_name' => 'proyectos.edit',        'permission_name' => 'proyecto.edit'],
            ['route_name' => 'proyectos.update',      'permission_name' => 'proyecto.edit'],
            ['route_name' => 'proyectos.por.programa','permission_name' => 'proyecto.view'],

            // Tipologías
            ['route_name' => 'tipologia.create',      'permission_name' => 'tipologia.create'],
            ['route_name' => 'tipologia.store',       'permission_name' => 'tipologia.create'],
            ['route_name' => 'tipologia.delete',      'permission_name' => 'tipologia.delete'],
            ['route_name' => 'tipologia.index',       'permission_name' => 'tipologia.view'],

            // Procedencias
            ['route_name' => 'procedencia.store',     'permission_name' => 'procedencia.create'],
            ['route_name' => 'procedencia.delete',    'permission_name' => 'procedencia.delete'],
            ['route_name' => 'procedencia.index',     'permission_name' => 'procedencia.view'],

            // Procedencia Detalles (Códigos)
            ['route_name' => 'procedencia.codigo.store',  'permission_name' => 'procedencia.codigo.create'],
            ['route_name' => 'procedencia.codigo.delete', 'permission_name' => 'procedencia.codigo.delete'],
            ['route_name' => 'procedencia.codigo.index',  'permission_name' => 'procedencia.codigo.view'],

            // Programas
            ['route_name' => 'programa.store',        'permission_name' => 'programa.create'],
            ['route_name' => 'programa.delete',       'permission_name' => 'programa.delete'],
            ['route_name' => 'programa.index',        'permission_name' => 'programa.view'],

            // Productos (Nuevos)
            ['route_name' => 'productos.create',      'permission_name' => 'producto.create'],
            ['route_name' => 'productos.store',       'permission_name' => 'producto.create'],
            ['route_name' => 'productos.delete',      'permission_name' => 'producto.delete'],

            // Gestión de Usuarios y Roles (Admin Access)
            // Nota: Estos permisos 'admin-access' o 'edit-user' deben ser manejados
            // por tu Gate::before o lógica personalizada, ya que no están en la tabla 'permissions'
            ['route_name' => 'users',                 'permission_name' => 'admin-access'],
            ['route_name' => 'user.edit',             'permission_name' => 'edit-user,user'],
            ['route_name' => 'user.update',           'permission_name' => 'edit-user,user'],
            ['route_name' => 'user.delete',           'permission_name' => 'admin-access'],

            ['route_name' => 'roles.index',           'permission_name' => 'admin-access'],
            ['route_name' => 'roles.store',           'permission_name' => 'admin-access'],
            ['route_name' => 'roles.update',          'permission_name' => 'admin-access'],
            ['route_name' => 'roles.delete',          'permission_name' => 'admin-access'],

            ['route_name' => 'routes.index',              'permission_name' => 'admin-access'],
            ['route_name' => 'routes.update-permissions', 'permission_name' => 'admin-access'],
        ];

        // Agregamos timestamps a cada registro
        $data = array_map(function ($item) use ($now) {
            return array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $routes);

        DB::table('route_permissions')->insert($data);
    }
}
