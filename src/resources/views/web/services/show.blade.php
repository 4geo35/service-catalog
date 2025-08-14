<x-app-layout>
    @include("sc::web.services.includes.show-metas")
    @include("sc::web.services.includes.show-breadcrumbs")

    <div class="container">
        <div class="row">
            <div class="col w-full md:w-2/3">
                <x-tt::h1 class="mb-indent">{{ $service->title }}</x-tt::h1>
            </div>
            <div class="col w-full md:w-1/3">
                <livewire:sc-web-service-form :$service />
            </div>
        </div>
    </div>
</x-app-layout>
