@foreach ($loans as $loan)
    <tr class="bg-neutral-primary border-b border-default">
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{ $loans->firstItem() + $loop->index }}</th>
        <td class="px-6 py-4">{{ $loan->user?->name }}</td>
        <td class="px-6 py-4">{{ $loan->loan_date?->format('Y-m-d') }}</td>
        <td class="px-6 py-4">{{ $loan->return_date?->format('Y-m-d') ?? '-' }}</td>
        <td class="px-6 py-4">{{ $loan->status }}</td>
        <td class="px-6 py-4">
            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display:inline;" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
            </form>
            <span class="mx-2">|</span>
            <x-primary-button x-data x-on:click="$dispatch('open-modal', 'edit-loan-{{ $loan->id }}')" class="bg-none text-orange-500">Edit</x-primary-button>
        </td>
    </tr>
@endforeach
