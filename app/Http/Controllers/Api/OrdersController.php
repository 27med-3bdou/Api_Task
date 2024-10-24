<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
{
    $orders = Orders::with('deliveries')->get();
    return response()->json($orders);
}

public function show($id)
{
    $order = Orders::with('deliveries')->find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    return response()->json($order);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'delivery_address' => 'required|string|max:255',
        'order_total' => 'required|numeric',
        'order_status' => 'pending,shipped,delivered',
        'delivery_id' => 'nullable|exists:users,id',
    ]);

    $order = Orders::create($validated);

    return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
}

public function update(Request $request, $id)
{
    $order = Orders::find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $validated = $request->validate([
        'customer_name' => 'string|max:255',
        'delivery_address' => 'string|max:255',
        'order_total' => 'numeric',
        'order_status' => 'pending,shipped,delivered',
        'delivery_id' => 'nullable|exists:users,id',
    ]);

    $order->update($validated);

    return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
}

public function destroy($id)
{
    $order = Orders::find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $order->delete();

    return response()->json(['message' => 'Order deleted successfully']);
}

public function assignDeliveryPersonnel(Request $request, Orders $order)
{
    $order->delivery_id = $request->input('delivery_id');
    $order->order_status = 'shipped';
    $order->save();

    return response()->json(['message' => 'Delivery personnel assigned successfully']);
}

}
