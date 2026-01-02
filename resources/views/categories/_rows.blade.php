@foreach ($categories as $category)
    <tr class="bg-neutral-primary border-b border-default">
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{ $categories->firstItem() + $loop->index }}</th>
        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{ $category->name }}</th>
        <td class="px-6 py-4"><div class="max-h-24 overflow-y-auto">{{ $category->description }}</div></td>
        <td class="px-6 py-4 flex justify-center">
            <x-primary-button x-data x-on:click="$dispatch('open-modal', 'edit-category-{{ $category->id }}')" class="bg-none text-orange-500">Edit</x-primary-button>
            <span class="mx-2">|</span>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
