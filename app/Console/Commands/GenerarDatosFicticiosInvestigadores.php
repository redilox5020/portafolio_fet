<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Investigador;
use Illuminate\Support\Str;

class GenerarDatosFicticiosInvestigadores extends Command
{
    protected $signature = 'investigadores:generar-datos-ficticios
                            {--force : Sobrescribir datos existentes}
                            {--solo-vacios : Solo llenar campos vacíos}';

    protected $description = 'Genera datos ficticios (email, documento, teléfono) para investigadores';

    private $emailsUsados = [];
    private $documentosUsados = [];
    private $tiposDocumento = ['CC', 'TI'];
    private $dominiosEmail = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com', 'fet.edu.co'];

    public function handle()
    {
        $this->info('Generando datos ficticios para investigadores...');

        $query = Investigador::query();

        // Si solo queremos llenar vacíos
        if ($this->option('solo-vacios')) {
            $query->where(function($q) {
                $q->whereNull('email')
                  ->orWhereNull('documento')
                  ->orWhereNull('telefono');
            });
        }

        $investigadores = $query->get();
        $total = $investigadores->count();

        if ($total === 0) {
            $this->info('No hay investigadores para procesar.');
            return Command::SUCCESS;
        }

        // Cargar emails y documentos existentes para evitar duplicados
        $this->cargarDatosExistentes();

        $this->info("Se encontraron {$total} investigadores para procesar.");

        if (!$this->option('force') && !$this->option('solo-vacios')) {
            if (!$this->confirm('¿Desea continuar? Esto generará datos ficticios.')) {
                $this->info('Operación cancelada.');
                return Command::SUCCESS;
            }
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $procesados = 0;
        $errores = 0;

        foreach ($investigadores as $investigador) {
            try {
                $this->generarDatosParaInvestigador($investigador);
                $procesados++;
            } catch (\Exception $e) {
                $errores++;
                $this->error("\nError en investigador {$investigador->id}: " . $e->getMessage());
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Resumen
        $this->info("✓ Proceso completado:");
        $this->table(
            ['Resultado', 'Cantidad'],
            [
                ['Procesados exitosamente', $procesados],
                ['Errores', $errores],
                ['Total', $total]
            ]
        );

        return Command::SUCCESS;
    }

    private function cargarDatosExistentes()
    {
        $this->emailsUsados = Investigador::whereNotNull('email')
            ->pluck('email')
            ->toArray();

        $this->documentosUsados = Investigador::whereNotNull('documento')
            ->pluck('documento')
            ->toArray();
    }

    private function generarDatosParaInvestigador(Investigador $investigador)
    {
        $datos = [];
        $force = $this->option('force');
        $soloVacios = $this->option('solo-vacios');

        // Generar email si no tiene o si es force (y no es solo-vacios)
        if ((empty($investigador->email) || ($force && !$soloVacios))) {
            $datos['email'] = $this->generarEmailUnico($investigador->nombre);
        }

        // Generar tipo documento y documento
        if ((empty($investigador->tipo_documento) || ($force && !$soloVacios))) {
            $datos['tipo_documento'] = $this->tiposDocumento[array_rand($this->tiposDocumento)];
        }

        if ((empty($investigador->documento) || ($force && !$soloVacios))) {
            $tipoDoc = $datos['tipo_documento'] ?? $investigador->tipo_documento ?? 'CC';
            $datos['documento'] = $this->generarDocumentoUnico($tipoDoc);
        }

        // Generar teléfono
        if ((empty($investigador->telefono) || ($force && !$soloVacios))) {
            $datos['telefono'] = $this->generarTelefono();
        }
        if (!empty($datos)) {
            $result = $investigador->update($datos);
            $this->info($result ? "Datos actualizados para investigador ID {$investigador->id}" : "No se actualizaron datos para investigador ID {$investigador->id}");
        }
    }

    private function generarEmailUnico(string $nombre): string
    {
        // Limpiar el nombre
        $nombre = $this->limpiarNombre($nombre);
        $partesNombre = explode(' ', $nombre);

        $intentos = 0;
        $maxIntentos = 10;

        while ($intentos < $maxIntentos) {
            $email = $this->construirEmail($partesNombre, $intentos);

            if (!in_array($email, $this->emailsUsados)) {
                $this->emailsUsados[] = $email;
                return $email;
            }

            $intentos++;
        }

        // Si no se pudo generar, usar UUID
        $uuid = Str::uuid();
        $dominio = $this->dominiosEmail[array_rand($this->dominiosEmail)];
        return "investigador_{$uuid}@{$dominio}";
    }

    private function construirEmail(array $partesNombre, int $intento): string
    {
        $dominio = $this->dominiosEmail[array_rand($this->dominiosEmail)];

        if (count($partesNombre) >= 2) {
            $primerNombre = strtolower($partesNombre[0]);
            $apellido = strtolower($partesNombre[count($partesNombre) - 1]);

            switch ($intento) {
                case 0:
                    // juan.perez@gmail.com
                    return "{$primerNombre}.{$apellido}@{$dominio}";
                case 1:
                    // jperez@gmail.com
                    return substr($primerNombre, 0, 1) . $apellido . "@{$dominio}";
                case 2:
                    // juan_perez@gmail.com
                    return "{$primerNombre}_{$apellido}@{$dominio}";
                case 3:
                    // perez.juan@gmail.com
                    return "{$apellido}.{$primerNombre}@{$dominio}";
                default:
                    // juan.perez123@gmail.com
                    $numero = rand(10, 999);
                    return "{$primerNombre}.{$apellido}{$numero}@{$dominio}";
            }
        } else {
            $nombre = strtolower($partesNombre[0]);
            $numero = $intento > 0 ? rand(10, 999) : '';
            return "{$nombre}{$numero}@{$dominio}";
        }
    }

    private function limpiarNombre(string $nombre): string
    {
        // Remover acentos y caracteres especiales
        $nombre = iconv('UTF-8', 'ASCII//TRANSLIT', $nombre);
        $nombre = preg_replace('/[^a-zA-Z\s]/', '', $nombre);
        return trim($nombre);
    }

    private function generarDocumentoUnico(string $tipo): string
    {
        $intentos = 0;
        $maxIntentos = 100;

        while ($intentos < $maxIntentos) {
            $documento = $this->generarDocumentoPorTipo($tipo);

            if (!in_array($documento, $this->documentosUsados)) {
                $this->documentosUsados[] = $documento;
                return $documento;
            }

            $intentos++;
        }

        // Fallback: agregar timestamp
        return $this->generarDocumentoPorTipo($tipo) . '-' . time();
    }

    private function generarDocumentoPorTipo(string $tipo): string
    {
        switch ($tipo) {
            case 'CC':
                // Cédula colombiana: 8-10 dígitos
                return (string) rand(10000000, 9999999999);

            case 'TI':
                // Tarjeta de identidad: 10-11 dígitos
                return (string) rand(1000000000, 99999999999);

            default:
                return (string) rand(10000000, 99999999);
        }
    }

    private function generarTelefono(): string
    {
        // Generar teléfonos colombianos ficticios
        $prefijos = ['310', '311', '312', '313', '314', '315', '316', '317', '318', '319', '320', '321', '322', '323', '324', '350', '351'];
        $prefijo = $prefijos[array_rand($prefijos)];
        $numero = rand(1000000, 9999999);

        return "{$prefijo}{$numero}";
    }
}
