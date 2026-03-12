@props(["list"])
@if ($list->count())
    <div class="py-indent mb-indent md:mb-indent-double md:py-0 bg-light/50 md:bg-transparent">
        <div class="container" x-data="{ grabbing: false, initClientX: 0, maxScrollLeft: 0 }">
            <div class="flex flex-wrap md:flex-nowrap items-center space-y-indent-half md:space-y-0 md:space-x-indent overflow-hidden"
                 :class="grabbing ? 'md:cursor-grabbing' : 'md:cursor-grab'"
                 x-ref="categoryChildren"
                 @pointerdown="grabbing = true; initClientX = $event.clientX + $refs.categoryChildren.scrollLeft;"
                 @pointerup="grabbing = false" @mouseleave="grabbing = false"
                 @pointermove="if (grabbing) { $refs.categoryChildren.scrollLeft = initClientX - $event.clientX }">
                @foreach($list as $child)
                    <div class="shrink-0 grow-0 w-full md:w-[380px] md:min-h-[80px] h-full flex items-center p-indent-half rounded-base bg-secondary/25"
                         :class="grabbing && 'select-none pointer-events-none'">
                        @if ($child->image)
                            <img src="{{ route('thumb-img', ['template' => 'service-category-small', 'filename' => $child->image->file_name]) }}"
                                 alt="" class="rounded-base mr-indent pointer-events-none hidden md:block w-[56px] h-[56px]">
                        @else
                            <x-fa::ico.image width="56" height="56" class="mr-indent hidden md:block" />
                        @endif
                        <a href="{{ route('web.service-categories.show', ['category' => $child]) }}"
                           class="text-lg sm:text-xl leading-6 font-semibold hover:text-primary-hover cursor-pointer pointer-events-auto">
                            {{ $child->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
