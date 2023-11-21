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

    // Show the form for creating a new dish
    public function create()
    {
        // return view for creating a new dish
    }

    // Store a newly created dish in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|url',
            'available' => 'required|boolean',
        ]);

        $dish = Dish::create($validatedData);
        return response()->json($dish, 201);
    }

    // Display the specified dish
    public function show($id)
    {
        $dish = Dish::find($id);

        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        return response()->json($dish);
    }

    // Show the form for editing the specified dish
    public function edit($id)
    {
        // return view for editing the dish
    }

    // Update the specified dish in the database
    public function update(Request $request, $id)
    {
        $dish = Dish::find($id);

        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        $validatedData = $request->validate([
            'menu_id' => 'exists:menus,id',
            'name' => 'max:255',
            'description' => '',
            'price' => 'numeric',
            'image' => 'url',
            'available' => 'boolean',
        ]);

        $dish->update($validatedData);
        return response()->json($dish);
    }

    // Remove the specified dish from the database
    public function destroy($id)
    {
        $dish = Dish::find($id);

        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        $dish->delete();
        return response()->json(['message' => 'Dish deleted successfully']);
    }
}
