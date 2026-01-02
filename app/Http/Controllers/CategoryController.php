<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $query = Category::orderBy('created_at', 'desc');
        if (! empty($q)) {
            $query->where('name', 'like', '%' . $q . '%')
                  ->orWhere('description', 'like', '%' . $q . '%');
        }

        $categories = $query->paginate(6);

        if ($request->ajax()) {
            return view('categories._rows', compact('categories'))->render();
        }

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
