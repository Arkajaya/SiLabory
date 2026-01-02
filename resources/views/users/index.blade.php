<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Users</h1>
                <x-primary-button x-data x-on:click="$dispatch('open-modal','create-user')">+ Add User</x-primary-button>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    <div class="flex items-center justify-between mb-4">
                        <input id="search-users" type="text" placeholder="Cari user..." class="border rounded px-3 py-2 w-64 text-sm" />
                        <div></div>
                    </div>
                    <div class="overflow-x-auto">
                    <table id="users-table" class="min-w-full table-auto w-full text-sm text-left">
                        <thead>
                            <tr class="font-bold">
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">NIM</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="users-tbody">
                            @include('users._rows', ['users' => $users])
                        </tbody>
                    </table>
                    </div>
                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create User Modal --}}
    <x-modal name="create-user" :show="false">
        <h2 class="p-4 font-semibold bg-sky-400 text-white">Add User</h2>
        <div class="p-4">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2"><x-input-label value="Name" /><x-text-input name="name" class="w-full" required /></div>
                <div class="mb-2"><x-input-label value="Email" /><x-text-input type="email" name="email" class="w-full" required /></div>
                <div class="mb-2"><x-input-label value="Password" /><x-text-input type="password" name="password" class="w-full" required /></div>
                <div class="mb-2"><x-input-label value="NIM" /><x-text-input name="nim" class="w-full" /></div>
                <div class="mb-2"><x-input-label value="Card Photo (optional)" /><input type="file" name="card_identity_photo" accept="image/*" class="w-full" /></div>
                <div class="mb-2"><x-input-label value="Role" />
                    <select name="role" class="w-full border rounded-md text-slate-500">
                        <option value="" selected>-- Select role (optional) --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end mt-4">
                    <x-secondary-button x-on:click="$dispatch('close-modal','create-user')">Cancel</x-secondary-button>
                    <x-primary-button class="ml-2">Create</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- Edit Modals --}}
    @foreach($users as $user)
        <x-modal name="edit-user-{{ $user->id }}" :show="false" class="shadow-lg">
            <h2 class="p-6 text-2xl uppercase font-semibold bg-orange-400 text-white shadow-md">Form | Edit User</h2>
            <div class="p-6 px-8">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-2"><x-input-label value="Name" class="mb-2" /><x-text-input name="name" class="w-full" value="{{ old('name', $user->name) }}" required /></div>
                    <div class="mb-2"><x-input-label value="Email" class="mb-2" /><x-text-input type="email" name="email" class="w-full" value="{{ old('email', $user->email) }}" required /></div>
                    <div class="mb-2"><x-input-label value="Password (leave blank to keep)" class="mb-2" /><x-text-input type="password" name="password" class="w-full" /></div>
                    <div class="flex justify-between items-center gap-4">
                        <div class="mb-2 w-[50%]"><x-input-label value="NIM" class="mb-2"/><x-text-input name="nim" class="w-full" value="{{ old('nim', $user->nim) }}" /></div>
                        <div class="mb-2 w-[50%]"><x-input-label value="Role" class="mb-2"/>
                            <select name="role" class="w-full border rounded-md text-slate-500">
                                <option value="">-- Select role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" @if($user->roles->pluck('name')->contains($role->name)) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-2"><x-input-label value="Card Photo (optional)" /><input type="file" name="card_identity_photo" accept="image/*" class="w-full" />
                        @if($user->card_identity_photo)
                            <div class="mt-2 text-sm">Current: <a href="{{ asset('storage/'.$user->card_identity_photo) }}" target="_blank">View</a></div>
                        @endif
                    </div>
                    <hr>
                    <div class="flex justify-end mt-4">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-user-{{ $user->id }}')">Cancel</x-secondary-button>
                        <x-primary-button class="ml-2">Update</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('search-users');
    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const q = encodeURIComponent(input.value || '');
            fetch(window.location.pathname + '?q=' + q, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => { document.getElementById('users-tbody').innerHTML = html; });
        }, 300);
    });
});
</script>