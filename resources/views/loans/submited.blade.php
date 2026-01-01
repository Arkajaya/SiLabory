<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Loans Submited</h1>
                <x-primary-button
                    x-data
                    x-on:click="$dispatch('open-modal', 'create-loan')" class="flex items-center justify-center bg-[#53629E]  px-2 ">
                    <span class="text-xl mr-2">+</span> Add Loan
                </x-primary-button>
            </div>
            <hr class="my-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                        <table class="w-full text-sm text-left rtl:text-right text-body">
                            <thead class="text-sm font-bold  text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">No</th>
                                    <th scope="col" class="px-6 py-3 font-medium">User</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Item Loan</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Loan Perpose</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr class="bg-neutral-primary border-b border-default">
                                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                            {{ $loans->firstItem() + $loop->index }}
                                        </th>
                                        <td class="px-6 py-4"> <a href="{{ route('user.detail', ['user_id' => $loan->user->id]) }}">{{ $loan->user?->name }}</a></td>
                                        
                                        <td class="px-6 py-4">
                                            <div class="max-h-24 overflow-y-auto">
                                                @foreach($loan->loanDetails as $detail)
                                                    @if($detail->item)
                                                        <div>{{ $detail->item->name }} (x{{ $detail->quantity }})</div>
                                                    @else
                                                        <div>Item #{{ $detail->item_id }} (x{{ $detail->quantity }})</div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-between">
                                                <x-primary-button
                                                    x-data
                                                    x-on:click="$dispatch('open-modal', 'preview-loan-{{ $loan->id }}')"
                                                    class="ml-2 bg-gray-200 text-gray-700 py-1 px-2 text-sm"
                                                >
                                                    Preview
                                                </x-primary-button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="responded" />
                                                <button class="text-green-500 hover:text-green-700" type="submit">Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;margin-left:8px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected" />
                                                <button class="text-red-500 hover:text-red-700" type="submit">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $loans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Create Loan Modal --}}
    <x-modal name="create-loan" :show="false">
            <h2 class=" text-white shadow-md uppercase p-6 bg-sky-400 text-xl font-semibold tracking-wider">
                Form | Adding Loan
            </h2>
            
            <div class="p-6">
                <form method="POST" action="{{ route('loans.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label class="mb-2" value="User" id="user_id" />
                        <select name="user_id" class="w-full border rounded-md text-slate-500" required>
                            <option value=""  disabled selected>Select User</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Loan Date" id="loan_date" />
                        <x-text-input type="date" name="loan_date" class="w-full" required />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Select Items to Loan" id="items" />
                        <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border p-2 rounded">
                            @foreach($items as $it)
                                <label class="flex items-center justify-between p-2 border rounded">
                                    <div>
                                        <input type="checkbox" name="selected_items[]" value="{{ $it->id }}" class="mr-2" />
                                        <span class="font-medium">{{ $it->name }}</span>
                                        <div class="text-sm text-slate-500">Stock: {{ $it->stock }}</div>
                                    </div>
                                    <div class="w-20">
                                        <input type="number" name="quantities[{{ $it->id }}]" min="1" max="{{ $it->stock }}" value="1" class="w-full border rounded px-2 py-1" />
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Return Date (optional)" id="return_date" />
                        <x-text-input type="date" name="return_date" class="w-full" />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Loan Description" id="loan_letter" />
                        <textarea name="loan_letter" class="w-full h-28 text-slate-500 border"></textarea>
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Loan Letter Photo (optional)" id="loan_letter_photo" />
                        <input type="file" name="loan_letter_photo" accept="image/*" class="w-full" />
                    </div>

                    <input type="hidden" name="status" value="submitted" />

                    <div class="flex justify-end mt-6">
                        <x-secondary-button
                            x-on:click="$dispatch('close-modal', 'create-loan')"
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
    
    {{-- Edit Loan Modal --}}
    @foreach ($loans as $loan)
        <x-modal name="edit-loan-{{ $loan->id }}" :show="false">
            <h2 class=" text-white shadow-md uppercase p-6 bg-orange-400 text-xl font-semibold tracking-wider">
                Form | Editing Loan
            </h2>
            
            <div class="p-6">
                <form method="POST" action="{{ route('loans.update', $loan->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label class="mb-2" value="User" id="user_id" />
                        <select name="user_id" class="w-full border rounded-md text-slate-500" required>
                            <option value=""  disabled>Select User</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if(old('user_id', $loan->user_id)==$user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Loan Date" id="loan_date" />
                        <x-text-input type="date" name="loan_date" class="w-full" value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" required />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Return Date (optional)" id="return_date" />
                        <x-text-input type="date" name="return_date" class="w-full" value="{{ old('return_date', optional($loan->return_date)->format('Y-m-d')) }}" />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Loan Description" id="loan_letter" />
                        <textarea name="loan_letter" class="w-full h-28 text-slate-500 border">{{ old('loan_letter', $loan->loan_letter) }}</textarea>
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Loan Letter Photo (optional)" id="loan_letter_photo" />
                        <input type="file" name="loan_letter_photo" accept="image/*" class="w-full" />
                        @if($loan->loan_letter_photo)
                            <div class="mt-2 text-sm">Current: <a href="{{ asset('storage/'.$loan->loan_letter_photo) }}" target="_blank">Lihat Foto</a></div>
                        @endif
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-secondary-button
                            x-on:click="$dispatch('close-modal', 'edit-loan-{{ $loan->id }}')"
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

        {{-- Preview Loan Modal --}}
        <x-modal name="preview-loan-{{ $loan->id }}" :show="false">
            <h2 class="text-white shadow-md uppercase p-6 bg-sky-400 text-xl font-semibold tracking-wider">Preview Loan</h2>
            <div class="p-6">
                <div class="space-y-3">
                    <div><strong>User:</strong> {{ $loan->user?->name }}</div>
                    <div><strong>Loan Date:</strong> {{ $loan->loan_date?->format('Y-m-d') }}</div>
                    <div><strong>Return Date:</strong> {{ $loan->return_date?->format('Y-m-d') ?? '-' }}</div>
                    <div><strong>Description:</strong>
                        <div class="mt-2 p-3 bg-neutral-primary rounded">{{ $loan->loan_letter ?? '-' }}</div>
                    </div>
                    <div>
                        <strong>Loan Letter Photo:</strong>
                        @if($loan->loan_letter_photo)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $loan->loan_letter_photo) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $loan->loan_letter_photo) }}" alt="Loan Photo" class="w-48 h-48 object-cover rounded" />
                                </a>
                            </div>
                        @else
                            <div class="mt-2">-</div>
                        @endif
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-secondary-button x-on:click="$dispatch('close-modal', 'preview-loan-{{ $loan->id }}')">Close</x-secondary-button>
                    </div>
                </div>
            </div>
        </x-modal>

    @endforeach

</x-app-layout>