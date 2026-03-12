@props(["category"])
@php
    $perCol = config("service-catalog.perCol");
    $url = route("web.service-categories.show", ["category" => $category]);
    $templateName = match ($perCol) {
        4 => "service-category-teaser-4",
        3 => "service-category-teaser-3",
        default => "service-category-teaser-2",
    };
    $icoSize = match ($perCol) {
        4,3 => "xl:h-[207px] 2xl:h-[250px]",
        default => "xl:h-[280px] 2xl:h-[336px]",
    };
@endphp
<div class="h-full rounded-base flex flex-col overflow-hidden bg-white shadow-lg">
    <a href="{{ $url }}" class="flex items-center justify-center xs:min-h-[217px] sm:min-h-[257px] md:min-h-[182px] lg:min-h-[160px] xl:min-h-[205px] 2xl:min-h-[250px]">
        @if ($category->image)
            <picture>
                <source media="(min-width: 768px)"
                        srcset="{{ route('thumb-img', ['template' => $templateName, 'filename' => $category->image->file_name]) }}">
                <source media="(min-width: 480px)"
                        srcset="{{ route('thumb-img', ['template' => "tablet-service-category-teaser", 'filename' => $category->image->file_name]) }}">
                <img src="{{ route('thumb-img', ['template' => 'mobile-service-category-teaser', 'filename' => $category->image->file_name]) }}"
                     class="h-full object-cover object-center"
                     alt="">
            </picture>
        @else
            <span class="flex items-center justify-center">
                <x-fa::ico.image
                    class="w-auto min-h-[150px] xs:h-[162px] sm:h-[193px] md:h-[252px] lg:h-[222px] {{ $icoSize }} text-secondary"/>
            </span>
        @endif
    </a>
    <div class="flex-1 p-indent">
        <a href="{{ $url }}" class="text-h4-mobile sm:text-h4 font-semibold hover:text-primary-hover">
            {{ $category->title }}
        </a>
    </div>
</div>
