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
}
