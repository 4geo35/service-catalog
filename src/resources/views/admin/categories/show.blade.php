<x-admin-layout>
    <x-slot name="title">Услуги категории "{{ $category->title }}"</x-slot>
    <x-slot name="pageTitle">Услуги категории "{{ $category->title }}"</x-slot>

    <div class="space-y-indent">
        @can("viewAny", config("service-catalog.customServiceModel") ?? \GIS\ServiceCatalog\Models\Service::class)
            <livewire:sc-admin-service-list :category="$category" />
        @endcan
        <livewire:ma-metas :model="$category" />
    </div>
</x-admin-layout>
