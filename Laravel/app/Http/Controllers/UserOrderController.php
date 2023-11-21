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
        // Validate request and create an order for the user
        // ...
    }

    // Update the specified order for a user
    public function update(Request $request, $userId, $orderId)
    {
        // Update an existing order for the user
        // ...
    }

    // Cancel the specified order for a user
    public function destroy($userId, $orderId)
    {
        $order = Order::where('user_id', $userId)->where('id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found or does not belong to this user'], 404);
        }

        // Logic for canceling the order
        // ...
    }
}
