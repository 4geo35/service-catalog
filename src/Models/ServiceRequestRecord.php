<?php

namespace GIS\ServiceCatalog\Models;

use GIS\RequestForm\Interfaces\CallRequestRecordModelInterface;
use GIS\RequestForm\Traits\ShouldRequestForm;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestRecord extends Model implements CallRequestRecordModelInterface
{
    use ShouldRequestForm;

    protected $fillable = [
        "name",
        "phone",
        "comment",
    ];
}
