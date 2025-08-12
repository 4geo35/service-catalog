<?php

namespace GIS\ServiceCatalog\Templates;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class MobileCategoryTeaser implements ModifierInterface
{
    public function apply(ImageInterface $image): ImageInterface
    {
        return $image->cover(455, 257);
    }
}
