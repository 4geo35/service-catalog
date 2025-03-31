<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Services;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Models\Service;
use GIS\ServiceCatalog\Traits\ServiceEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListWire extends Component
{
    use WithFileUploads, WithPagination, ServiceEditActions, WireDeleteImageTrait;

    public ServiceCategoryInterface|null $category = null;

    public string $searchTitle = "";
    public string $searchPublished = "all";

    protected function queryString(): array
    {
        return [
            "searchTitle" => ["as" => "title", "except" => ""],
            "searchPublished" => ["as" => "published", "except" => "all"],
        ];
    }

    public function render(): View
    {
        if ($this->category) { $query = $this->category->services(); }
        else {
            $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
            $query = $serviceModelClass::query()->with(["category"]);
        }
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        BuilderActions::extendPublished($query, $this->searchPublished);
        $query->orderBy("priority");
        $services = $query->paginate();
        return view('sc::livewire.admin.services.list-wire', compact('services'));
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle", "searchPublished");
        $this->resetPage();
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }

        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $service = $this->category->services()->create([
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
        ]);
        /**
         * @var ServiceInterface $service
         */
        $service->livewireImage($this->cover);
        $this->closeData();
//        session()->flash("success", "Услуга успешно добавлена");
        $this->redirectRoute("admin.services.show", ["service" => $service]);
    }
}
