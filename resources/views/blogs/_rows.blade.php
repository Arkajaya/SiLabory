@foreach($blogs as $blog)
    <tr class="border-t">
        <td class="px-4 py-2">{{ $blogs->firstItem() + $loop->index }}</td>
        <td class="px-4 py-2">{{ $blog->title }}</td>
        <td class="px-4 py-2">{{ $blog->author?->name ?? '-' }}</td>
        <td class="px-4 py-2">{{ $blog->status }}</td>
        <td class="px-4 py-2 flex justify-start items-center">
            <x-primary-button x-data x-on:click="$dispatch('open-modal','edit-blog-{{ $blog->id }}')" class="py-1 px-2">Edit</x-primary-button>
            <span class="mx-2">|</span>
            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button class="ml-2 text-red-500">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
