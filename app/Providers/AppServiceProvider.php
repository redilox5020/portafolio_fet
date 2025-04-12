<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PdfUploaderService;
use App\Contracts\FileUploaderInterface;
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
        //
    }
}
