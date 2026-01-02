<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Item;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->back()->with('success', 'Loan deleted successfully.');
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'loan_date' => 'sometimes|required|date',
            'return_date' => 'sometimes|nullable|date',
            'status' => 'sometimes|nullable|string|in:submitted,responded,approved,rejected,returned,not_returned',
            'loan_letter' => 'sometimes|nullable|string',
            'loan_letter_photo' => 'sometimes|nullable|image|max:5120',
        ]);

        if ($request->hasFile('loan_letter_photo')) {
            $path = $request->file('loan_letter_photo')->store('loans', 'public');
            $validated['loan_letter_photo'] = $path;
        }

        // map form 'approved' to internal 'responded' so it appears on responded list
        if (isset($validated['status']) && $validated['status'] === 'approved') {
            $validated['status'] = 'responded';
        }

        DB::transaction(function () use ($validated, $loan, $request) {
            $oldStatus = $loan->status;

            // apply updates
            $loan->fill($validated);
            $loan->save();

            // if loan was changed to rejected, restore item stock
            if (isset($validated['status']) && $validated['status'] === 'rejected' && $oldStatus !== 'rejected') {
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
            }

            // if loan was changed to returned, restore item stock (items are back)
            if (isset($validated['status']) && $validated['status'] === 'returned' && $oldStatus !== 'returned') {
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
            }
        });

        return redirect()->back()->with('success', 'Loan updated successfully.');
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
