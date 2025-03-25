<?php

namespace GIS\ServiceCatalog\Models;

use GIS\Fileable\Traits\ShouldImage;
use GIS\Metable\Traits\ShouldMeta;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model implements ServiceCategoryInterface
{
    use ShouldSlug, ShouldImage, ShouldMeta;

    protected $fillable = [
        "title",
        "slug",
        "priority",
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
