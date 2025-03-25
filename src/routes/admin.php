<?php

use Illuminate\Support\Facades\Route;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix("services")
            ->as("services.")
            ->group(function () {
                Route::get("/", function () {
                    return "services";
                });
            });
    });
