<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcedenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            'Modalidad de Grado' => [
                'Proyecto de Grado',
                'Pasantía',
                'Seminario de Profundización'
            ],
            'Grupo de Investigación' => [
                'GIIFET',
                'GISST'
            ],
            'Semillero de Investigación' => [
                'ASST',
            ],
            'Proyecto de Aula' => [
                'Aula General'
            ],
        ];

        foreach ($data as $procedenciaNombre => $detalles) {
            $procedenciaId = DB::table('procedencias')->insertGetId([
                'opcion' => $procedenciaNombre,
                // 'created_at' => $now,
                // 'updated_at' => $now,
            ]);

            foreach ($detalles as $detalleNombre) {
                DB::table('procedencia_detalles')->insert([
                    'procedencia_id' => $procedenciaId,
                    'opcion' => $detalleNombre,
                    // 'created_at' => $now,
                    // 'updated_at' => $now,
                ]);
            }
        }
    }
}
