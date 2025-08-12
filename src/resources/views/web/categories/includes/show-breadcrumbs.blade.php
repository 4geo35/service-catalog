@if (config("service-catalog.useBreadcrumbs"))
    @php($homeUrl = \Illuminate\Support\Facades\Route::has("web.home") ? route("web.home") : "/")
    <x-tt::breadcrumbs>
        <x-tt::breadcrumbs.item :url="$homeUrl">Главная</x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item :url="route('web.service-catalog.index')">
            {{ config("service-catalog.catalogPageTitle") }}
        </x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item>{{ $category->title }}</x-tt::breadcrumbs.item>
    </x-tt::breadcrumbs>
@endif
