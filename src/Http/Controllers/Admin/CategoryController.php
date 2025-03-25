<?php

namespace GIS\ServiceCatalog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view("sc::admin.categories.index");
    }
}
