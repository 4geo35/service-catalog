<?php

namespace GIS\ServiceCatalog\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GIS\Metable\Facades\MetaActions;
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
            ->orderBy("title")
            ->get();

        debugbar()->info($categories);
        return view("sc::web.categories.index", compact('metas', "categories"));
    }
}
