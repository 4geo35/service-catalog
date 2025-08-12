<x-app-layout>
    @include("sc::web.categories.includes.metas")
    @include("sc::web.categories.includes.show-breadcrumbs")

    <div class="container">
        <div class="row">
            <div class="col w-7/12">
                <x-tt::h1 class="mb-indent">{{ $category->title }}</x-tt::h1>
                <div class="prose max-w-none">
                    {!! $category->markdown !!}
                </div>
            </div>
            @if ($category->image)
                <div class="col w-5/12">
                    <picture>
                        <source media="(min-width: 480px)"
                                srcset="{{ route('thumb-img', ['template' => 'service-category-show', 'filename' => $category->image->file_name]) }}">
                        <img src="{{ route('thumb-img', ['template' => 'service-category-show', 'filename' => $category->image->file_name]) }}"
                            alt="" class="rounded-base sticky top-0">
                    </picture>
                </div>
            @endif
        </div>
    </div>
    <div class="h-screen"></div>
</x-app-layout>
