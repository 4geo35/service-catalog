<x-admin-layout>
    <x-slot name="title">Услуги категории "{{ $category->title }}"</x-slot>
    <x-slot name="pageTitle">Услуги категории "{{ $category->title }}"</x-slot>

    <div class="space-y-indent">
        <livewire:ma-metas :model="$category" />
    </div>
</x-admin-layout>
