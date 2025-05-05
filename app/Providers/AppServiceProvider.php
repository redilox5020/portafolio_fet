<?php

namespace App\Providers;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use App\Services\PdfUploaderService;
use App\Contracts\FileUploaderInterface;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileUploaderInterface::class, function ($app) {
            return new PdfUploaderService();
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
