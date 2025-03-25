<?php

namespace GIS\ServiceCatalog\Livewire\Admin\Categories;

use Illuminate\View\View;
use Livewire\Component;

class CategoryListWire extends Component
{
    public bool $tmpTree = false;

    public function render(): View
    {
        return view('sc::livewire.admin.categories.category-list-wire');
    }
}
