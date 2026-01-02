@foreach($items as $it)
    <li class="max-w-80 col-span-2 divide-y divide-gray-200 rounded-lg bg-white shadow">
        <div class="flex w-full items-center justify-between space-x-6 p-6">
            <div class="flex-1 truncate">
                <div class="flex items-center space-x-3">
                    <button x-data x-on:click="$dispatch('open-modal', 'item-detail-user-{{ $it->id }}')" class="truncate text-sm font-medium text-gray-900 text-left hover:text-indigo-600">{{ $it->name }}</button>
                    <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-400 px-1.5 py-0.5 text-xs font-medium text-white ring-1 ring-inset ring-green-600/20">available</span>
                </div>
                <p class="mt-1 truncate text-sm text-gray-500">Stock : <span class="font-bold">{{ $it->stock }}</span></p>
            </div>
            @php
                $img = $it->photo ?? null;
                if ($img && file_exists(public_path('storage/' . $img))) {
                    $imgsrc = asset('storage/' . $img);
                } else {
                    $imgsrc = asset('images/dummy1.png');
                }
            @endphp
            <img class="h-10 w-10 flex-shrink-0 rounded-2xl bg-gray-300 object-cover" src="{{ $imgsrc }}" alt="">
        </div>
        <div>
            <x-primary-button x-data x-on:click="$dispatch('open-modal', 'create-loan-user-{{ $it->id }}')" class="bg-none text-orange-500 w-full rounded-none rounded-b-lg text-center py-2 bg-green-400">Borrowed</x-primary-button>
        </div>
    </li>
@endforeach
