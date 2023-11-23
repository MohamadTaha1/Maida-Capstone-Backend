<?php
namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    // Display a listing of all dishes
    public function index()
    {
        $dishes = Dish::all();
        return response()->json($dishes);
    }

    // Store a newly created dish in the database
    public function store(Request $request)
    {
        // Validation code remains the same

        $menu = Menu::with('restaurant')->find($validatedData['menu_id']);

        if (!$menu || $menu->restaurant->owner_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $dish = Dish::create($validatedData);
        return response()->json($dish, 201);
    }


    // Update the specified dish in the database
    public function update(Request $request, $id)
    {
        $dish = Dish::with('menu.restaurant')->find($id);

        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        if ($dish->menu->restaurant->owner_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validation and update code remains the same
    }

    // Remove the specified dish from the database

    public function destroy(Dish $dish)
    {
        if ($dish->menu->restaurant->owner_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $dish->delete();
        return response()->json(['message' => 'Dish deleted successfully']);
    }

}
