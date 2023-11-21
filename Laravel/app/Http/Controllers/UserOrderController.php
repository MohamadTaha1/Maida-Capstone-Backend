<?php
// app/Http/Controllers/UserOrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    // Display a listing of orders for a specific user
    public function index(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $orders = $user->orders; // Assuming a 'orders' relationship exists in the User model
        return response()->json($orders);
    }

    // Display the specified order for a user
    public function show($userId, $orderId)
    {
        $order = Order::where('user_id', $userId)->where('id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found or does not belong to this user'], 404);
        }

        return response()->json($order);
    }

    // Store a newly created order for a user
    public function store(Request $request, $userId)
    {
        $validatedData = $request->validate([
            // Validate your order fields, e.g.:
            'status' => 'required|in:pending,accepted,preparing,on_the_way,delivered,cancelled',
            'total_price' => 'required|numeric',
            // ... other fields
        ]);

        $user = User::findOrFail($userId);
        $order = $user->orders()->create($validatedData);

        return response()->json($order, 201);
    }

    // Update the specified order for a user
    public function update(Request $request, $userId, $orderId)
    {
        $order = Order::where('user_id', $userId)->where('id', $orderId)->firstOrFail();

        $validatedData = $request->validate([
            // Validate your order fields, e.g.:
            'status' => 'sometimes|in:pending,accepted,preparing,on_the_way,delivered,cancelled',
        ]);

        $order->update($validatedData);

        return response()->json($order);
    }

    // Cancel the specified order for a user
    public function destroy($userId, $orderId)
    {
        $order = Order::where('user_id', $userId)->where('id', $orderId)->firstOrFail();
        $order->delete();

        return response()->json(['message' => 'Order cancelled successfully']);
    }
}
