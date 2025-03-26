@props(["tree" => [], "child" => false])
<ul class="{{ $child ? 'ml-indent-half border-l border-dashed pl-indent-half pt-indent-half' : '' }}" drag-category-parent>
    @foreach($tree as $key => $item)
        <li class="pb-indent-half" drag-category-item="{{ $item['id'] }}"
            drag-category-item-order="{{ $key }}"
            drag-category-item-parent="{{ $item['parent'] ?? 0 }}"
            wire:key="{{ $item['id'] }}-{{ $item['ts'] }}">
            <div class="flex items-center justify-between transition-all border border-transparent" drag-category-data>
                <div class="text-lg font-medium mr-indent text-nowrap flex justify-start items-center">
                    <div class="flex items-center">
                        <x-tt::ico.bars class="text-secondary mr-indent cursor-grab" drag-category-grab />
                    </div>
                    <div>{{ $item["title"] }}</div>
                </div>

                <div class="flex-1 h-px min-w-indent border-t border-dotted border-secondary"></div>

                <div class="flex items-center justify-start ml-indent">
                    <button type="button" class="btn btn-success btn-sm px-btn-x-ico rounded-e-none"
                            wire:loading.attr="disabled"
                            wire:click="showCreate({{ $item['id'] }})">
                        <x-tt::ico.circle-plus />
                    </button>
                    <a href="{{ route('admin.service-categories.show', ['category' => $item['slug']]) }}"
                       class="btn btn-primary btn-sm px-btn-x-ico rounded-none">
                        <x-tt::ico.eye width="18" height="18" />
                    </a>
                    @if ($item["imageUrl"])
                        <a href="{{ $item["imageUrl"] }}" class="btn btn-primary btn-sm px-btn-x-ico rounded-none" target="_blank">
                            <x-tt::ico.image width="18" height="18" />
                        </a>
                    @endif
                    <button type="button" class="btn btn-dark btn-sm px-btn-x-ico rounded-none"
                            wire:loading.attr="disabled"
                            wire:click="showEdit({{ $item['id'] }})">
                        <x-tt::ico.edit />
                    </button>
                    <button type="button" class="btn btn-danger btn-sm px-btn-x-ico rounded-s-none"
                            wire:click="showDelete({{ $item['id'] }})"
                            @if(! empty($item['children'])) disabled @else wire:loading.attr="disabled" @endif>
                        <x-tt::ico.trash />
                    </button>
                </div>
            </div>

            @if (empty($item["children"]))
                <ul class="ml-indent-half border-l border-dashed pl-indent-half" drag-category-parent>
                    <li class="" drag-category-item="{{ $item['id'] }}"
                        drag-category-item-order="{{ $key }}"
                        drag-category-item-parent="{{ $item['parent'] ?? 0 }}"
                        drag-category-item-ignore
                        wire:key="{{ $item['id'] }}-{{ $item['ts'] }}">
                        <div class="border border-secondary border-dotted h-6 pb-indent-half hidden" drag-category-data drag-category-empty></div>
                    </li>
                </ul>
            @endif

            @includeWhen(! empty($item["children"]), "cp::admin.categories.includes.tree", ["tree" => $item["children"], "child" => true])
        </li>
    @endforeach
</ul>
