<?php

namespace GIS\ServiceCatalog\Helpers;

use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\TraitsHelpers\Interfaces\ShouldTreeInterface;
use GIS\TraitsHelpers\Traits\ManagerTreeTrait;

class ServiceCategoryActionsManager
{
    use ManagerTreeTrait;

    public function __construct()
    {
        $this->modelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        $this->hasImage = true;
    }

    protected function expandItemData(&$data, ShouldTreeInterface $category): void
    {
        $data["published_at"] = $category->published_at ?? null;
    }
}
