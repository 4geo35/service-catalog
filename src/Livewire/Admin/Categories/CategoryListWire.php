<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Categories;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class CategoryListWire extends Component
{
    use WithFileUploads, WireDeleteImageTrait;

    public bool $tmpTree = false;
    public bool $displayDelete = false;
    public bool $displayData = false;
    public bool $displayDeleteImage = false;

    public int|null $categoryId = null;
    public int|null $parentId = null;

    public string $title = "";
    public string $slug = "";
    public TemporaryUploadedFile|null $cover = null;
    public string|null $coverUrl = null;
    public string $short = "";
    public string $description = "";

    public function rules(): array
    {
        $uniqueCondition = "unique:categories,slug";
        if ($this->categoryId != null) { $uniqueCondition .= ",{$this->categoryId}"; }
        return [
            "title" => ["required", "string", "max:150"],
            "slug" => ["required", "string", "max:150", $uniqueCondition],
            "cover" => ["nullable", "image", "mimes:jpg,jpeg,png"],
            "short" => ["nullable", "string", "max:250"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "cover" => "Обложка",
            "short" => "Краткое описание",
        ];
    }

    public function render(): View
    {
        return view('sc::livewire.admin.categories.category-list-wire');
    }

    public function closeData(): void
    {
        $this->displayData = false;
        $this->resetFields();
    }

    public function showCreate(int $parentId = null): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }

        $this->parentId = $parentId;
        $this->displayData = true;
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "cover", "short", "description", "coverUrl", "categoryId", "parentId");
    }

    protected function checkAuth(string $action, ServiceCategoryInterface $category = null): bool
    {
        try {
            $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
            $this->authorize($action, $category ?? $categoryModelClass);
            return true;
        } catch (\Exception $exception) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
