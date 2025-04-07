<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('admin-access', function ($user) {
            return $user->hasRole('super-admin');
        });
    }
}
