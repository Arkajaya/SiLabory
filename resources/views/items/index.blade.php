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
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    <table class="w-full text-sm text-left rtl:text-right text-body">
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
                                    Condition
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Photo
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr class="bg-neutral-primary border-b border-default">
                                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                        {{ $items->firstItem() + $loop->index }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                        {{ $item->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $item->category->name }}
                                    </td>
                                    <td class="px-2 py-4">
                                        {{ $item->stock }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->condition }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="w-20 h-20 mx-auto">
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}"
                                                class="w-20 h-20 object-cover rounded-md">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                            style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                                        </form>
                                        <span class="mx-2">|</span>
                                        <x-primary-button x-data
                                            x-on:click="$dispatch('open-modal', 'edit-item-{{ $item->id }}')"
                                            class="bg-none text-orange-500">
                                            Edit
                                        </x-primary-button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


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
                    <x-input-label class="mb-2" value="Item Condition (opsional)" id="condition" />
                    <textarea name="condition" class="w-full h-40 text-slate-500 border"></textarea>
                </div>
                <div>
                    <x-input-label class="mb-2" value="Photo" id="photo" />
                    <input type="file" name="photo" accept="image/*" class="w-full" />
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

    {{-- Edit Item Modal --}}
    @foreach ($items as $item)
        <x-modal name="edit-item-{{ $item->id }}" :show="false">
            <h2 class=" text-white shadow-md uppercase p-6 bg-orange-400 text-xl font-semibold tracking-wider">
                Form | Editing Item
            </h2>


            <div class="p-6">
                <form method="POST" action="{{ route('items.update', $item->id) }}" class="mt-6 space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label class="mb-2" value="Item Name" id="name" />
                        <x-text-input name="name" class="w-full" value="{{ old('name', $item->name) }}"
                            required />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Category" id="category_id" />
                        <select name="category_id" value="{{ old('category_id', $item->category_id) }}"
                            class="w-full border rounded-md text-slate-500">
                            <option value="" disabled selected>
                                {{ old('category_id', $item->category->name) }}
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Stock" id="stock" />
                        <x-text-input type="number" name="stock" value="{{ old('stock', $item->stock) }}" class="w-full"
                            required />
                    </div>
                    <div>
                        <x-input-label class="mb-2" value="Item Condition" id="condition" />
                        <textarea name="condition" class="w-full h-40 text-slate-500 border">{{ old('condition', $item->condition) }}</textarea>
                    </div>
                    <div>
                        <x-input-label class="mb-2" value="Photo" id="photo"
                            value="{{ old('photo', $item->photo) }}" />
                        <input type="file" name="photo" accept="image/*" class="w-full" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-item-{{ $item->id }}')">
                            Cancel
                        </x-secondary-button>

                        <x-primary-button class="ml-3 bg-orange-400">
                            Update
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

</x-app-layout>
