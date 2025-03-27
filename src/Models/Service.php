<?php

namespace GIS\ServiceCatalog\Models;

use GIS\Fileable\Traits\ShouldImage;
use GIS\Metable\Traits\ShouldMeta;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use ShouldSlug, ShouldImage, ShouldMeta, ShouldHumanDate, ShouldHumanPublishDate;

    protected $fillable = [
        "title",
        "slug",
        "short",
        "published_at",
    ];

    public function category(): BelongsTo
    {
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        return $this->belongsTo($categoryModelClass, "category_id");
    }
}
