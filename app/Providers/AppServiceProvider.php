<?php

namespace App\Providers;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use App\Services\CloudinaryUploaderService;
use App\Services\LocalStorageUploaderService;
use App\Contracts\FileUploaderInterface;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CloudinaryUploaderService::class, function ($app) {
            return new CloudinaryUploaderService(
                config('filesystems.cloudinary_folder', 'pdfs'),
                config('filesystems.max_file_size_mb', 10)
            );
        });

        $this->app->bind(LocalStorageUploaderService::class, function ($app) {
            return new LocalStorageUploaderService(
                config('filesystems.local_folder', 'pdfs'),
                config('filesystems.max_file_size_mb', 10),
                config('filesystems.public_disk', 'public')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        Carbon::setLocale('es');

        Str::macro('toReadableSize', function ($bytes) {
            if (!is_numeric($bytes)) {
                return 'N/A';
            }
            if ($bytes >= 1073741824) {
                return round($bytes / 1073741824, 2) . ' GB';
            } elseif ($bytes >= 1048576) {
                return round($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                return round($bytes / 1024, 2) . ' KB';
            } else {
                return $bytes . ' bytes';
            }
        });
    }
}
