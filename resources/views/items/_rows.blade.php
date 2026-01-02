@foreach ($items as $item)
    <tr class="bg-neutral-primary border-b border-default">
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
            {{ $items->firstItem() + $loop->index }}
        </th>
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
            <button x-data x-on:click="$dispatch('open-modal', 'item-detail-{{ $item->id }}')" class="text-left text-indigo-600 hover:text-indigo-800">
                {{ $item->name }}
            </button>
        </th>
        <td class="px-6 py-4">
            {{ $item->category->name ?? '-' }}
        </td>
        <td class="px-6 py-4">
            {{ $item->stock }}
        </td>
        <td class="px-6 py-4">
            <div class="w-20 h-20 mx-auto">
                @if($item->photo)
                <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-20 h-20 sm:w-28 sm:h-28 object-cover rounded-md">
                @else
                <div class="w-20 h-20 sm:w-28 sm:h-28 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center text-sm text-gray-500">No Image</div>
                @endif
            </div>
        </td>
        <td class="px-6 py-4">
            <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
            </form>
            <span class="mx-2">|</span>
            <x-primary-button x-data x-on:click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')" class="bg-none text-orange-500">Edit</x-primary-button>
        </td>
    </tr>
@endforeach
