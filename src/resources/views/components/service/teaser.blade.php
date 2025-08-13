@props(["service"])
@php
    $perCol = config("service-catalog.servicePerCol");
@endphp
<div class="">
    {{ $service->title }}
</div>
