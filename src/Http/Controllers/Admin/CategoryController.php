<?php

namespace GIS\ServiceCatalog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\ServiceCatalog\Interfaces\ServiceCategoryInterface;
use GIS\ServiceCatalog\Models\ServiceCategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        Gate::authorize("viewAny", $categoryModelClass);
        return view("sc::admin.categories.index");
    }

    public function show(ServiceCategoryInterface $category): View
    {
        $categoryModelClass = config("service-catalog.customCategoryModel") ?? ServiceCategory::class;
        Gate::authorize("viewAny", $categoryModelClass);
        return view("sc::admin.categories.show", compact("category"));
    }
}
