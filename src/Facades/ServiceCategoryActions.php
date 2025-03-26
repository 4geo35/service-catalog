<?php

namespace GIS\ServiceCatalog\Facades;

use GIS\ServiceCatalog\Helpers\ServiceCategoryActionsManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getCategoryTree(array $newOrder = null)
 *
 * @see ServiceCategoryActionsManager
 */
class ServiceCategoryActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "service-category-actions";
    }
}
