<?php

namespace GIS\ServiceCatalog;

use GIS\ServiceCatalog\Helpers\ServiceCategoryActionsManager;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Livewire\Admin\Categories\ListWire as CategoryListWire;
use GIS\ServiceCatalog\Livewire\Admin\Services\ListWire as ServiceListWire;
use GIS\ServiceCatalog\Models\Service;
use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\ServiceCatalog\Observers\ServiceCategoryObserver;
use GIS\ServiceCatalog\Observers\ServiceObserver;
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

        // Facades
        $this->initFacades();

        // Bindings
        $this->bindInterfaces();
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

        $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
        $serviceObserverClass = config("service-catalog.customServiceModelObserver") ?? ServiceObserver::class;
        $serviceModelClass::observe($serviceObserverClass);
    }

    protected function bindInterfaces(): void
    {
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        $this->app->bind(ServiceCategoryInterface::class, $categoryModelClass);

        $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
        $this->app->bind(ServiceInterface::class, $serviceModelClass);
    }

    protected function initFacades(): void
    {
        $this->app->singleton("service-category-actions", function () {
            $categoryActionsManagerClass = config("service-catalog.customCategoryActionsManager") ?? ServiceCategoryActionsManager::class;
            return new $categoryActionsManagerClass;
        });
    }

    protected function addLivewireComponents(): void
    {
        $component = config("service-catalog.customAdminCategoryListComponent");
        Livewire::component(
            "sc-admin-category-list",
            $component ?? CategoryListWire::class
        );

        $component = config("service-catalog.customAdminServiceListComponent");
        Livewire::component(
            "sc-admin-service-list",
            $component ?? ServiceListWire::class
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
        $permissions[] = [
            "title" => $sc["servicePolicyTitle"],
            "key" => $sc["servicePolicyKey"],
            "policy" => $sc["servicePolicy"],
        ];
        app()->config["user-management.permissions"] = $permissions;

        $eb = app()->config["editable-blocks"];
        $models = $eb["models"];
        $models["services"] = [
            "allowedTypes" => $sc["allowedBlocks"],
        ];
        app()->config["editable-blocks.models"] = $models;
    }
}
