@foreach ($loans as $loan)
    <tr class="bg-neutral-primary border-b border-default">
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{ $loans->firstItem() + $loop->index }}</th>
        <td class="px-6 py-4">{{ $loan->user?->name }}</td>
        <td class="px-6 py-4">
            <div class="max-h-24 overflow-y-auto">
                @foreach($loan->loanDetails as $detail)
                    @if($detail->item)
                        <div>{{ $detail->item->name }} (x{{ $detail->quantity }})</div>
                    @else
                        <div>Item #{{ $detail->item_id }} (x{{ $detail->quantity }})</div>
                    @endif
                @endforeach
            </div>
        </td>
        <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($loan->loan_letter ?? '-', 60) }}</td>
        <td class="px-6 py-4">{{ $loan->status }}</td>
        <td class="px-6 py-4">
            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="approved" />
                <button class="text-green-500 hover:text-green-700" type="submit">Approve</button>
            </form>
            <span class="mx-2">|</span>
            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected" />
                <button class="text-red-500 hover:text-red-700" type="submit">Reject</button>
            </form>
        </td>
    </tr>
@endforeach
