<?php

namespace GIS\ServiceCatalog\Models;

use GIS\Fileable\Traits\ShouldImage;
use GIS\Metable\Traits\ShouldMeta;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\TraitsHelpers\Traits\ShouldMarkdown;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use GIS\TraitsHelpers\Traits\ShouldTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model implements ServiceCategoryInterface
{
    use ShouldSlug, ShouldImage, ShouldMeta, ShouldMarkdown, ShouldTree;

    protected $fillable = [
        "title",
        "slug",
        "short",
        "description",
        "priority",
    ];

}
