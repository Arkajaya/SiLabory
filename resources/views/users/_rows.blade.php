@foreach($users as $user)
    <tr class="border-t">
        <td class="px-4 py-2">{{ $users->firstItem() + $loop->index }}</td>
        <td class="px-4 py-2"><a href="{{ route('user.detail', ['user_id' => $user->id]) }}">{{ $user->name }}</a></td>
        <td class="px-4 py-2">{{ $user->email }}</td>
        <td class="px-4 py-2">{{ $user->nim ?? '-' }}</td>
        <td class="px-4 py-2 flex justify-start items-center">
            <x-primary-button x-data x-on:click="$dispatch('open-modal', 'edit-user-{{ $user->id }}')" class="py-1 px-2">Edit</x-primary-button>
            <span class="mx-2">|</span>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button class="ml-2 text-red-500">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
