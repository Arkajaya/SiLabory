<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function indexSubmited()
    {
        $loans = Loan::with(['user', 'loanDetails.item'])
            ->where('status', 'submitted')
            ->orderBy('loan_date', 'desc')
            ->paginate(10);
        $users = User::all();
        $items = Item::where('stock', '>', 0)->get();
        return view('loans.submited', compact('loans', 'users', 'items'));
    }

    public function indexResponded()
    {
        $loans = Loan::with(['user', 'loanDetails.item'])
            ->whereIn('status', ['responded', 'rejected'])
            ->orderBy('loan_date', 'desc')
            ->paginate(10);
        $users = User::all();
        $items = Item::where('stock', '>', 0)->get();
        return view('loans.Responded', compact('loans', 'users', 'items'));
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

    public function update(Request $request, Loan $loan)
    {
        // If the request only changes status (approve/reject), validate only status
        if ($request->has('status') && ! $request->has('user_id') && ! $request->hasFile('loan_letter_photo') && ! $request->has('loan_letter')) {
            $validated = $request->validate([
                'status' => 'required|string|max:255',
            ]);

            $oldStatus = $loan->status;
            $newStatus = $validated['status'];

            $loan->update(['status' => $newStatus]);

            // If marking returned, restore item stock and set return_date
            if ($oldStatus !== 'returned' && $newStatus === 'returned') {
                foreach ($loan->loanDetails as $detail) {
                    $item = $detail->item;
                    if (! $item) continue;
                    $item->increment('stock', $detail->quantity);
                    $item->refresh();
                    if ($item->stock > 0) {
                        $item->item_status = 'available';
                        $item->save();
                    }
                }

                if (! $loan->return_date) {
                    $loan->update(['return_date' => Carbon::today()]);
                }
            }

            return redirect()->back()->with('success', 'Loan status updated successfully.');
        }

        // Otherwise perform full update validation
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
            'loan_letter' => 'nullable|string',
            'loan_letter_photo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('loan_letter_photo')) {
            $path = $request->file('loan_letter_photo')->store('loans', 'public');
            $validated['loan_letter_photo'] = $path;
        }

        $loan->update($validated);

        return redirect()->back()->with('success', 'Loan updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->back()->with('success', 'Loan deleted successfully.');
    }
}
