@if (config("service-catalog.useBreadcrumbs"))
    @php($homeUrl = \Illuminate\Support\Facades\Route::has("web.home") ? route("web.home") : "/")
    <x-tt::breadcrumbs>
        <x-tt::breadcrumbs.item :url="$homeUrl">Главная</x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item :url="route('web.service-categories.index')">
            {{ config("service-catalog.catalogPageTitle") }}
        </x-tt::breadcrumbs.item>
        @if (count($categoryParents))
            @foreach($categoryParents as $parent)
                <x-tt::breadcrumbs.item :url="route('web.service-categories.show', ['category' => $parent->slug])">
                    {{ $parent->title }}
                </x-tt::breadcrumbs.item>
            @endforeach
        @endif
        <x-tt::breadcrumbs.item :url="route('web.service-categories.show', ['category' => $category])">
            {{ $category->title }}
        </x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item >{{ $service->title }}</x-tt::breadcrumbs.item>
    </x-tt::breadcrumbs>
@endif
