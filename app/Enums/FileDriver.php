<?php
namespace App\Enums;

enum FileDriver: string
{
    case CLOUDINARY = 'cloudinary';
    case S3 = 's3';
    case LOCAL = 'local';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
