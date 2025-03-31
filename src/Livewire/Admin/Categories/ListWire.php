<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Categories;

use GIS\ServiceCatalog\Facades\ServiceCategoryActions;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Models\ServiceCategory;
use GIS\TraitsHelpers\Interfaces\WireTreeInterface;
use GIS\TraitsHelpers\Interfaces\WireTreePublishInterface;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ListWire extends Component implements WireTreeInterface, WireTreePublishInterface
{
    use WithFileUploads, WireDeleteImageTrait;

    public array|null $tmpTree = null;
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
        $uniqueCondition = "unique:service_categories,slug";
        if ($this->categoryId) { $uniqueCondition .= ",{$this->categoryId}"; }
        return [
            "title" => ["required", "string", "max:150"],
            "slug" => ["nullable", "string", "max:150", $uniqueCondition],
            "cover" => ["nullable", "image", "mimes:jpg,jpeg,png,webp"],
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
        $tree = ServiceCategoryActions::getCategoryTree($this->tmpTree);
        $this->dispatch("re-init-script");
        return view('sc::livewire.admin.categories.list-wire', compact("tree"));
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

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        if ($this->parentId) {
            $parent = $this->findModel($this->parentId);
            if (! $parent) { return; }
        }
        $this->validate();
        $data = [
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
        ];
        if ($this->parentId) {
            $category = $parent->children()->create($data);
        } else {
            $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
            $category = $categoryModelClass::create($data);
        }
        /**
         * @var ServiceCategoryInterface $category
         */
        $category->livewireImage($this->cover);
        session()->flash("success", "Категория успешно добавлена");
        $this->closeData();
    }

    public function showEdit(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }

        $this->displayData = true;
        $this->title = $category->title;
        $this->slug = $category->slug;
        $this->short = $category->short;
        $this->description = $category->description;
        if ($category->image_id) {
            $category->load("image");
            $this->coverUrl = $category->image->storage;
        } else { $this->coverUrl = null; }
    }

    public function update(): void
    {
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }
        $this->validate();

        $category->update([
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
        ]);
        $category->livewireImage($this->cover);
        session()->flash("success", "Категория успешно обновлена");
        $this->closeData();
    }

    public function showDelete(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("delete", $category)) { return; }

        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("delete", $category)) { return; }

        if ($category->children->count()) {
            session()->flash("error", "Невозможно удалить категорию, у которой есть дочерние категории");
            $this->closeDelete();
            return;
        }

        if ($category->services->count()) {
            session()->flash("error", "Невозможно удалить категорию, у которой есть услуги");
            $this->closeDelete();
            return;
        }

        try {
            $category->delete();
            session()->flash("success", "Категория успешно удалена");
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении категории");
        }
        $this->closeDelete();
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function switchPublish(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }
        $category->update([
            "published_at" => $category->published_at ? null : now(),
        ]);
    }

    public function tmpOrder(array $tree): void
    {
        $this->tmpTree = $tree;
        $this->dispatch("change-tree");
    }

    public function updateOrder(): void
    {
        if (! $this->checkAuth("order")) { return; }
        $result = ServiceCategoryActions::rebuildTree($this->tmpTree);
        $this->tmpTree = null;
        if ($result) { session()->flash("success", "Дерево категорий изменено"); }
        else { session()->flash("error", "Ошибка при обновлении дерева"); }
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

    protected function findModel(int $id = null): ?ServiceCategoryInterface
    {
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        if ($id) { $category = $categoryModelClass::find($id); }
        else { $category = $categoryModelClass::find($this->categoryId); }
        if (! $category) {
            session()->flash("error", "Категория не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $category;
    }
}
