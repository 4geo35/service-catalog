<div>
    <div class="card">
        <div class="card-header">
            <div class="space-y-indent-half">
                @include("sc::admin.services.includes.show-title")
                <x-tt::notifications.error prefix="service-" />
                <x-tt::notifications.success prefix="service-" />
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Категория</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">
                            <div class="flex items-center">
                                <a href="{{ route('admin.service-categories.show', ['category' => $service->category]) }}"
                                   class="text-primary hover:text-primary-hover">
                                    {{ $service->category->title }}
                                </a>
                                @can("update", $service)
                                    <button type="button" class="text-info hover:text-info-hover ml-2 cursor-pointer" wire:click="showCategory">
                                        <x-tt::ico.edit />
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Дата создания</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $service->created_human }}</div>
                    </div>

                    @if ($service->created_at !== $service->updated_at)
                        <div class="row">
                            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                <h3 class="font-semibold">Дата обновления</h3>
                            </div>
                            <div class="col w-full xs:w-3/5">{{ $service->updated_human }}</div>
                        </div>
                    @endif
                </div>

                <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Адресная строка</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $service->slug }}</div>
                    </div>

                    @if($service->short)
                        <div class="row">
                            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                <h3 class="font-semibold">Краткое описание</h3>
                            </div>
                            <div class="col w-full xs:w-3/5">{{ $service->short }}</div>
                        </div>
                    @endif

                    @if($service->image_id && $service->image)
                        <div class="row">
                            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                <h3 class="font-semibold">Изображение</h3>
                            </div>
                            <div class="col w-full xs:w-3/5">
                                <a href="{{ route('thumb-img', ['filename' => $service->image->filename, 'template' => 'original']) }}"
                                   class="text-primary hover:text-primary-hover" target="_blank">
                                    Просмотр
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include("sc::admin.services.includes.table-modals")
    @include("sc::admin.services.includes.change-category-modal")
</div>
