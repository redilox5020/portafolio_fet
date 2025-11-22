<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Proyecto
            'proyecto.create', 'proyecto.edit', 'proyecto.delete', 'proyecto.view',
            // Tipología
            'tipologia.create', 'tipologia.edit', 'tipologia.delete', 'tipologia.view',
            // Procedencia
            'procedencia.create', 'procedencia.edit', 'procedencia.delete', 'procedencia.view',
            // Procedencia Código
            'procedencia.codigo.create', 'procedencia.codigo.edit', 'procedencia.codigo.delete', 'procedencia.codigo.view',
            // Programa
            'programa.create', 'programa.edit', 'programa.delete', 'programa.view',
            // Producto
            'producto.create', 'producto.edit', 'producto.delete', 'producto.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // --- SUPER ADMIN ---
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        // --- EDITOR (Crea, Edita, Ve - NO Borra) ---
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'proyecto.create', 'proyecto.edit', 'proyecto.view',
            'tipologia.create', 'tipologia.edit', 'tipologia.view',
            'procedencia.create', 'procedencia.edit', 'procedencia.view',
            'procedencia.codigo.create', 'procedencia.codigo.edit', 'procedencia.codigo.view',
            'programa.create', 'programa.edit', 'programa.view',
            'producto.create', 'producto.edit', 'producto.view',
        ]);

        // --- CREATOR (Crea, Ve - NO Edita, NO Borra) ---
        $creator = Role::firstOrCreate(['name' => 'creator']);
        $creator->syncPermissions([
            'proyecto.create', 'proyecto.view',
            'tipologia.create', 'tipologia.view',
            'procedencia.create', 'procedencia.view',
            'procedencia.codigo.create', 'procedencia.codigo.view',
            'programa.create', 'programa.view',
            'producto.create', 'producto.view',
        ]);

        // --- VIEWER (Solo Ve) ---
        $viewer = Role::firstOrCreate(['name' => 'viewer']);
        $viewer->syncPermissions([
            'proyecto.view',
            'tipologia.view',
            'procedencia.view',
            'procedencia.codigo.view',
            'programa.view',
            'producto.view',
        ]);

        // --- ROLES ESPECÍFICOS POR MÓDULO ---

        $rolProyecto = Role::firstOrCreate(['name' => 'proyecto.all']);
        $rolProyecto->syncPermissions(['proyecto.create', 'proyecto.edit', 'proyecto.delete', 'proyecto.view']);

        $rolTipologia = Role::firstOrCreate(['name' => 'tipologia.all']);
        $rolTipologia->syncPermissions(['tipologia.create', 'tipologia.edit', 'tipologia.delete', 'tipologia.view']);

        $rolProcedencia = Role::firstOrCreate(['name' => 'procedencia.all']);
        $rolProcedencia->syncPermissions(['procedencia.create', 'procedencia.edit', 'procedencia.delete', 'procedencia.view']);

        $rolProcedenciaCod = Role::firstOrCreate(['name' => 'procedencia.codigo.all']);
        $rolProcedenciaCod->syncPermissions(['procedencia.codigo.create', 'procedencia.codigo.edit', 'procedencia.codigo.delete', 'procedencia.codigo.view']);

        $rolPrograma = Role::firstOrCreate(['name' => 'programa.all']);
        $rolPrograma->syncPermissions(['programa.create', 'programa.edit', 'programa.delete', 'programa.view']);

        // Crear Usuario Super Admin
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Usuario',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole($superAdmin);
    }
}
