<?php

return [
    // Settings
    "allowedBlocks" => [],

    // Admin
    "customCategoryModel" => null,
    "customCategoryModelObserver" => null,

    "customServiceModel" => null,
    "customServiceModelObserver" => null,

    "customAdminCategoryController" => null,
    "customAdminServiceController" => null,

    // Facades
    "customCategoryActionsManager" => null,

    // Components
    "customAdminCategoryListComponent" => null,
    "customAdminServiceListComponent" => null,

    // Policy
    "categoryPolicyTitle" => "Управление категориями услуг",
    "categoryPolicy" => \GIS\ServiceCatalog\Policies\ServiceCategoryPolicy::class,
    "categoryPolicyKey" => "service_categories",

    "servicePolicyTitle" => "Управление услугами",
    "servicePolicy" => \GIS\ServiceCatalog\Policies\ServicePolicy::class,
    "servicePolicyKey" => "services",
];
