<?php

use Illuminate\Support\Facades\Route;
use GIS\ServiceCatalog\Http\Controllers\Web\CategoryController;

Route::middleware(["web"])
    ->as("web.service-catalog.")
    ->prefix(config("service-catalog.categoryPagePrefix"))
    ->group(function () {
        $catalogControllerClass = config("service-catalog.customCategoryWebController") ?? CategoryController::class;
        Route::get("/", [$catalogControllerClass, "index"])->name("index");
        Route::get("/{category}", [$catalogControllerClass, "show"])->name("show");
    });
