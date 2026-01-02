<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Category List</h1>
                <x-primary-button
                    x-data
                    x-on:click="$dispatch('open-modal', 'create-category')" class="flex items-center justify-center bg-[#53629E]  px-2 ">
                    <span class="text-xl mr-2">+</span> Add Category
                </x-primary-button>
            </div>
            <hr class="my-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    <div class="flex items-center justify-between mb-4">
                        <input id="search-categories" type="text" placeholder="Cari kategori..." class="border rounded px-3 py-2 w-64 text-sm" />
                        <div></div>
                    </div>
                    <div class="overflow-x-auto">
                    <table id="categories-table" class="min-w-full table-auto w-full text-sm text-left rtl:text-right text-body">
                            <thead class="text-sm font-bold  text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-medium">
                                        Category Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-medium">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="categories-tbody">
                                @include('categories._rows')
                            </tbody>
                        </table>
                        </div>
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Create Category Modal --}}
    <x-modal name="create-category" :show="false">
            <h2 class=" text-white shadow-md uppercase p-6 bg-sky-400 text-xl font-semibold tracking-wider">
                Form | Adding Category
            </h2>
            
            <div class="p-6">
                <form method="POST" action="{{ route('categories.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label class="mb-2" value="Category Name" id="name" />
                        <x-text-input name="name" class="w-full" required />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Description" id="description"/>
                        <textarea name="description" class="w-full h-40 text-slate-500 border"></textarea>
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-secondary-button
                            x-on:click="$dispatch('close-modal', 'create-category')"
                        >
                            Cancel
                        </x-secondary-button>

                        <x-primary-button class="ml-3 bg-sky-400">
                            Create
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    
    {{-- Edit Category Modal --}}
    @foreach ($categories as $category)
        <x-modal name="edit-category-{{ $category->id }}" :show="false">
            <h2 class=" text-white shadow-md uppercase p-6 bg-orange-400 text-xl font-semibold tracking-wider">
                Form | Adding Category
            </h2>
            
            <div class="p-6">
                <form method="POST" action="{{ route('categories.update', $category->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="name-{{ $category->id }}" class="mb-2" value="Category Name" />
                        <x-text-input id="name-{{ $category->id }}" name="name" class="w-full" value="{{ old('name', $category->name) }}" required />
                    </div>

                    <div>
                        <x-input-label for="description-{{ $category->id }}" class="mb-2" value="Description" />
                        <textarea id="description-{{ $category->id }}" name="description" class="w-full h-40 text-slate-500 border">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-secondary-button
                            x-on:click="$dispatch('close-modal', 'edit-category-{{ $category->id }}')"
                        >
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('search-categories');
        let timer = null;
        input.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const q = encodeURIComponent(input.value || '');
                fetch(window.location.pathname + '?q=' + q, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => { document.getElementById('categories-tbody').innerHTML = html; });
            }, 300);
        });
    });
    </script>