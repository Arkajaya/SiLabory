<x-app-layout>
    <div class="py-6 h-dvh">
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
                   <div class="flex items-center justify-between mb-4">
                        <input id="search-activities" type="text" placeholder="Cari aktivitas..." class="border rounded px-3 py-2 w-64 text-sm" />
                        <div></div>
                    </div>
                    <div class="overflow-x-auto">
                    <table id="activities-table" class="min-w-full table-auto w-full text-sm text-left text-body">
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
                        <tbody id="activities-tbody">
                            @include('activities._rows')
                        </tbody>
                    </table>
                    </div>
                    <div class="mt-4">{{ $loans->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('search-activities');
    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const q = encodeURIComponent(input.value || '');
            fetch(window.location.pathname + '?q=' + q, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => { document.getElementById('activities-tbody').innerHTML = html; });
        }, 300);
    });
});
</script>
