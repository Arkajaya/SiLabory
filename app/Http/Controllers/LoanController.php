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

    public function indexSubmited(Request $request)
    {
        $q = $request->query('q');
        $query = Loan::with(['user', 'loanDetails.item'])->where('status', 'submitted');
        if (! empty($q)) {
            $query->whereHas('user', function($u) use ($q) {
                $u->where('name', 'like', '%'.$q.'%')->orWhere('email', 'like', '%'.$q.'%');
            })->orWhere('id', 'like', '%'.$q.'%');
        }

        $loans = $query->orderBy('loan_date', 'desc')->paginate(6);
        $users = User::all();
        $items = Item::where('stock', '>', 0)->get();

        if ($request->ajax()) {
            return view('loans._rows_submited', compact('loans'))->render();
        }

        return view('loans.submited', compact('loans', 'users', 'items'));
    }

    public function indexResponded(Request $request)
    {
        $q = $request->query('q');
        $query = Loan::with(['user', 'loanDetails.item'])->whereIn('status', ['responded', 'approved', 'rejected']);
        if (! empty($q)) {
            $query->whereHas('user', function($u) use ($q) {
                $u->where('name', 'like', '%'.$q.'%')->orWhere('email', 'like', '%'.$q.'%');
            })->orWhere('id', 'like', '%'.$q.'%')->orWhere('status', 'like', '%'.$q.'%');
        }

        $loans = $query->orderBy('loan_date', 'desc')->paginate(6);
        $users = User::all();
        $items = Item::where('stock', '>', 0)->get();

        if ($request->ajax()) {
            return view('loans._rows_responded', compact('loans'))->render();
        }

        return view('loans.Responded', compact('loans', 'users', 'items'));
    }

    public function list()
    {
        // list available items for users with optional search
        // accepts `q` query parameter and returns partial for AJAX
        $q = request()->query('q');
        $query = Item::where('stock', '>', 0)->orderBy('created_at', 'desc');
        if (! empty($q)) {
            $query->where(function($b) use ($q) {
                $b->where('name', 'like', '%'.$q.'%')
                  ->orWhere('condition', 'like', '%'.$q.'%');
            });
        }

        $items = $query->paginate(6);

        if (request()->ajax()) {
            return view('users._items_rows', compact('items'))->render();
        }

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

        // keep explicit 'approved' status so activities/reporting show it

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

    /**
     * Show all loan activities for admins/asisten (paginated).
     */
    public function activities(Request $request)
    {
        $q = $request->query('q');
        $query = Loan::with(['user', 'loanDetails.item']);
        if (! empty($q)) {
            $query->whereHas('user', function($u) use ($q) {
                $u->where('name', 'like', '%'.$q.'%')->orWhere('email', 'like', '%'.$q.'%');
            })->orWhere('id', 'like', '%'.$q.'%')->orWhere('status', 'like', '%'.$q.'%');
        }

        $loans = $query->orderBy('updated_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            return view('loans._rows', compact('loans'))->render();
        }

        return view('activities.index', compact('loans'));
    }

    /**
     * Export activities summary for a given month to PDF (or HTML fallback).
     * Accepts `month` as YYYY-MM string, defaults to current month.
     */
    public function exportActivities(Request $request)
    {
        $month = $request->query('month');
        try {
            $start = $month ? Carbon::createFromFormat('Y-m', $month)->startOfMonth() : Carbon::now()->startOfMonth();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid month format. Use YYYY-MM.');
        }

        $end = (clone $start)->endOfMonth();

        $loans = Loan::with(['user', 'loanDetails.item'])
            ->whereBetween('updated_at', [$start->toDateTimeString(), $end->toDateTimeString()])
            ->orderBy('updated_at', 'desc')
            ->get();

        $summary = [
            'total_loans' => $loans->count(),
            'by_status' => $loans->groupBy('status')->map->count()->toArray(),
            'total_items' => $loans->flatMap(fn($l) => $l->loanDetails)->sum('quantity'),
        ];

        $data = compact('loans', 'summary', 'start', 'end');

        $filename = 'activities_summary_' . $start->format('Y_m') . '.pdf';

        // If barryvdh/laravel-dompdf (PDF facade) is available, use it.
        if (class_exists(\Barryvdh\DomPDF\Facade::class) || class_exists(\Barryvdh\DomPDF\PDF::class) || class_exists('PDF')) {
            try {
                $pdf = \PDF::loadView('activities.pdf', $data)->setPaper('a4', 'portrait');
                return $pdf->download($filename);
            } catch (\Exception $e) {
                // fall through to HTML fallback
            }
        }

        // If native dompdf is present, use it
        if (class_exists(\Dompdf\Dompdf::class)) {
            try {
                $html = view('activities.pdf', $data)->render();
                $dompdf = new \Dompdf\Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                return response($dompdf->output(), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]);
            } catch (\Exception $e) {
                // fall through to HTML fallback
            }
        }

        // Fallback: return rendered HTML as a downloadable file and inform user how to enable PDF support.
        $html = view('activities.pdf', $data)->render();
        $fallbackName = 'activities_summary_' . $start->format('Y_m') . '.html';
        $headers = [
            'X-Export-Fallback' => 'To enable real PDF export, run: composer require barryvdh/laravel-dompdf',
        ];

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $fallbackName, $headers);
    }

}
