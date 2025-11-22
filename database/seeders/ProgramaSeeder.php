<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $programas = [
            [
                'nombre' => 'Ingeniería de Software',
                'sufijo' => 'ISO',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
            [
                'nombre' => 'Ingeniería Ambiental',
                'sufijo' => 'IAM',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
            [
                'nombre' => 'Ingeniería de Alimentos',
                'sufijo' => 'IAL',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
            [
                'nombre' => 'Ingeniería Eléctrica',
                'sufijo' => 'IEL',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
            [
                'nombre' => 'Administración de la Seguridad y Salud en el Trabajo',
                'sufijo' => 'ASST',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
            [
                'nombre' => 'Administración de Negocios Digitales',
                'sufijo' => 'AND',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
        ];

        DB::table('programas')->insert($programas);
    }
}
