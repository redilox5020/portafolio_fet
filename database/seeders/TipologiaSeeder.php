<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TipologiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $tipologias = [
            [
                'opcion' => 'Generación de nuevo conocimiento',
                'model_type' => 'producto',
/*                 'created_at' => $now,
                'updated_at' => $now, */
            ],
            [
                'opcion' => 'Desarrollo tecnológico e innovación',
                'model_type' => 'producto',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
            [
                'opcion' => 'Apropiación social del conocimiento',
                'model_type' => 'producto',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
            [
                'opcion' => 'Formación de recurso humano',
                'model_type' => 'producto',
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ],
        ];


        DB::table('tipologias')->insert($tipologias);


        $tipologiasProyecto = [
            [
                'opcion' => 'Investigación',
                'model_type' => 'proyecto',
                // 'created_at' => $now,
                // 'updated_at' => $now
            ],
            [
                'opcion' => 'Innovación',
                'model_type' => 'proyecto',
                // 'created_at' => $now,
                // 'updated_at' => $now
            ],
            [
                'opcion' => 'Desarrollo Tecnológico',
                'model_type' => 'proyecto',
                // 'created_at' => $now,
                // 'updated_at' => $now
            ],
            [
                'opcion' => 'Emprendimiento',
                'model_type' => 'proyecto',
                // 'created_at' => $now,
                // 'updated_at' => $now
            ],
            [
                'opcion' => 'Contrato',
                'model_type' => 'proyecto',
                // 'created_at' => $now,
                // 'updated_at' => $now
            ],
                        [
                'opcion' => 'Convenio',
                'model_type' => 'proyecto',
                // 'created_at' => $now,
                // 'updated_at' => $now
            ],
                        [
                'opcion' => 'Consultoría',
                'model_type' => 'proyecto',
                // 'created_at' => $now,
                // 'updated_at' => $now
            ],

        ];
        DB::table('tipologias')->insert($tipologiasProyecto);
    }
}
