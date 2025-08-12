<?php

return [
    // Web
    "categoryPagePrefix" => "service-catalog",
    "servicePagePrefix" => "services",
    "useBreadcrumbs" => true,
    "catalogPageTitle" => "Услуги",
    "useH1" => true,
    "customCategoryWebController" => null,
    "perCol" => 3, // 4,3,2

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
    "customAdminCategoryShowComponent" => null,
    "customAdminServiceListComponent" => null,
    "customAdminServiceShowComponent" => null,

    // Policy
    "categoryPolicyTitle" => "Управление категориями услуг",
    "categoryPolicy" => \GIS\ServiceCatalog\Policies\ServiceCategoryPolicy::class,
    "categoryPolicyKey" => "service_categories",

    "servicePolicyTitle" => "Управление услугами",
    "servicePolicy" => \GIS\ServiceCatalog\Policies\ServicePolicy::class,
    "servicePolicyKey" => "services",

    // Templates
    "templates" => [
        "service-category-teaser-2" => \GIS\ServiceCatalog\Templates\CatalogTeaser2::class,
        "service-category-teaser-3" => \GIS\ServiceCatalog\Templates\CatalogTeaser3::class,
        "service-category-teaser-4" => \GIS\ServiceCatalog\Templates\CatalogTeaser4::class,
        "mobile-service-category-teaser" => \GIS\ServiceCatalog\Templates\MobileCatalogTeaser::class,
    ],
];
