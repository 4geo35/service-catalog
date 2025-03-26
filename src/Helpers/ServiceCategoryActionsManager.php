<?php

namespace GIS\ServiceCatalog\Helpers;

use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\TraitsHelpers\Traits\ManagerTreeTrait;

class ServiceCategoryActionsManager
{
    use ManagerTreeTrait;

    public function __construct()
    {
        $this->modelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        $this->hasImage = true;
    }
}
