<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить услугу</x-slot>
    <x-slot name="text">Будет невозможно восстановить услугу</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $serviceId ? "Редактировать услугу" : "Добавить услугу" }}</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $serviceId ? 'update' : 'store' }}"
              class="space-y-indent-half" id="serviceDataForm">
            <div>
                <label for="title" class="inline-block mb-2">
                    Заголовок <span class="text-danger">*</span>
                </label>
                <input type="text" id="title"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <label for="slug" class="inline-block mb-2">
                    Адресная строка
                </label>
                <input type="text" id="slug"
                       class="form-control {{ $errors->has("slug") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="slug">
                <x-tt::form.error name="slug"/>
            </div>

            <div>
                <label for="short" class="inline-block mb-2">
                    Краткое описание
                </label>
                <input type="text" id="short"
                       class="form-control {{ $errors->has("short") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="short">
                <x-tt::form.error name="short"/>
            </div>

            <div>
                <label for="cover" class="inline-block mb-2">Изображение</label>
                <input type="file" id="cover"
                       class="form-control {{ $errors->has('cover') ? 'border-danger' : '' }}"
                       wire:loading.attr="disabled"
                       wire:model.lazy="cover">
                <x-tt::form.error name="cover"/>
                @include("tt::admin.delete-image-button")
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="serviceDataForm" class="btn btn-primary" wire:loading.attr="disabled">
                    {{ $serviceId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
