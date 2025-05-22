<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\FileDriver;
use App\Models\Archivo;
use App\Factories\FileUploaderFactory;

class ArchivoController extends Controller
{
    public function obtenerMetadatos(string $modelType, int $modelId)
    {
        $modelClass = $this->resolveModelClass($modelType);

        $model = $modelClass::findOrFail($modelId);

        $archivos = $model->archivos()->get();

        $response = [];
        foreach ($archivos as $archivo){
            $driver = $archivo->driver;

            $data = null;

            try {
                $uploader = FileUploaderFactory::create($driver);
                $data = $uploader->getDataFile($archivo->url, $archivo, $modelId);
            } catch (\Exception $e) {
                \Log::warning("Error al acceder al PDF en Cloudinary: " . $e->getMessage());

                $data = [
                    'id' => $archivo->id,
                    'nombre' => 'No disponible',
                    'descripcion' => $e->getMessage(),
                    'tamaño' => 'N/A',
                    'url' => $archivo->url,
                    'driver' => $archivo->driver
                ];
            }
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function eliminarArchivo(Request $request, int $fileId)
    {
        $archivo = Archivo::findOrFail($fileId);

        try {
            $uploader = FileUploaderFactory::create($archivo->driver);
            $uploader->eliminar($archivo->file_id);
            $archivo->delete();
            if (!$request->ajax()){
                return redirect()->back()->with('success', 'Archivo eliminado exitosamente');
            }
            return response()->json(['message' => 'Archivo eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            $archivo->delete();
            if (!$request->ajax()){
                return redirect()->back()->with('error', 'Error al eliminar el archivo: ' . $e->getMessage());
            }
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function subirArchivo(Request $request, string $modelType, int $modelId)
    {
        $validatedData = $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:10240',
            'descripcion' => 'required|string|max:255',
            'driver' => 'required|string|in:cloudinary,local',
        ]);

        $modelClass = $this->resolveModelClass($modelType);

        $model = $modelClass::findOrFail($modelId);

        $driver = FileDriver::tryFrom($validatedData['driver']);

        try {
            $uploader = FileUploaderFactory::create($driver);
            $datosSubida = $uploader->subir($request->file('archivo'), $model);
            $datosSubida['descripcion'] = $validatedData['descripcion'];

            $archivo = $model->archivos()->create($datosSubida);

            return response()->json([
                'message' => 'Archivo subido exitosamente',
                'data' => $uploader->getDataFile($archivo->url, $archivo, $modelId)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function resolveModelClass(string $modelType): string
    {
        $modelMap = [
            'proyecto' => \App\Models\Proyecto::class,
            'producto' => \App\Models\Producto::class,
        ];

        $modelType = strtolower($modelType);

        if (!isset($modelMap[$modelType])) {
            throw new \Exception("Tipo de modelo no soportado: {$modelType}");
        }

        return $modelMap[$modelType];
    }
}
