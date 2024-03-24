<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'status' => 'required|string',
            'observation' => 'text',
        ]);

        return response()->json(
            Order::create([
                'supplier_id' => $request->supplier_id,
                'status' => $request->status,
                'observation' => $request->observation,
            ])
        );
    }

    public function edit(Order $order)
    {
        return response()->json($order);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'status' => 'required|string',
            'observation' => 'text',
        ]);

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
        return $order ? $order->delete() : false;
    }
}
