<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|min:8|max:12',
            'title' => 'required|max:128',
            'price' => 'required|numeric',
        ]);

        return response()->json(
            Product::create([
                'code' => $request->code,
                'title' => $request->title,
                'price' => $request->price,
            ])
        );
    }

    public function edit(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|min:8|max:12',
            'title' => 'required|max:128',
            'price' => 'required|numeric',
        ]);

        return response()->json(
            $product->update([
                'code' => $request->code,
                'title' => $request->title,
                'price' => $request->price,
            ])
        );
    }

    public function destroy(Product $product)
    {
        return $product ? $product->delete() : false;
    }
}
