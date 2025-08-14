<form wire:submit.prevet="store" class="space-y-indent-half">
    <x-tt::notifications.error :prefix="$prefix" />
    <x-tt::notifications.success :prefix="$prefix" />

    <div>
        <input type="text"
               id="name-{{ $formName }}{{ $modal ? '-modal' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}"
               class="form-control form-control-lg {{ $errors->has("name") ? "border-danger" : "" }}"
               required
               aria-label="Имя" placeholder="Имя*"
               wire:loading.attr="disabled"
               wire:model="name">
        <x-tt::form.error name="name"/>
    </div>

    <div x-data="{ mask: '+{7} (000) 000-00-00' }"
         x-init="IMask($refs.phone, { mask })">
        <input type="text"
               id="phone-{{ $formName }}{{ $modal ? '-modal' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}"
               class="form-control form-control-lg {{ $errors->has("phone") ? "border-danger" : "" }}"
               required
               aria-label="Номер телефона" placeholder="Номер телефона*"
               x-ref="phone"
               wire:loading.attr="disabled"
               wire:model="phone">
        <x-tt::form.error name="phone"/>
    </div>

    <div>
        <textarea id="comment-{{ $formName }}{{ $modal ? 'modal-' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}"
                  class="form-control !min-h-52 {{ $errors->has('comment') ? 'border-danger' : '' }}"
                  rows="10" placeholder="Комментарий"
                  wire:model.live="comment">
            {{ $comment }}
        </textarea>
        <x-tt::form.error name="comment"/>
    </div>

    <div class="form-check">
        <input type="checkbox" wire:model="privacy"
               required
               id="privacy-{{ $formName }}{{ $modal ? '-modal' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}"
               class="form-check-input {{ $errors->has('privacy') ? 'border-danger' : '' }}" />
        <label for="privacy-{{ $formName }}{{ $modal ? '-modal' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}" class="form-check-label">
            @include("tt::policy.check-text")
        </label>
    </div>

    <button type="submit" class="btn btn-lg btn-primary w-full">
        Отправить
    </button>
</form>
