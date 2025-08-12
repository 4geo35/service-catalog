<?php

namespace GIS\ServiceCatalog\Templates;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class CategoryShow implements ModifierInterface
{
    public function apply(ImageInterface $image): ImageInterface
    {
        return $image->cover(586, 440);
    }
}
