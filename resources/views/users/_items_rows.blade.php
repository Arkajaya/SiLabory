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

        <x-modal name="item-detail-user-{{ $it->id }}" :show="false">
            <h2 class="p-4 font-semibold bg-indigo-600 text-white">Detail Item</h2>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-full sm:w-40 h-40 bg-gray-100 rounded-md overflow-hidden">
                        @if($it->photo && file_exists(public_path('storage/' . $it->photo)))
                            <img src="{{ asset('storage/' . $it->photo) }}" alt="{{ $it->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">No Image</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-semibold text-[#473472]">{{ $it->name }}</h3>
                        <p class="text-sm text-gray-600">Category: {{ $it->category?->name ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Stock: {{ $it->stock }}</p>
                        <div class="mt-4 text-sm text-gray-700 whitespace-pre-line">{{ $it->condition ?? '-' }}</div>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'item-detail-user-{{ $it->id }}')">Close</x-secondary-button>
                </div>
            </div>
        </x-modal>

        <x-modal name="create-loan-user-{{ $it->id }}" :show="false">
            <h2 class=" text-white shadow-md uppercase p-6 bg-sky-400 text-xl font-semibold tracking-wider">Form | Loan submission</h2>
            <div class="px-6 pb-6">
                <form method="POST" action="{{ route('users.store.loan') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                    <input type="hidden" name="selected_items[]" value="{{ $it->id }}"/>
                    <div class="flex gap-6 *:w-[50%]">
                        <div>
                            <x-input-label class="text-2xl mb-2" value="Loan Date" id="loan_date" />
                            <x-text-input type="date" name="loan_date" class="w-full" required />
                        </div>
                        <div>
                            <x-input-label class="text-2xl mb-2" value="Return Date" id="return_date" />
                            <x-text-input type="date" name="return_date" class="w-full" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label class="text-2xl mb-2" value="Quantity" id="quantity" />
                        <x-text-input type="number" name="quantities[{{ $it->id }}]" class="w-full" min="1" max="{{ $it->stock }}" required />
                    </div>
                    <div>
                        <x-input-label class="text-2xl mb-2" value="Loan Description" id="loan_letter" />
                        <textarea name="loan_letter" class="w-full h-28 text-slate-500 border"></textarea>
                    </div>
                    <div>
                        <x-input-label class="text-2xl mb-2" value="Loan Letter Photo (optional)" id="loan_letter_photo" />
                        <input type="file" name="loan_letter_photo" accept="image/*" class="w-full" />
                    </div>
                    <input type="hidden" name="status" value="submitted" />
                    <div class="flex justify-end mt-6">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'create-loan-user-{{ $it->id }}')">Cancel</x-secondary-button>
                        <x-primary-button class="ml-3 bg-sky-400">Create</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    </li>
@endforeach
