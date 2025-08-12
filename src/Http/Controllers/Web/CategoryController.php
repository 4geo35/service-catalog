<?php

namespace GIS\ServiceCatalog\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GIS\Metable\Facades\MetaActions;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Models\ServiceCategory;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $metas = MetaActions::renderByPage(config('service-catalog.categoryPagePrefix'));

        $categories = ServiceCategory::query()
            ->with("image")
            ->whereNotNull("published_at")
            ->whereNull("parent_id")
            ->orderBy("priority")
            ->get();

        return view("sc::web.categories.index", compact('metas', "categories"));
    }

    public function show(ServiceCategoryInterface $category): View
    {
        if (! $category->published_at) { abort(404); }
        $metas = MetaActions::renderByModel($category);
        $childrenCategories = $category->children()->whereNotNull("published_at")->orderBy("priority")->get();
        return view("sc::web.categories.show", compact('category', 'metas', 'childrenCategories'));
    }
}
