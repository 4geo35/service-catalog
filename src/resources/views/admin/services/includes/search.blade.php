<div class="flex justify-between mb-indent-half">
    <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <input type="text" aria-label="Заголовок" placeholder="Заголовок" class="form-control" wire:model.live="searchTitle">
        <select class="form-select" aria-label="Статус публикации" wire:model.live="searchPublished">
            <option value="all">Любая публикация</option>
            <option value="yes">Опубликовано</option>
            <option value="no">Снаято с публикации</option>
        </select>
        <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">
            Очистить
        </button>
    </div>

    @can("create", config("service-catalog.customServiceModel") ?? \GIS\ServiceCatalog\Models\Service::class)
        @if ($category)
            <div class="flex items-center space-x-2">
                <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x ml-indent-half" wire:click="showCreate">
                    <x-tt::ico.circle-plus />
                    <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
                </button>
                <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x ml-indent-half" wire:click="showOrder">
                    <x-tt::ico.bars />
                    <span class="hidden lg:inline-block pl-btn-ico-text">Порядок</span>
                </button>
            </div>
        @endif
    @endcan
</div>
