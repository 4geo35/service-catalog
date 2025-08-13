@props(["list"])
@if ($list->count())
    <div class="container py-indent" x-data="{ grabbing: false, initClientX: 0, maxScrollLeft: 0 }">
        <div class="flex flex-nowrap items-center space-x-indent overflow-hidden cursor-grab"
             x-ref="categoryChildren"
             @mousedown="grabbing = true; initClientX = $event.clientX + $refs.categoryChildren.scrollLeft;"
             @mouseup="grabbing = false" @mouseleave="grabbing = false"
             @mousemove="if (grabbing) { $refs.categoryChildren.scrollLeft = initClientX - $event.clientX }">
            @foreach($list as $child)
                <div class="shrink-0 grow-0 w-[380px] min-h-[80px] h-full flex items-center p-indent-half rounded-base bg-secondary/25"
                     :class="grabbing && 'select-none pointer-events-none'">
                    @if ($child->image)
                        <img src="{{ route('thumb-img', ['template' => 'service-category-small', 'filename' => $child->image->file_name]) }}"
                             alt="" class="rounded-base mr-indent pointer-events-none">
                    @else
                        <x-fa::ico.image width="56" height="56" class="mr-indent" />
                    @endif
                    <a href="{{ route('web.service-catalog.show', ['category' => $child]) }}"
                       class="text-lg sm:text-xl leading-6 font-semibold hover:text-primary-hover cursor-pointer">
                        {{ $child->title }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
