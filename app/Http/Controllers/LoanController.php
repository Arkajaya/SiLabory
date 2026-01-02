<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Loan;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        // show available items (stock > 0)
        $items = Item::with('category')->where('stock', '>', 0)->paginate(12);
        return view('loans.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['quantity'] > $item->stock) {
            return back()->withErrors(['quantity' => 'Requested quantity exceeds available stock.'])->withInput();
        }

        $loan = Loan::create([
            'user_id' => Auth::id(),
            'loan_date' => Carbon::parse($validated['loan_date']),
            'return_date' => Carbon::parse($validated['return_date']),
            'status' => 'pending',
        ]);

        LoanDetail::create([
            'loan_id' => $loan->id,
            'item_id' => $item->id,
            'quantity' => $validated['quantity'],
            'condition' => $item->condition ?? '',
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan request submitted. Menunggu approval dari admin.');
    }
}
