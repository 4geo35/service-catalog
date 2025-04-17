<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Categories;

use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Traits\CategoryEditActions;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowWire extends Component
{
    use WithFileUploads, WireDeleteImageTrait;
    use CategoryEditActions;

    public ServiceCategoryInterface $category;

    public function render(): View
    {
        return view('sc::livewire.admin.categories.show-wire');
    }
}
