<?php

namespace GIS\ServiceCatalog\Observers;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Models\ServiceCategory;

class ServiceCategoryObserver
{
    public function creating(ServiceCategoryInterface $category): void
    {
        $parentId = $category->parent_id;
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        $priority = $categoryModelClass::query()
            ->select("id", "priority")
            ->where("parent_id", $parentId)
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $category->priority = $priority + 1;
    }
}
