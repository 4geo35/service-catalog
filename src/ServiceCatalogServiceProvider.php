<?php

namespace GIS\ServiceCatalog;

use GIS\ServiceCatalog\Livewire\Admin\Categories\CategoryListWire;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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

        // Livewire
        $this->addLivewireComponents();
    }

    protected function addLivewireComponents(): void
    {
        $component = config("service-catalog.customAdminCategoryListComponent");
        Livewire::component(
            "sc-admin-category-list",
            $component ?? CategoryListWire::class
        );
    }
}
