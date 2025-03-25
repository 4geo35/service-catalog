<?php

use Illuminate\Support\Facades\Route;
use GIS\ServiceCatalog\Http\Controllers\Admin\CategoryController;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix("service-categories")
            ->as("service-categories.")
            ->group(function () {
                $controllerClass = config("service-catalog.customAdminCategoryController") ?? CategoryController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
            });
    });
