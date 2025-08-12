<?php

namespace GIS\ServiceCatalog\Interfaces;

use ArrayAccess;
use GIS\Fileable\Interfaces\ShouldImageInterface;
use GIS\Metable\Interfaces\ShouldMetaInterface;
use GIS\TraitsHelpers\Interfaces\ShouldTreeInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JsonSerializable;
use Stringable;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;

interface ServiceCategoryInterface extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString,
    HasBroadcastChannel, Jsonable, JsonSerializable, QueueableEntity, Stringable, UrlRoutable,
    ShouldImageInterface, ShouldMetaInterface, ShouldTreeInterface
{
    public function services(): HasMany;
    public function parent(): BelongsTo;
    public function children(): HasMany;
}
