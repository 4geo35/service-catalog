<x-admin-layout>
    <x-slot name="title">Услуга {{ $service->title }}</x-slot>
    <x-slot name="pageTitle">Услуга {{ $service->title }}</x-slot>

    <div class="space-y-indent">
        <livewire:ma-metas :model="$service" />
    </div>
</x-admin-layout>
