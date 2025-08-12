@props(["list"])
@php
    $perCol = config("service-catalog.perCol");
    $colClasses = match ($perCol) {
        4 => "md:w-1/2 lg:w-1/3 xl:w-1/4",
        3 => "md:w-1/2 lg:w-1/3",
        default => "md:w-1/2",
    };
@endphp
<div class="container">
    <div class="row">
        @foreach($list as $item)
            <div class="col w-full {{ $colClasses }} mb-indent">
                <x-sc::category.teaser :category="$item" />
            </div>
        @endforeach
    </div>
</div>
