<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders;
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'items' => 'required|array',
            'notes' => 'sometimes|string|max:255',
        ]);

        // Initialize total price
        $totalPrice = 0;

        // Start a transaction
        \DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'restaurant_id' => $validatedData['restaurant_id'],
                'total_price' => 0, // Temporarily set to 0
                'status' => 'pending',
                'notes' => $validatedData['notes'] ?? null,
            ]);

            foreach ($validatedData['items'] as $item) {
                $dish = Dish::findOrFail($item['dish_id']);
                $itemTotal = $dish->price * $item['quantity'];
                $totalPrice += $itemTotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'dish_id' => $dish->id,
                    'quantity' => $item['quantity'],
                    'price' => $dish->price,
                ]);
            }

            // Update the total price of the order
            $order->update(['total_price' => $totalPrice]);

            // Commit the transaction
            \DB::commit();

            return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            \DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $order = Auth::user()->orders()->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

}

