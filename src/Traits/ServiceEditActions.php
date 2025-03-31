<?php

namespace GIS\ServiceCatalog\Traits;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Models\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait ServiceEditActions
{
    public bool $displayData = false;
    public bool $displayDelete = false;

    public string $title = "";
    public string $slug = "";
    public string $short = "";
    public TemporaryUploadedFile|null $cover = null;
    public string|null $coverUrl = null;

    public int|null $serviceId = null;

    public function rules(): array
    {
        $uniqueCondition = "unique:services,slug";
        if ($this->serviceId) { $uniqueCondition .= "," . $this->serviceId; }
        return [
            "title" => ["required", "string", "max:150"],
            "slug" => ["nullable", "string", "max:150", $uniqueCondition],
            "short" => ["nullable", "string", "max:150"],
            "cover" => ["nullable", "image", "mimes:jpg,jpeg,png,webp"],
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

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showEdit(int $serviceId): void
    {
        $this->resetFields();
        $this->serviceId = $serviceId;
        $service = $this->findModel();
        if (! $service) { return; }
        if (! $this->checkAuth("update", $service)) { return; }

        $this->title = $service->title;
        $this->slug = $service->slug;
        $this->short = $service->short;
        if ($service->image_id) {
            $service->load("image");
            $this->coverUrl = route("thumb-img", ["filename" => $service->image->filename, "template" => "original"]);
        } else { $this->coverUrl = null;}
        $this->displayData = true;
    }

    public function update(): void
    {
        $service = $this->findModel();
        if (! $service) { return; }
        if (! $this->checkAuth("update", $service)) { return; }
        $this->validate();

        $service->update([
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
        ]);
        /**
         * @var ServiceInterface $service
         */
        $service->livewireImage($this->cover);
        session()->flash("success", "Услуга успешно обновлена");
        $this->closeData();
        if (method_exists($this, "resetPage")) { $this->resetPage(); }
        if (isset($this->service)) $this->service->fresh();
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function showDelete(int $serviceId): void
    {
        $this->resetFields();
        $this->serviceId = $serviceId;
        $service = $this->findModel();
        if (! $service) { return; }
        if (! $this->checkAuth("delete", $service)) { return; }

        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $service = $this->findModel();
        if (! $service) { return; }
        if (! $this->checkAuth("delete", $service)) { return; }

        $category = $service->category;
        /**
         * @var ServiceCategoryInterface $category
         */

        try {
            $service->delete();
            session()->flash("success", "Услуга успешно удалена");
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении услуги");
        }

        $this->closeDelete();
        if (method_exists($this, "resetPage")) { $this->resetPage(); }
        if (isset($this->service)) { $this->redirectRoute("admin.service-categories.show", ["category" => $category]); }
    }

    public function switchPublish(int $serviceId): void
    {
        $this->resetFields();
        $this->serviceId = $serviceId;
        $service = $this->findModel();
        if (! $service) { return; }
        if (! $this->checkAuth("update", $service)) { return; }

        $service->update([
            "published_at" => $service->published_at ? null : now(),
        ]);
    }

    protected function findModel(): ?ServiceInterface
    {
        if (isset($this->service)) return $this->service;

        $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
        $service = $serviceModelClass::find($this->serviceId);
        if (! $service) {
            session()->flash("error", "Услуга не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $service;
    }

    protected function resetFields(): void
    {
        $this->reset(["title", "slug", "short", "cover", "coverUrl", "serviceId"]);
    }

    protected function checkAuth(string $action, ServiceInterface $service = null): bool
    {
        try {
            $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
            $this->authorize($action, $service ?? $serviceModelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
