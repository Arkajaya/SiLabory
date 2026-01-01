<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->paginate(10);
        $categories = Category::all();
        return view('items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
            'condition' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // generate a unique code for the item
        do {
            $code = 'ITM-'.Str::upper(Str::random(6));
        } while (Item::where('code', $code)->exists());

        $validated['code'] = $code;

        // handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('items', 'public');
            $validated['photo'] = $path;
        }

        dd($validated);
        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }
}
