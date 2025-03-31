<div>
     <div class="card">
         <div class="card-body">
             <div class="space-y-indent-half">
                 @include("sc::admin.services.includes.search")
                 <x-tt::notifications.error />
                 <x-tt::notifications.success />
             </div>

             @include("sc::admin.services.includes.table")
             @include("sc::admin.services.includes.table-modals")
         </div>
     </div>
</div>
