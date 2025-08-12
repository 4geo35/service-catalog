<x-app-layout>
    @include("sc::web.categories.includes.metas")
    @include("sc::web.categories.includes.breadcrumbs")
    @include("sc::web.categories.includes.h1")

    @include("sc::web.categories.includes.category-list", ["list" => $categories])
</x-app-layout>
