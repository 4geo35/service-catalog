<?php

return [
    // Web
    "categoryPagePrefix" => "service-catalog",
    "servicePagePrefix" => "services",
    "useBreadcrumbs" => true,
    "catalogPageTitle" => "Услуги",
    "useH1" => true,
    "customCatalogWebController" => null,
    "perCol" => 3, // 4,3,2
    "servicePerCol" => 4, // 4,3
    "customWebServiceListComponent" => null,

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
        "service-category-teaser-2" => \GIS\ServiceCatalog\Templates\CategoryTeaser2::class,
        "service-category-teaser-3" => \GIS\ServiceCatalog\Templates\CategoryTeaser3::class,
        "service-category-teaser-4" => \GIS\ServiceCatalog\Templates\CategoryTeaser4::class,
        "mobile-service-category-teaser" => \GIS\ServiceCatalog\Templates\MobileCategoryTeaser::class,

        "service-category-show" => \GIS\ServiceCatalog\Templates\CategoryShow::class,
        "service-category-small" => \GIS\ServiceCatalog\Templates\CategorySmall::class,

        "service-teaser-3" => \GIS\ServiceCatalog\Templates\ServiceTeaser3::class,
        "service-teaser-4" => \GIS\ServiceCatalog\Templates\ServiceTeaser4::class,
        "mobile-service-teaser" => \GIS\ServiceCatalog\Templates\MobileServiceTeaser::class,
    ],
];
