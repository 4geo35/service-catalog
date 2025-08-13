<?php

namespace GIS\ServiceCatalog\Helpers;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Models\Service;
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

    public function cascadeShutdown(ServiceCategoryInterface $category): void
    {
        foreach ($category->children as $child) {
            if (! $child->published_at) { continue; }
            $child->update([
                "published_at" => null,
            ]);
        }
        // TODO: does need make a queue?
        $services = $category->services()
            ->whereNotNull("published_at")
            ->get();
        foreach ($services as $service) {
            $service->update([
                "published_at" => null,
            ]);
        }
    }

    public function getServiceIds(ServiceCategoryInterface $category, bool $includeSubs = false): array
    {
        $serviceClass = config("service-catalog.customServiceModel") ?? Service::class;
        $query = $serviceClass::query()
            ->select("id")
            ->whereNotNull("published_at");
        if ($includeSubs) {
            $query->whereIn("category_id", $this->getChildrenIds($category, true));
        } else {
            $query->where("category_id", $category->id);
        }
        $services = $query->get();
        $sIsd = [];
        foreach ($services as $service) {
            $sIsd[] = $service->id;
        }
        return $sIsd;
    }

    public function getChildrenIds(ServiceCategoryInterface $category, bool $includeSelf = false): array
    {
        $ids = [];
        if ($includeSelf) { $ids[] = $category->id; }
        $children = $category->children()->select("id")->whereNotNull("published_at")->get();
        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getChildrenIds($child));
        }
        return array_unique($ids);
    }

    public function getParents(ServiceCategoryInterface $category): array
    {
        $result = [];
        if ($category->parent) {
            $result[] = (object) [
                "id" => $category->parent->id,
                "slug" => $category->parent->slug,
                "title" => $category->parent->title,
            ];
            $result = array_merge($this->getParents($category->parent), $result);
        }
        return $result;
    }

    protected function expandItemData(&$data, ShouldTreeInterface $category): void
    {
        $data["published_at"] = $category->published_at ?? null;
    }
}
