<x-app-layout>
    @include("sc::web.services.includes.show-metas")
    @include("sc::web.services.includes.show-breadcrumbs")

    @if (config("service-catalog.useSplitPage"))
        @include("sc::web.services.includes.split-content")
    @else
        @include("sc::web.services.includes.full-content")
    @endif
</x-app-layout>
