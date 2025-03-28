<?php

namespace GIS\ServiceCatalog\Facades;

use GIS\ServiceCatalog\Helpers\ServiceCategoryActionsManager;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getCategoryTree(array $newOrder = null)
 * @method static bool rebuildTree(array $newOrder)
 *
 * @method static void cascadeShutdown(ServiceCategoryInterface $category)
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
