<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Services;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Models\Service;
use GIS\ServiceCatalog\Traits\ServiceEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListWire extends Component
{
    use WithFileUploads, WithPagination, ServiceEditActions, WireDeleteImageTrait;

    public ServiceCategoryInterface|null $category = null;

    public string $searchTitle = "";
    public string $searchPublished = "all";

    public bool $displayOrder = false;

    public Collection|null $list = null;
    public bool $hasSearch = false;

    public string|null $updateDate = null;

    protected function queryString(): array
    {
        return [
            "searchTitle" => ["as" => "title", "except" => ""],
            "searchPublished" => ["as" => "published", "except" => "all"],
        ];
    }

    public function mount(): void
    {
        $this->setUpdateTime();
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
        $time = $this->updateDate;
        return view('sc::livewire.admin.services.list-wire', compact('services', "time"));
    }

    #[On("switch-category-published")]
    public function setUpdateTime(): void
    {
        $this->updateDate = now()->format('Y-m-d H:i:s');
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

    public function showOrder(): void
    {
        if (! $this->checkAuth("order")) { return; }
        $this->displayOrder = true;
        $this->setListItems();
        $this->dispatch("update-list");
    }

    public function reorderItems(array $newOrder): void
    {
        if (! $this->checkAuth("order")) { return; }

        foreach ($newOrder as $priority => $id) {
            $this->serviceId = $id;
            $service = $this->findModel();
            if (! $service) { continue; }
            $service->priority = $priority;
            $service->save();
        }
        $this->resetFields();
        $this->resetPage();
        $this->setListItems();
    }

    protected function setListItems(): void
    {
        $this->list = $this->category->services()
            ->select("id", "title")
            ->orderBy("priority")
            ->get();
    }
}
