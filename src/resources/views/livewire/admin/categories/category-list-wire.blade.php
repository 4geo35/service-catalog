<div>
     <div class="card">
         <div class="card-body">
            <div class="space-y-indent-half mb-indent">
                <div class="flex justify-between items-center">
                    <button type="button" class="btn btn-primary" wire:click="showCreate">
                        <x-tt::ico.circle-plus />
                        <span class="pl-btn-ico-text">Добавить <span class="hidden sm:inline">корневую категорию</span></span>
                    </button>
                    @if ($tmpTree)
                        <button type="button" class="btn btn-outline-primary" wire:click="updateOrder">
                            Сохранить порядок
                        </button>
                    @endif
                </div>
                <x-tt::notifications.error />
                <x-tt::notifications.success />
            </div>
         </div>
     </div>
</div>
