<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Loan;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        return view('loans.index');
    }

    public function list()
    {
        $items = Item::where('stock', '>', 0)->get();
        // dd($items);
        return view('users.loan-show', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
            'loan_letter' => 'nullable|string',
            'loan_letter_photo' => 'nullable|image|max:5120',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:items,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'nullable|integer|min:1',
        ]);
        
        if ($request->hasFile('loan_letter_photo')) {
            $path = $request->file('loan_letter_photo')->store('loans', 'public');
            $validated['loan_letter_photo'] = $path;
        }

        // items data and loan creation inside transaction
        $selected = $request->input('selected_items', []);
        $quantities = $request->input('quantities', []);

        DB::transaction(function () use ($validated, $selected, $quantities) {
            $loanData = $validated;
            unset($loanData['selected_items'], $loanData['quantities']);

            $loan = Loan::create($loanData);

            foreach ($selected as $itemId) {
                $qty = intval($quantities[$itemId] ?? 1);
                if ($qty <= 0) continue;
                $item = Item::find($itemId);
                if (! $item) continue;

                LoanDetail::create([
                    'loan_id' => $loan->id,
                    'item_id' => $item->id,
                    'quantity' => $qty,
                    'condition' => $item->condition,
                ]);

                // decrement stock
                $item->decrement('stock', $qty);
                $item->refresh();
                if ($item->stock <= 0) {
                    $item->item_status = 'borrowed';
                    $item->save();
                }
            }
        });

        return redirect()->back()->with('success', 'Loan created successfully.');
    }

    public function history(Request $request)
    {
        $user = $request->user();
        $loans = Loan::where('user_id', $user->id)
            ->with('loanDetails.item')
            ->orderBy('loan_date', 'desc')
            ->get();

        return view('users.user-loan', compact('loans'));
    }
}
