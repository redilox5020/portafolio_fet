<?php

namespace App\Services;

use Cloudinary;
use Illuminate\Http\UploadedFile;
use Exception;
use App\Contracts\FileUploaderInterface;

class PdfUploaderService implements FileUploaderInterface
{
    protected string $folder;
    protected int $maxSize;

    public function __construct(string $folder = 'pdfs', int $maxSizeMB = 10)
    {
        $this->folder = $folder;
        $this->maxSize = $maxSizeMB * 1024 * 1024;
    }

    public function subir(?UploadedFile $archivo): string
    {
        if (!$archivo->isValid()) {
            throw new Exception("El archivo PDF no es válido o está dañado.");
        }

        if ($archivo->getMimeType() !== 'application/pdf') {
            throw new Exception("El archivo debe ser un PDF.");
        }

        if ($archivo->getSize() > $this->maxSize) {
            throw new Exception("El archivo excede el tamaño máximo de " . ($this->maxSize / 1048576) . "MB.");
        }

        $uploadResult = Cloudinary::upload($archivo->getPathname(), [
            'folder' => $this->folder,
            'resource_type' => 'auto',
        ]);

        return $uploadResult->getSecurePath();
    }
}
