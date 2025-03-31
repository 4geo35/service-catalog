<?php

namespace GIS\ServiceCatalog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\ServiceCatalog\Interfaces\ServiceInterface;
use GIS\ServiceCatalog\Models\Service;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
        Gate::authorize("viewAny", $serviceModelClass);
        return view("sc::admin.services.index");
    }

    public function show(ServiceInterface $service): View
    {
        $serviceModelClass = config("service-catalog.customServiceModel") ?? Service::class;
        Gate::authorize("viewAny", $serviceModelClass);
        return view("sc::admin.services.show", compact("service"));
    }
}
