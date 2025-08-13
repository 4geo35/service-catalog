<?php

use Illuminate\Support\Facades\Route;
use GIS\ServiceCatalog\Http\Controllers\Web\CatalogController;

Route::middleware(["web"])
    ->as("web.service-categories.")
    ->prefix(config("service-catalog.categoryPagePrefix"))
    ->group(function () {
        $catalogControllerClass = config("service-catalog.customCatalogWebController") ?? CatalogController::class;
        Route::get("/", [$catalogControllerClass, "index"])->name("index");
        Route::get("/{category}", [$catalogControllerClass, "category"])->name("show");
    });

Route::middleware(["web"])
    ->as("web.services.")
    ->prefix(config("service-catalog.servicePagePrefix"))
    ->group(function () {
        $catalogControllerClass = config("service-catalog.customCatalogWebController") ?? CatalogController::class;
        Route::get("/{service}", [$catalogControllerClass, "service"])->name("show");
    });
