<?php

namespace GIS\ServiceCatalog\Interfaces;

use ArrayAccess;
use GIS\Fileable\Interfaces\ShouldImageInterface;
use GIS\Metable\Interfaces\ShouldMetaInterface;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JsonSerializable;
use Stringable;
interface ServiceInterface extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString,
    HasBroadcastChannel, Jsonable, JsonSerializable, QueueableEntity, Stringable, UrlRoutable,
    ShouldImageInterface, ShouldMetaInterface
{
    public function category(): BelongsTo;
}
