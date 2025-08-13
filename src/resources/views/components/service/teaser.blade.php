@props(["service"])
@php
    $perCol = config("service-catalog.servicePerCol");
    $url = route("web.services.show", ["service" => $service]);
    $templateName = match ($perCol) {
        4 => "service-teaser-4",
        default => "service-teaser-3",
    };
@endphp
<div class="flex flex-col h-full rounded-base overflow-hidden bg-white shadow-lg">
    <a href="{{ $url }}" class="block">
        @if ($service->image)
            <picture>
                <source media="(min-width: 480px)"
                        srcset="{{ route('thumb-img', ['template' => $templateName, 'filename' => $service->image->file_name]) }}">
                <img src="{{ route('thumb-img', ['template' => 'mobile-service-teaser', 'filename' => $service->image->file_name]) }}"
                     alt="">
            </picture>
        @else
            <span class="flex items-center justify-center">
                <x-fa::ico.image
                    class="w-auto min-h-[150px] xs:h-[162px] sm:h-[193px] md:h-[252px] lg:h-[222px] xl:h-[207px] 2xl:h-[250px] text-secondary"/>
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
