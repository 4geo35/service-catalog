<form wire:submit.prevet="store">
    <x-tt::notifications.error :prefix="$prefix" />
    <x-tt::notifications.success :prefix="$prefix" />
    <x-rf::hidden-wire-field />

    <div class="row">
        <div class="col w-full md:w-1/2 mb-indent-half space-y-indent-half">
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
        </div>

        <div class="col w-full md:w-1/2 mb-indent-half">
            <textarea id="comment-{{ $formName }}{{ $modal ? 'modal-' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}"
                      class="form-control !min-h-27 {{ $errors->has('comment') ? 'border-danger' : '' }}"
                      rows="10" placeholder="Комментарий"
                      wire:model.live="comment">
            {{ $comment }}
        </textarea>
            <x-tt::form.error name="comment"/>
        </div>
    </div>

    <div class="flex items-center flex-wrap sm:flex-nowrap">
        <button type="submit" class="btn btn-lg btn-primary mr-indent-half">
            Отправить
        </button>
        <div class="form-check order-first sm:order-last mb-indent-half sm:mb-0">
            @php($privacyUrl = \Illuminate\Support\Facades\Route::has("web.privacy-policy") ?  route('web.privacy-policy') : "#")
            <input type="checkbox" wire:model="privacy"
                   required
                   id="privacy-{{ $formName }}{{ $modal ? '-modal' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}"
                   class="form-check-input shrink-0 {{ $errors->has('privacy') ? 'border-danger' : '' }}" />
            <label for="privacy-{{ $formName }}{{ $modal ? '-modal' : '' }}{{ ! empty($postfix) ? '-' . $postfix : '' }}" class="form-check-label">
                @include("tt::policy.check-text")
            </label>
        </div>
    </div>
</form>
