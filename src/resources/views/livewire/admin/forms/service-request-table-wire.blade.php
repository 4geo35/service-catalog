<div class="row">
    <div class="col w-full">
        <div class="card">
            <div class="card-body">
                <div class="space-y-indent-half">
                    @include("sc::admin.forms.service-includes.search")
                    <x-tt::notifications.error />
                    <x-tt::notifications.success />
                </div>
            </div>

            @include("sc::admin.forms.service-includes.table")
            @include("rf::admin.forms.includes.delete-modal")
        </div>
    </div>
</div>
