@props(["service"])
@php
    $perCol = config("service-catalog.servicePerCol");
    $url = route("web.services.show", ["service" => $service]);
    $templateName = match ($perCol) {
        4 => "service-teaser-4",
        default => "service-teaser-3",
    };
    $imageHeight = match ($perCol) {
        4 => "md:h-[245px] lg:h-[216px] ",
        default => "md:h-[182px] lg:h-[160px]",
    }
@endphp
<div class="flex flex-col h-full rounded-base overflow-hidden bg-white shadow-lg">
    <a href="{{ $url }}" class="block xs:h-[218px] sm:h-[257px] {{ $imageHeight }} xl:h-[205px] 2xl:h-[250px]">
        @if ($service->image)
            <picture>
                <source media="(min-width: 768px)"
                        srcset="{{ route('thumb-img', ['template' => $templateName, 'filename' => $service->image->file_name]) }}">
                <source media="(min-width: 480px)"
                        srcset="{{ route('thumb-img', ['template' => 'tablet-service-teaser', 'filename' => $service->image->file_name]) }}">
                <img src="{{ route('thumb-img', ['template' => 'mobile-service-teaser', 'filename' => $service->image->file_name]) }}"
                     class="h-full object-cover object-center"
                     alt="">
            </picture>
        @else
            <span class="flex items-center justify-center h-full w-full">
                <x-fa::ico.image
                    class="w-auto h-[150px] text-secondary"/>
            </span>
        @endif
    </a>
    <div class="flex-1 p-indent">
        <a href="{{ $url }}" class="text-h4-mobile sm:text-h4 font-semibold hover:text-primary-hover">
            {{ $service->title }}
        </a>
    </div>
    @if ($service->short)
        <div class="text-body/60 px-indent pb-indent">{{ $service->short }}</div>
    @endif
</div>
