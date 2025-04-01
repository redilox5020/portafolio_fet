<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'proyecto.create',
            'proyecto.edit',
            'proyecto.delete',
            'proyecto.view',

            'tipologia.create',
            'tipologia.edit',
            'tipologia.delete',
            'tipologia.view',

            'procedencia.create',
            'procedencia.edit',
            'procedencia.delete',
            'procedencia.view',

            'procedencia.codigo.create',
            'procedencia.codigo.edit',
            'procedencia.codigo.delete',
            'procedencia.codigo.view',

            'programa.create',
            'programa.edit',
            'programa.delete',
            'programa.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo([ 'proyecto.create', 'proyecto.edit', 'proyecto.view',
                                    'tipologia.create', 'tipologia.edit', 'tipologia.view',
                                    'procedencia.create', 'procedencia.edit', 'procedencia.view',
                                    'procedencia.codigo.create', 'procedencia.codigo.edit', 'procedencia.codigo.view',
                                    'programa.create', 'programa.edit', 'programa.view']);

        $creator = Role::create(['name' => 'creator']);
        $creator->givePermissionTo(['proyecto.create', 'proyecto.view',
                                    'tipologia.create', 'tipologia.view',
                                    'procedencia.create', 'procedencia.view',
                                    'procedencia.codigo.create', 'procedencia.codigo.view',
                                    'programa.create','programa.view']);


    }
}
