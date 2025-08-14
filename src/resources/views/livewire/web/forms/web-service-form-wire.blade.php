<div>
    @if ($modal)
        <x-tt::modal.dialog wire:model="displayForm" maxWidth="lg">
            <x-slot name="content">
                <div class="relative mb-indent">
                    <button type="button" wire:click="closeForm"
                            class="cursor-pointer text-body/60 hover:text-body transition-all absolute top-0 right-0">
                        <x-tt::ico.cross />
                    </button>
                    <div class="text-center">
                        <x-tt::h2 class="mb-1">Заказать услугу</x-tt::h2>
                        <div class="text-body/60 text-lg leading-tight w-10/12 mx-auto">
                            Перезвоним на указанный номер, чтобы ответить на ваши вопросы.
                        </div>
                    </div>
                </div>
                @include("sc::web.forms.service-request.form")
            </x-slot>
        </x-tt::modal.dialog>
    @else
        <div>
            @include("sc::web.forms.service-request.form")
        </div>
    @endif
</div>
