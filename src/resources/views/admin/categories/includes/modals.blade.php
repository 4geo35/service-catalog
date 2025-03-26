<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить категорию</x-slot>
    <x-slot name="text">Будет невозможно восстановить категорию!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">
        {{ $categoryId ? "Редактировать категорию" : "Добавить " . ($parentId ? "подкатегорию" : "категорию") }}
    </x-slot>
    <x-slot name="content">
        Hello
    </x-slot>
</x-tt::modal.dialog>
