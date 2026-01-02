@foreach($users as $user)
    <tr class="border-t">
        <td class="px-4 py-2 align-top">{{ $users->firstItem() ? $users->firstItem() + $loop->index : $loop->iteration }}</td>
        <td class="px-4 py-2 align-top">{{ $user->name }}</td>
        <td class="px-4 py-2 align-top">{{ $user->email }}</td>
        <td class="px-4 py-2 align-top">{{ $user->nim ?? '-' }}</td>
        <td class="px-4 py-2 text-center align-top">
            <div class="flex items-center justify-center gap-2">
                <button x-data x-on:click="$dispatch('open-modal','edit-user-{{ $user->id }}')" class="text-sm px-2 py-1 rounded bg-indigo-50 text-indigo-700">Edit</button>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm px-2 py-1 rounded bg-red-50 text-red-700">Delete</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
