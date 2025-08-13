@php
    $perCol = config("service-catalog.servicePerCol");
    $colClasses = match ($perCol) {
        4 => "md:w-1/2 lg:w-1/3 xl:w-1/4",
        default => "md:w-1/2 lg:w-1/3",
    };
@endphp
<div class="container mb-indent">
    <div class="row">
        @foreach($services as $item)
            <div class="col w-full {{ $colClasses }} mb-indent">
                <x-sc::service.teaser :service="$item" />
            </div>
        @endforeach
    </div>
    <div class="flex justify-between">
        <div>{{ __("Total") }}: {{ $services->total() }}</div>
        {{ $services->links("tt::pagination.web-live", ['scrollTo' => '#servicePageScroll']) }}
    </div>
</div>
