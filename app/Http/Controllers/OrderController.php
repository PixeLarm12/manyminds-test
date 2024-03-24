<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::active()->get());
    }

    public function finished()
    {
        return response()->json(Order::finished()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'products' => 'required|array',
        ]);

        $order = Order::create([
            'supplier_id' => $request->supplier_id,
            'status' => Order::ORDER_STATUS_ACTIVE,
            'observation' => $request->observation,
        ]);

        foreach($request->products as $product) {
            $order->products()->attach($product['id'], [
                'amount' => $product['amount'],
                'unit_price' => $product['price'],
                'total_price' => $product['totalItemPrice'],
            ]);
        }

        return response()->json($order);
    }

    public function edit(Order $order)
    {
        return response()->json([
            'order' => $order,
            'products' => $order->products()
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        $order->update([
            'supplier_id' => $request->supplier_id,
            'status' => $request->status,
            'observation' => $request->observation,
        ]);

        foreach($request->products as $product) {
            $order->products()->sync($product['id'], [
                'amount' => $product['amount'],
                'unit_price' => $product['price'],
                'total_price' => $product['totalItemPrice'],
            ]);
        }

        return response()->json(
            $order->update([
                'supplier_id' => $request->supplier_id,
                'status' => $request->status,
                'observation' => $request->observation,
            ])
        );
    }

    public function destroy(Order $order)
    {
        if(! $order) {
            return false;
        }
        
        return $order->delete();
    }
}
