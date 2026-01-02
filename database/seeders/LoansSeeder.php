<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LoansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ensure at least one user exists
        $user = User::first();
        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Seeder User',
                'email' => 'seeder@example.com',
            ]);
        }

        // ensure some items exist
        if (Item::count() < 3) {
            Item::create([
                'category_id' => 1,
                'name' => 'Projector',
                'code' => 'ITM-PJT-001',
                'stock' => 2,
                'condition' => 'Good',
            ]);
            Item::create([
                'category_id' => 1,
                'name' => 'Microphone',
                'code' => 'ITM-MIC-001',
                'stock' => 5,
                'condition' => 'Good',
            ]);
            Item::create([
                'category_id' => 1,
                'name' => 'Laptop',
                'code' => 'ITM-LAP-001',
                'stock' => 3,
                'condition' => 'Good',
            ]);
        }

        $items = Item::take(5)->get();

        // // create a few loans
        // $loansData = [
        //     [
        //         'user_id' => $user->id,
        //         'loan_date' => Carbon::today()->subDays(3)->toDateString(),
        //         'return_date' => null,
        //         'status' => 'submitted',
        //         'loan_letter' => 'Surat Permohonan 001',
        //     ],
        //     [
        //         'user_id' => $user->id,
        //         'loan_date' => Carbon::today()->subDays(10)->toDateString(),
        //         'return_date' => Carbon::today()->addDays(5)->toDateString(),
        //         'status' => 'responded',
        //         'loan_letter' => 'Surat Permohonan 002',
        //     ],
        //     [
        //         'user_id' => $user->id,
        //         'loan_date' => Carbon::today()->subDays(20)->toDateString(),
        //         'return_date' => Carbon::today()->subDays(2)->toDateString(),
        //         'status' => 'returned',
        //         'loan_letter' => 'Surat Permohonan 003',
        //     ],
        // ];

        // foreach ($loansData as $data) {
        //     $loan = Loan::create($data);

        //     // attach 1-2 loan details
        //     $sampleItems = $items->random(min(2, $items->count()));
        //     foreach ($sampleItems as $it) {
        //         LoanDetail::create([
        //             'loan_id' => $loan->id,
        //             'item_id' => $it->id,
        //             'quantity' => rand(1, min(2, $it->stock ?: 1)),
        //             'condition' => $it->condition,
        //         ]);
        //     }
        // }
    }
}
