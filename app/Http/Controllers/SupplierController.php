<?php

namespace App\Http\Controllers;

use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index() 
    {
        return response()->json(Supplier::orderBy('name')->get());
    }
}
