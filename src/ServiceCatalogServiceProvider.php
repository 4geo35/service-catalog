<?php

namespace GIS\ServiceCatalog;

use GIS\ServiceCatalog\Livewire\Admin\Categories\CategoryListWire;
use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\ServiceCatalog\Observers\ServiceCategoryObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ServiceCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

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

        // Expand config
        $this->expandConfiguration();

        // Observers
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        $categoryObserverClass = config("service-catalog.customCategoryModelObserver") ?? ServiceCategoryObserver::class;
        $categoryModelClass::observe($categoryObserverClass);
    }

    protected function addLivewireComponents(): void
    {
        $component = config("service-catalog.customAdminCategoryListComponent");
        Livewire::component(
            "sc-admin-category-list",
            $component ?? CategoryListWire::class
        );
    }

    protected function expandConfiguration(): void
    {
        $sc = app()->config["service-catalog"];

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "title" => $sc["categoryPolicyTitle"],
            "key" => $sc["categoryPolicyKey"],
            "policy" => $sc["categoryPolicy"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }
}
