<div>
     <div class="card">
         <div class="card-body">
             <div class="space-y-indent-half">
                 @include("sc::admin.services.includes.search")
                 <x-tt::notifications.error prefix="service-" />
                 <x-tt::notifications.success prefix="service-" />
             </div>
         </div>
         @include("sc::admin.services.includes.table")
         @include("sc::admin.services.includes.table-modals")
         @include("sc::admin.services.includes.order-modal")
     </div>
</div>
