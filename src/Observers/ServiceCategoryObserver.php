<?php

namespace GIS\ServiceCatalog\Observers;

use GIS\ServiceCatalog\Facades\ServiceCategoryActions;
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

    public function updated(ServiceCategoryInterface $category): void
    {
        if ($category->wasChanged("published_at")) {
            if (! $category->published_at) { ServiceCategoryActions::cascadeShutdown($category); }
        }

        if ($category->wasChanged("parent_id")) {
            $parent = $category->parent;
            if ($parent && ! $parent->published_at) {
                $category->published_at = null;
                $category->saveQuietly();
                ServiceCategoryActions::cascadeShutdown($category);
            }
        }
    }
}
