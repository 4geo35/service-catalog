<?php

namespace GIS\ServiceCatalog\Livewire\Web\Services;

use GIS\ServiceCatalog\Facades\ServiceCategoryActions;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Models\Service;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class ListWire extends Component
{
    use WithPagination;
    #[Locked]
    public ServiceCategoryInterface $category;

    public function render(): View
    {
        $sIds = ServiceCategoryActions::getServiceIds($this->category, true);
        $serviceClass = config("service-catalog.customServiceModel") ?? Service::class;
        $services = $serviceClass::query()
            ->with("image")
            ->whereIn('id', $sIds)
            ->orderBy("title")
            ->paginate(12);
        return view("sc::livewire.web.services.list-wire", compact("services"));
    }
}
