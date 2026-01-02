<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Loans Responded</h1>
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
                                        <td class="px-6 py-4">
                                            @php $uid = $loan->user_id ?? $loan->user?->id; @endphp
                                            <a href="{{ $uid ? route('user.detail', ['user_id' => $uid]) : '#' }}">{{ $loan->user?->name ?? '—' }}</a>
                                        </td>
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
                                            @php
                                                $status = strtolower($loan->status ?? '');
                                            @endphp

                                            {{-- If already marked returned, show badge --}}
                                            @if(in_array($status, ['returned','kembali']))
                                                <span class="text-green-600 font-semibold">Returned</span>

                                            {{-- If loan is responded/borrowed, allow marking returned or contacting borrower --}}
                                            @elseif(in_array($status, ['responded','dipinjam','borrowed','dipinjam']))
                                                <form method="POST" action="{{ route('loans.update', $loan->id) }}" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="returned" />
                                                    <button class="text-green-500 hover:text-green-700" type="submit">✓</button>
                                                </form>

                                                {{-- Contact button: prefer phone/WA, fallback to email link --}}

                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            {{-- Replace Edit with Extend (open modal to set new return date) --}}
                                            <x-primary-button
                                                x-data
                                                x-on:click="$dispatch('open-modal', 'extend-loan-{{ $loan->id }}')" class="bg-none text-orange-500"
                                            >
                                                Extend
                                            </x-primary-button>

                                            {{-- Extend modal --}}
                                            <x-modal name="extend-loan-{{ $loan->id }}" :show="false">
                                                <h2 class=" text-white shadow-md uppercase p-6 bg-orange-400 text-xl font-semibold tracking-wider">
                                                    Extend Loan #{{ $loan->id }}
                                                </h2>
                                                <div class="p-6">
                                                    <form method="POST" action="{{ route('loans.update', $loan->id) }}" class="mt-6 space-y-6">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div>
                                                            <x-input-label class="mb-2" value="New Return Date" id="return_date" />
                                                            <x-text-input type="date" name="return_date" class="w-full" value="{{ old('return_date', optional($loan->return_date)->format('Y-m-d')) }}" required />
                                                        </div>
                                                        <div class="flex justify-end mt-6">
                                                            <x-secondary-button x-on:click="$dispatch('close-modal', 'extend-loan-{{ $loan->id }}')">Cancel</x-secondary-button>
                                                            <x-primary-button class="ml-3 bg-orange-400">Extend</x-primary-button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </x-modal>
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