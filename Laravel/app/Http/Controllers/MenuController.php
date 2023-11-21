<?php
// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Display a listing of all menus
    public function index()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }

    // Show the form for creating a new menu
    public function create()
    {
        // return view for creating a new menu
    }

    // Store a newly created menu in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $menu = Menu::create($validatedData);
        return response()->json($menu, 201);
    }

    // Display the specified menu
    public function show($id)
    {
        $menu = Menu::with('dishes')->find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        return response()->json($menu);
    }

    // Show the form for editing the specified menu
    public function edit($id)
    {
        // return view for editing the menu
    }

    // Update the specified menu in the database
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $validatedData = $request->validate([
            'restaurant_id' => 'exists:restaurants,id',
            'title' => 'max:255',
            'description' => '',
        ]);

        $menu->update($validatedData);
        return response()->json($menu);
    }

    // Remove the specified menu from the database
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $menu->delete();
        return response()->json(['message' => 'Menu deleted successfully']);
    }
}
