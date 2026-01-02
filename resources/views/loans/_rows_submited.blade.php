@foreach ($loans as $loan)
    <tr class="bg-neutral-primary border-b border-default">
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{ $loans->firstItem() + $loop->index }}</th>
        <td class="px-6 py-4"> <a href="{{ route('user.detail', ['user_id' => $loan->user->id]) }}">{{ $loan->user?->name }}</a></td>
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
        <td class="px-6 py-4">
            <div class="flex items-center justify-between">
                <x-primary-button x-data x-on:click="$dispatch('open-modal', 'preview-loan-{{ $loan->id }}')" class="ml-2 bg-gray-200 text-gray-700 py-1 px-2 text-sm">Preview</x-primary-button>
            </div>
        </td>
        <td class="px-6 py-4 text-center">
            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="approved" />
                <button class="text-green-500 hover:text-green-700" type="submit">Approve</button>
            </form>
            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;margin-left:8px;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected" />
                <button class="text-red-500 hover:text-red-700" type="submit">Reject</button>
            </form>
        </td>
    </tr>
@endforeach
