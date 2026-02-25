<?php

namespace GIS\ServiceCatalog;

use GIS\Fileable\Traits\ExpandTemplatesTrait;
use GIS\RequestForm\Traits\ExpandFormsTrait;
use GIS\ServiceCatalog\Helpers\ServiceCategoryActionsManager;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Livewire\Admin\Categories\ListWire as CategoryListWire;
use GIS\ServiceCatalog\Livewire\Admin\Categories\ShowWire as CategoryShowWire;
use GIS\ServiceCatalog\Livewire\Admin\Services\ListWire as ServiceListWire;
use GIS\ServiceCatalog\Livewire\Admin\Services\ShowWire as ServiceShowWire;
use GIS\ServiceCatalog\Livewire\Web\Services\ListWire as WebServiceShowWire;
use GIS\ServiceCatalog\Livewire\Web\Forms\WebServiceFormWire;
use GIS\ServiceCatalog\Livewire\Admin\Forms\ServiceRequestTableWire;
use GIS\ServiceCatalog\Models\Service;
use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\ServiceCatalog\Observers\ServiceCategoryObserver;
use GIS\ServiceCatalog\Observers\ServiceObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ServiceCatalogServiceProvider extends ServiceProvider
{
    use ExpandTemplatesTrait, ExpandFormsTrait;

    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/service-catalog.php', 'service-catalog');

        $this->initFacades();
        $this->bindInterfaces();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . "/resources/views", "sc");

        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->expandConfiguration();
        $this->observeModels();
        $this->setPolicies();
        
        $this->addLivewireComponents();
    }

    protected function setPolicies(): void
    {
        Gate::policy(config("service-catalog.customCategoryModel") ?? ServiceCategory::class, config("service-catalog.categoryPolicy"));
        Gate::policy(config("service-catalog.customServiceModel" ?? Service::class), config("service-catalog.servicePolicy"));
    }

    protected function observeModels(): void
    {
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

        $component = config("service-catalog.customAdminCategoryShowComponent");
        Livewire::component(
            "sc-admin-category-show",
            $component ?? CategoryShowWire::class
        );

        $component = config("service-catalog.customAdminServiceListComponent");
        Livewire::component(
            "sc-admin-service-list",
            $component ?? ServiceListWire::class
        );

        $component = config("service-catalog.customAdminServiceShowComponent");
        Livewire::component(
            "sc-admin-service-show",
            $component ?? ServiceShowWire::class
        );

        $component = config("service-catalog.customWebServiceListComponent");
        Livewire::component(
            "sc-web-service-list",
            $component ?? WebServiceShowWire::class
        );

        $component = config("service-catalog.customWebServiceFormComponent");
        Livewire::component(
            "sc-web-service-form",
            $component ?? WebServiceFormWire::class
        );

        $component = config("service-catalog.customAdminServiceFormTableComponent");
        Livewire::component(
            "sc-admin-service-form-table",
            $component ?? ServiceRequestTableWire::class
        );
    }

    protected function expandConfiguration(): void
    {
        $sc = app()->config["service-catalog"];
        $this->expandTemplates($sc);
        $this->expandForms($sc);

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
