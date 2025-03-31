@can("viewAny", config("service-catalog.customCategoryModel") ?? \GIS\ServiceCatalog\Models\ServiceCategory::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.service-categories.index') }}"
        :active="in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['admin.service-categories.index', 'admin.service-categories.show'])">
        <x-slot name="ico"><x-sc::ico.tree /></x-slot>
        Категории услуг
    </x-tt::admin-menu.item>
@endcan

@can("viewAny", config("service-catalog.customServiceModel") ?? \GIS\ServiceCatalog\Models\Service::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.services.index') }}"
        :active="in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['admin.services.index', 'admin.services.show'])">
        <x-slot name="ico"><x-sc::ico.services /></x-slot>
        Услуги
    </x-tt::admin-menu.item><x-tt::admin
@endcan
