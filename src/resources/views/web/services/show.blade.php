<x-app-layout>
    @include("sc::web.services.includes.show-metas")
    @include("sc::web.services.includes.show-breadcrumbs")

    <div class="container">
        <div class="row">
            <div class="col w-full md:w-2/3">
                <x-tt::h1 class="mb-indent">{{ $service->title }}</x-tt::h1>
                @if ($blocks)
                    @foreach($blocks as $block)
                        <x-dynamic-component :component="$block->render_type_component" :$block class="mb-indent" />
                    @endforeach
                @endif
            </div>
            <div class="col w-full md:w-1/3">
                @if (config("service-catalog.useImageOnShowPage") && $service->image)
                    <img src="{{ route('thumb-img', ['template' => 'service-show', 'filename' => $service->image->file_name]) }}"
                         alt="" class="rounded-base mb-indent">
                @endif
                <div class="rounded-base bg-primary/25 px-indent py-indent-double sticky top-0">
                    <x-tt::h3 class="mb-indent">Свяжитесь с нами</x-tt::h3>
                    <livewire:sc-web-service-form :$service />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
