<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Loans Submited</h1>
            </div>
            <hr class="my-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                        <table class="w-full text-sm text-left rtl:text-right text-body">
                            <thead class="text-sm font-bold  text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">No</th>
                                    <th scope="col" class="px-6 py-3 font-medium">User</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Id Loan</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Items Loaned</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Return Date</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Status Return</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr class="bg-neutral-primary border-b border-default">
                                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                            {{ $loans->firstItem() + $loop->index }}
                                        </th>
                                        <td class="px-6 py-4"> <a href="{{ route('user.detail', ['user_id' => $loan->user->id]) }}">{{ $loan->user?->name }}</a></td>
                                        <td class="px-6 py-4">{{ $loan->id }}</td>
                                        <td class="px-6 py-4">
                                            <div class="max-h-24 overflow-y-auto">
                                                @foreach($loan->loanDetails as $d)
                                                    @if($d->item)
                                                        <div>{{ $d->item->name }} (x{{ $d->quantity }})</div>
                                                    @else
                                                        <div>Item #{{ $d->item_id }} (x{{ $d->quantity }})</div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">{{ $loan->return_date?->format('Y-m-d') ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="returned" />
                                                <button class="text-green-500 hover:text-green-700" type="submit">✓</button>
                                            </form>
                                            <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;margin-left:8px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="not_returned" />
                                                <button class="text-red-500 hover:text-red-700" type="submit">✕</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">
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
                        <div class="mt-4">
                            {{ $loans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>