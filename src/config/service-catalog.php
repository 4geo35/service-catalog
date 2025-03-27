<?php

return [
    // Admin
    "customCategoryModel" => null,
    "customCategoryModelObserver" => null,

    "customServiceModel" => null,
    "customServiceModelObserver" => null,

    "customAdminCategoryController" => null,

    // Facades
    "customCategoryActionsManager" => null,

    // Components
    "customAdminCategoryListComponent" => null,

    // Policy
    "categoryPolicyTitle" => "Управление категориями услуг",
    "categoryPolicy" => \GIS\ServiceCatalog\Policies\ServiceCategoryPolicy::class,
    "categoryPolicyKey" => "service_categories",

    "servicePolicyTitle" => "Управление услугами",
    "servicePolicy" => \GIS\ServiceCatalog\Policies\ServicePolicy::class,
    "servicePolicyKey" => "services",
];
