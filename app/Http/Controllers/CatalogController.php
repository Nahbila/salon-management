<?php

namespace App\Http\Controllers;

use App\Models\Service;

class CatalogController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();

        return view('catalog.index', ['services' => $services]);
    }
}