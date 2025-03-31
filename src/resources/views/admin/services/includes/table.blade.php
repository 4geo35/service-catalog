<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Адресная строка</x-tt::table.heading>
            @if (! $category)
                <x-tt::table.heading class="text-left">Категория</x-tt::table.heading>
            @endif
            <x-tt::table.heading class="text-left">Краткое описание</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($services as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                @if (! $category)
                    <td>
                        <a href="{{ route('admin.service-categories.show', ['category' => $item->category]) }}"
                           class="text-primary hover:text-primary-hover">
                            {{ $item->category->title }}
                        </a>
                    </td>
                @endif
                <td>{{ $item->short }}</td>
                <td>
                    <div class="flex items-center justify-center">
                        @can("viewAny", $item::class)
                            <a href="{{ route('admin.services.show', ['service' => $item]) }}"
                               class="btn btn-primary px-btn-ico-text rounded-e-none">
                                <x-tt::ico.eye />
                            </a>
                        @else
                            <button type="button" class="btn btn-primary px-btn-x-ico rounded-e-none" disabled>
                                <x-tt::ico.eye />
                            </button>
                        @endcan
                        @if ($item->image_id)
                            <a href="{{ route('thumb-img', ['filename' => $item->image->filename, 'template' => 'original']) }}"
                               class="btn btn-primary px-btn-x-ico rounded-none" target="_blank">
                                <x-tt::ico.image />
                            </a>
                        @endif
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-none"
                                @cannot("update", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit />
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("delete", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>

                        <button type="button" class="btn {{ $item->published_at ? 'btn-success' : 'btn-danger' }} px-btn-x-ico ml-indent-half"
                                @cannot("update", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="switchPublish({{ $item->id }})">
                            @if ($item->published_at)
                                <x-tt::ico.toggle-on />
                            @else
                                <x-tt::ico.toggle-off />
                            @endif
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
    <x-slot name="caption">
        <div class="flex justify-between">
            <div>{{ __("Total") }}: {{ $services->total() }}</div>
            {{ $services->links("tt::pagination.live") }}
        </div>
    </x-slot>
</x-tt::table>
