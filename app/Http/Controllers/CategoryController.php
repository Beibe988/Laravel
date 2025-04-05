<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        if (Gate::denies('adminAccess', auth()->user())) {
            return response()->json(['message' => 'Accesso negato'], 403);
        }

        return response()->json(Category::all(), 200);
    }

    public function store(Request $request)
    {
        if (Gate::denies('adminAccess', auth()->user())) {
            return response()->json(['message' => 'Accesso negato'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function update(Request $request, Category $category)
    {
        if (Gate::denies('adminAccess', auth()->user())) {
            return response()->json(['message' => 'Accesso negato'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return response()->json($category, 200);
    }

    public function destroy(Category $category)
    {
        if (Gate::denies('adminAccess', auth()->user())) {
            return response()->json(['message' => 'Accesso negato'], 403);
        }

        $category->delete();
        return response()->json(['message' => 'Categoria eliminata con successo'], 200);
    }
}

