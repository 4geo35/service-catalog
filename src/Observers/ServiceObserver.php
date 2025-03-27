<?php

namespace GIS\ServiceCatalog\Observers;

use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Models\Service;

class ServiceObserver
{
    public function creating(ServiceInterface $service): void
    {
        $categoryId = $service->category_id;
        $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
        $priority = $serviceModelClass::query()
            ->select("id", "priority")
            ->where("category_id", $categoryId)
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $service->priority = $priority + 1;
    }
}
