<div class="container mb-indent">
    <x-tt::h1 class="mb-indent">{{ $service->title }}</x-tt::h1>
    @if ($blocks)
        @foreach($blocks as $block)
            <x-dynamic-component :component="$block->render_type_component" :$block class="mb-indent" :is-full-page="true" />
        @endforeach
    @endif
    @if (!config("service-catalog.disableForm"))
        @php($hasImage = config("service-catalog.useImageOnShowPage") && $service->image)
        @if($hasImage) <div class="pt-indent"></div> @endif
        <div class="rounded-base bg-primary/25 py-indent-double px-indent {{ $hasImage ? 'mt-indent-double' : 'mt-indent' }}">
            @if ($hasImage)
                <div class="row">
                    <div class="col w-full lg:w-4/12 ml-auto">
                        @php($fileName = $service->image->file_name)
                        <a href="{{ route('thumb-img', ['template' => 'original', 'filename' => $fileName]) }}"
                           data-fslightbox="lightbox-{{ $service->slug }}" class="block mb-indent basis-auto shrink-0 -mt-24">
                            <picture class="not-prose">
                                <source media="(min-width: 1024px)" srcset="{{ route('thumb-img', ['template' => 'request-form-record', 'filename' => $fileName]) }}">
                                <source media="(min-width: 480px)" srcset="{{ route('thumb-img', ['template' => 'request-form-record-tablet', 'filename' => $fileName]) }}">
                                <img src="{{ route('thumb-img', ['template' => 'request-form-record-full-mobile', 'filename' => $fileName]) }}" alt="" class="rounded-base">
                            </picture>
                        </a>
                    </div>
                    <div class="col w-full lg:w-8/12 xl:w-6/12 2xl:w-5/12 mx-auto">
                        <x-tt::h3 class="mb-indent-half">Свяжитесь с нами</x-tt::h3>
                        <livewire:sc-web-service-form :$service />
                    </div>
                </div>
            @else
                <div class="md:w-10/12 mx-auto">
                    <x-tt::h3 class="mb-indent">Свяжитесь с нами</x-tt::h3>
                    <livewire:sc-web-service-form :$service />
                </div>
            @endif
        </div>
    @endif
</div>
