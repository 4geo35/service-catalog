<?php

return [
    // Admin
    "customCategoryModel" => null,
    "customAdminCategoryController" => null,

    // Components
    "customAdminCategoryListComponent" => null,

    // Policy
    "categoryPolicyTitle" => "Управление категориями услуг",
    "categoryPolicy" => \GIS\ServiceCatalog\Policies\ServiceCategoryPolicy::class,
    "categoryPolicyKey" => "service_categories",
];
