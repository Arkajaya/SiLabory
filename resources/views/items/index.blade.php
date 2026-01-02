<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Items List
                </h1>
                <x-primary-button x-data x-on:click="$dispatch('open-modal', 'create-item')"
                    class="flex items-center justify-center bg-[#53629E]  px-2 ">
                    <span class="text-xl mr-2">+</span> Add Item
                </x-primary-button>
            </div>
            <hr class="my-4">
            <div class="w-full bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    <div class="flex items-center justify-between mb-4">
                        <input id="search-items" type="text" placeholder="Cari item..." class="border rounded px-3 py-2 w-64 text-sm" />
                        <div></div>
                    </div>
                    <div class="overflow-x-auto">
                    <table class="min-w-full table-auto w-full text-sm text-left rtl:text-right text-body">
                        <thead
                            class="text-sm font-bold  text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Item Name
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Category Name
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Stock
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Photo
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                            <tbody id="items-table-body">
                                @include('items._rows', ['items' => $items])
                            </tbody>
                        </table>
                        </div>
                        <div class="mt-4">
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($items as $item)
        <x-modal name="item-detail-{{ $item->id }}" :show="false">
            <h2 class="p-4 font-semibold bg-indigo-600 text-white">Detail Item</h2>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-full sm:w-40 h-40 bg-gray-100 rounded-md overflow-hidden">
                        @if($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">No Image</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-semibold text-[#473472]">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-600">Category: {{ $item->category?->name ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Stock: {{ $item->stock }}</p>
                        <div class="mt-4 text-sm text-gray-700 whitespace-pre-line">{{ $item->condition ?? '-' }}</div>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'item-detail-{{ $item->id }}')">Close</x-secondary-button>
                </div>
            </div>
        </x-modal>

        <x-modal name="edit-item-{{ $item->id }}" :show="false">
            <h2 class=" text-white shadow-md uppercase p-6 bg-orange-400 text-xl font-semibold tracking-wider">Form | Editing Item</h2>
            <div class="p-6">
                <form method="POST" action="{{ route('items.update', $item->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div>
                        <x-input-label class="mb-2" value="Item Name" id="name" />
                        <x-text-input name="name" class="w-full" value="{{ old('name', $item->name) }}" required />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Category" id="category_id" />
                        <select name="category_id" class="w-full border rounded-md text-slate-500" required>
                            <option value="" disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category_id', $item->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Stock" id="stock" />
                        <x-text-input name="stock" value="{{ old('stock', $item->stock) }}" class="w-full" required />
                    </div>
                    <div>
                        <x-input-label class="mb-2" value="Item Condition" id="condition" />
                        <textarea name="condition" class="w-full h-40 text-slate-500 border">{{ old('condition', $item->condition) }}</textarea>
                    </div>
                    <div>
                        <x-input-label class="mb-2" value="Current Photo" />
                        @if($item->photo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-28 h-28 object-cover rounded-md">
                            </div>
                        @else
                            <div class="mb-3 w-28 h-28 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center text-sm text-gray-500">No Image</div>
                        @endif
                        <x-input-label class="mb-2 mt-2" value="Replace Photo (optional)" id="photo" />
                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                    </div>
                    <div class="flex justify-end mt-6">
                        <x-primary-button class="ml-3 bg-orange-400">Update</x-primary-button>
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-item-{{ $item->id }}')">Cancel</x-secondary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('search-items');
    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const q = encodeURIComponent(input.value || '');
            fetch(window.location.pathname + '?q=' + q, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => { document.getElementById('items-table-body').innerHTML = html; });
        }, 300);
    });
});
</script>
    {{-- Create Item Modal --}}
    <x-modal name="create-item" :show="false" class="rounded-2xl">
        <h2 class=" text-white shadow-md uppercase p-6 bg-sky-400 text-xl font-semibold tracking-wider">
            Form | Adding Item
        </h2>

        <div class="px-6 pb-6">
            <form method="POST" action="{{ route('items.store') }}" class="mt-6 space-y-6"
                enctype="multipart/form-data">
                @csrf

                <div>
                    <x-input-label class="mb-2" value="Item Name" id="name" />
                    <x-text-input name="name" class="w-full" required />
                </div>

                <div>
                    <x-input-label class="mb-2" value="Category" id="category_id" />
                    <select name="category_id" class="w-full border rounded-md text-slate-500" required>
                        <option value="" disabled selected>Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label class="mb-2" value="Stock" id="stock" />
                    <x-text-input type="number" name="stock" class="w-full" required />
                </div>
                <div>
                    <x-input-label class="mb-2" value="Item Condition" id="condition" />
                    <textarea name="condition" class="w-full h-40 text-slate-500 border"></textarea>
                </div>
                <div>
                    <x-input-label class="mb-2" value="Photo" id="photo" />
                    <input type="file" name="photo" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                </div>
                <div class="flex justify-end mt-6">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'create-item')">
                        Cancel
                    </x-secondary-button>

                    <x-primary-button class="ml-3 bg-sky-400">
                        Create
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

</x-app-layout>
