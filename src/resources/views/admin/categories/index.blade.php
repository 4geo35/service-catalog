<x-admin-layout>
    <x-slot name="title">Категории услуг</x-slot>
    <x-slot name="pageTitle">Категории услуг</x-slot>

    <livewire:sc-admin-category-list />

    @include("tt::admin.draggable-tree-script")
</x-admin-layout>
