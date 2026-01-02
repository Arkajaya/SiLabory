<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Loans List</h1>
                <x-primary-button
                    x-data
                    x-on:click="$dispatch('open-modal', 'create-loan')" class="flex items-center justify-center bg-[#53629E]  px-2 ">
                    <span class="text-xl mr-2">+</span> Add Loan
                </x-primary-button>
            </div>
            <hr class="my-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    <div class="overflow-x-auto">
                    <table class="min-w-full table-auto w-full text-sm text-left rtl:text-right text-body">
                            <thead class="text-sm font-bold  text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">No</th>
                                    <th scope="col" class="px-6 py-3 font-medium">User</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Loan Date</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Return Date</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Status</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr class="bg-neutral-primary border-b border-default">
                                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                            {{ $loans->firstItem() + $loop->index }}
                                        </th>
                                        <td class="px-6 py-4">{{ $loan->user?->name }}</td>
                                        <td class="px-6 py-4">{{ $loan->loan_date->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4">{{ $loan->return_date?->format('Y-m-d') ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $loan->status }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                                            </form>
                                            <span class="mx-2">|</span>
                                            <x-primary-button
                                                x-data
                                            x-on:click="$dispatch('open-modal', 'edit-loan-{{ $loan->id }}')" class="bg-none text-orange-500"
                                            >
                                                Edit
                                            </x-primary-button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
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
                <form method="POST" action="{{ route('loans.store') }}" class="mt-6 space-y-6">
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
                        <x-input-label class="mb-2" value="Return Date (optional)" id="return_date" />
                        <x-text-input type="date" name="return_date" class="w-full" />
                    </div>

                    <div>
                        <x-input-label class="mb-2" value="Status" id="status" />
                        <x-text-input name="status" class="w-full" value="dipinjam" />
                    </div>

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
                <form method="POST" action="{{ route('loans.update', $loan->id) }}" class="mt-6 space-y-6">
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
                        <x-input-label class="mb-2" value="Status" id="status" />
                        <x-text-input name="status" class="w-full" value="{{ old('status', $loan->status) }}" />
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

    @endforeach

</x-app-layout>