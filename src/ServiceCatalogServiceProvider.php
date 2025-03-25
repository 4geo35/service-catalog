<?php

namespace GIS\ServiceCatalog;

use Illuminate\Support\ServiceProvider;

class ServiceCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Routes
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');

        // Config
        $this->mergeConfigFrom(__DIR__ . '/config/service-catalog.php', 'service-catalog');
    }

    public function boot(): void
    {
        // Views
        $this->loadViewsFrom(__DIR__ . "/resources/views", "sc");
    }
}
