<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-[#473472] tracking-wider">Activity — Loan History</h1>
                <div class="flex items-center justify-between mb-4">
                           <form method="get" action="{{ route('activities.export') }}" class="flex items-center space-x-2">
                               <label class="text-sm">Month</label>
                               <input type="month" name="month" class="border rounded px-2 py-1 text-sm" value="{{ request()->query('month', now()->format('Y-m')) }}">
                               <button type="submit" class="px-3 py-1 rounded bg-[#473472] text-white text-sm">Export PDF</button>
                           </form>
                   </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                   
                    <table class="w-full text-sm text-left text-body">
                        <thead class="text-sm font-bold text-body bg-neutral-secondary-soft border-b">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">User</th>
                                <th class="px-4 py-2">Loan ID</th>
                                <th class="px-4 py-2">Items</th>
                                <th class="px-4 py-2">Loan Date</th>
                                <th class="px-4 py-2">Return Date</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $loans->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $loan->user?->name ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $loan->id }}</td>
                                    <td class="px-4 py-2">
                                        @foreach($loan->loanDetails as $d)
                                            <div class="text-xs">{{ $d->item?->name ?? ('Item #'.$d->item_id) }} × {{ $d->quantity }}</div>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-2">{{ $loan->loan_date?->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2">{{ $loan->return_date?->format('Y-m-d') ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $loan->status }}</td>
                                    <td class="px-4 py-2">{{ $loan->updated_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $loans->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
