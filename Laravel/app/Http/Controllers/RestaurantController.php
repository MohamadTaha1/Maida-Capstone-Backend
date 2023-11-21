<?php

// app/Http/Controllers/RestaurantController.php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all(); // Or add any logic to filter the restaurants
        return response()->json($restaurants);
    }

    public function show($id)
    {
        $restaurant = Restaurant::find($id); // Retrieves a specific restaurant by ID

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        return response()->json($restaurant);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $restaurants = Restaurant::where('name', 'LIKE', "%{$query}%")
                         ->orWhere('description', 'LIKE', "%{$query}%")
                         ->get();

        return response()->json($restaurants);
    }


}
