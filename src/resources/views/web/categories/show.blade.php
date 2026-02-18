<x-app-layout>
    @include("sc::web.categories.includes.show-metas")
    @include("sc::web.categories.includes.show-breadcrumbs")

    <div class="container mb-indent md:mb-indent-double">
        <div class="row">
            <div class="col w-full lg:w-7/12">
                <x-tt::h1 class="md:mb-indent">{{ $category->title }}</x-tt::h1>
                <div class="prose max-w-none hidden md:block">
                    {!! $category->markdown !!}
                </div>
            </div>
            @if ($category->image)
                <div class="col w-full lg:w-5/12 hidden lg:block">
                    <picture>
                        <source media="(min-width: 480px)"
                                srcset="{{ route('thumb-img', ['template' => 'service-category-show', 'filename' => $category->image->file_name]) }}">
                        <img src="{{ route('thumb-img', ['template' => 'service-category-show', 'filename' => $category->image->file_name]) }}"
                            alt="" class="rounded-base sticky top-0">
                    </picture>
                </div>
            @endif
        </div>
        <div id="servicePageScroll"></div>
    </div>

    @include("sc::web.categories.includes.children-list", ["list" => $categoryChildren])

    <livewire:sc-web-service-list :$category />

    <div class="container md:hidden mb-indent">
        <div class="prose max-w-none">
            {!! $category->markdown !!}
        </div>
    </div>
</x-app-layout>
