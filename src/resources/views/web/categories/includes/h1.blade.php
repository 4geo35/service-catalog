@if (config("service-catalog.useH1"))
    <div class="container">
        <x-tt::h1 class="mb-indent">{{ config("service-catalog.catalogPageTitle") }}</x-tt::h1>
    </div>
@endif
