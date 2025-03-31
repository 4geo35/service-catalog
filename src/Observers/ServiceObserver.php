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

    public function updated(ServiceInterface $service): void
    {
        if (
            $service->wasChanged("category_id") &&
            ! $service->category->published_at
        ) {
            $service->published_at = null;
            $service->saveQuietly();
        }
    }
}
