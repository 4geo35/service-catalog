<?php

namespace GIS\ServiceCatalog\Models;

use GIS\RequestForm\Interfaces\CallRequestRecordModelInterface;
use GIS\RequestForm\Traits\ShouldRequestForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequestRecord extends Model implements CallRequestRecordModelInterface
{
    use ShouldRequestForm;

    protected $fillable = [
        "name",
        "phone",
        "comment",
    ];

    public function service(): BelongsTo
    {
        $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
        return $this->belongsTo($serviceModelClass);
    }
}
