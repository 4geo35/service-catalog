<div class="container mb-indent">
    <x-tt::h1 class="mb-indent">{{ $service->title }}</x-tt::h1>
    @if ($blocks)
        @foreach($blocks as $block)
            <x-dynamic-component :component="$block->render_type_component" :$block class="mb-indent" :is-full-page="true" />
        @endforeach
    @endif
    @if (!config("service-catalog.disableForm"))
        <div class="rounded-base bg-primary/25 px-indent py-indent-double mt-indent-half">
            <div class="md:w-10/12 mx-auto">
                <x-tt::h3 class="mb-indent">Свяжитесь <span class="text-nowrap">с нами</span></x-tt::h3>
                <livewire:sc-web-service-form :$service />
            </div>
        </div>
    @endif
</div>
