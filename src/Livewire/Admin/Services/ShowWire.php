<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Services;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\ServiceCatalog\Traits\ServiceEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowWire extends Component
{
    use WithFileUploads, ServiceEditActions, WireDeleteImageTrait;

    public ServiceInterface $service;
    public bool $displayCategory = false;
    public Collection|null $categoryList = null;
    public string $searchCategory = "";
    public ServiceCategoryInterface|null $chosenCategory = null;

    public function updated($property, $value): void
    {
        if ($property === "searchCategory") {
            $this->setCategoryList();
        }
    }

    public function render(): View
    {
        return view('sc::livewire.admin.services.show-wire');
    }

    public function showCategory(): void
    {
        if (! $this->checkAuth("update", $this->service)) { return; }
        $this->displayCategory = true;
        $this->reset('categoryList', "searchCategory", "chosenCategory");
        $this->setCategoryList();
    }

    public function chooseCategory(int $id): void
    {
        $category = $this->findCategory($id);
        if (! $category) { return; }
        $this->chosenCategory = $category;
    }

    public function cancelChoose(): void
    {
        $this->reset("chosenCategory");
    }

    public function confirmChose(): void
    {
        if (! $this->checkAuth("update", $this->service)) { return; }
        $this->service->category()->associate($this->chosenCategory);
        $this->service->save();
        $this->service->fresh();
        $this->displayCategory = false;
        session()->flash("success", "Категория успешно обновлена");
    }

    protected function findCategory(int $id): ?ServiceCategoryInterface
    {
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        $category = $categoryModelClass::find($id);
        if (! $category) {
            $this->setCategoryList();
            session()->flash("category-error", "Категория не найдена");
            return null;
        }
        return $category;
    }

    protected function setCategoryList(): void
    {
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        $query = $categoryModelClass::query()
            ->select("id", "title");
        BuilderActions::extendLike($query, $this->searchCategory, "title");
        $this->categoryList = $query->orderBy("title")->get();
    }
}
