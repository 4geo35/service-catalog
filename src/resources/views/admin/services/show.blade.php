<x-admin-layout>
    <x-slot name="title">Просмотр услуги</x-slot>
    <x-slot name="pageTitle">Просмотр услуги</x-slot>

    <div class="space-y-indent">
        <livewire:sc-admin-service-show :service="$service" />
        <livewire:eb-manage-blocks :model="$service" />
        <livewire:eb-block-list :model="$service" />
        <livewire:ma-metas :model="$service" />
    </div>
</x-admin-layout>
