<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Item::with('category')->orderBy('created_at', 'desc');
        if (! empty($q)) {
            $query->where(function($builder) use ($q) {
                $builder->where('name', 'like', '%' . $q . '%')
                    ->orWhere('code', 'like', '%' . $q . '%')
                    ->orWhereHas('category', function($c) use ($q) {
                        $c->where('name', 'like', '%' . $q . '%');
                    });
            });
        }

        $items = $query->paginate(6);

        if ($request->ajax()) {
            return view('items._rows', compact('items'))->render();
        }

        $categories = Category::all();
        return view('items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
            'condition' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:5120',
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

        Item::create($validated);
        
        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }
    public function destroy(Item $item)
    {
        if ($item->photo && Storage::disk('public')->exists($item->photo)) {
            Storage::disk('public')->delete($item->photo);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'condition' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:5120',
        ]);

        // handle photo replacement
        if ($request->hasFile('photo')) {
            // delete old photo if exists
            if ($item->photo && Storage::disk('public')->exists($item->photo)) {
                Storage::disk('public')->delete($item->photo);
            }

            $path = $request->file('photo')->store('items', 'public');
            $validated['photo'] = $path;
        }

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }
}
