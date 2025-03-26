<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Categories;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class CategoryListWire extends Component
{
    use WithFileUploads;

    public bool $tmpTree = false;
    public bool $displayDelete = false;
    public bool $displayData = false;

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

    public function showCreate(int $parentId = null): void
    {
        // TODO: check auth
        $this->resetFields();
        $this->parentId = $parentId;
        $this->displayData = true;
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "cover", "short", "description", "coverUrl");
    }
}
