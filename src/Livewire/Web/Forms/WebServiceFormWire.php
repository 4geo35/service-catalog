<?php

namespace GIS\ServiceCatalog\Livewire\Web\Forms;

use GIS\RequestForm\Interfaces\RequestFormShowInterface;
use GIS\RequestForm\Traits\RequestFormActionsTrait;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Models\ServiceRequestRecord;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class WebServiceFormWire extends Component implements RequestFormShowInterface
{
    use RequestFormActionsTrait;

    #[Locked]
    public ServiceInterface $service;

    public string $formName = "service-request";
    public bool $modal = false;
    public string $postfix = "";
    public string $double = "";

    public string $name = "";
    public string $phone = "";
    public string $comment = "";
    public bool $privacy = true;

    public string $prefix = "";

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:50"],
            "phone" => ["required", "string", "max:18", "min:18"],
            "privacy" => ["required"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Имя",
            "phone" => "Номер телефона",
            "privacy" => "Политика конфиденциальности",
        ];
    }

    public function render(): View
    {
        return view("sc::livewire.web.forms.web-service-form-wire");
    }

    public function store(): void
    {
        $this->validate();
        try {
            $serviceRequestModelClass = config("service-catalog.customServiceRequestRecordModel") ?? ServiceRequestRecord::class;
            $record = $serviceRequestModelClass::create([
                "name" => $this->name,
                "phone" => $this->phone,
                "comment" => $this->comment,
            ]);
            $form = $this->createForm($record);
            if (! $form) {
                $record->delete();
                session()->flash("{$this->prefix}error", "Ошибка при сохранении данных");
            } else {
                session()->flash("{$this->prefix}success", "Ваше обращение получено! Мы свяжемся с вами в ближайшее время.");
            }
        } catch (\Exception $exception) {
            session()->flash("{$this->prefix}error", "Ошибка при сохранении данных.");
        }

        $this->resetFields();
    }

    public function resetFields(): void
    {
        $this->reset("name", "phone", "privacy", "comment");
    }
}
