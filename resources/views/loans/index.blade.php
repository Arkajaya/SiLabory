<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-semibold text-[#473472] tracking-wider">Peminjaman Barang</h1>
                <p class="text-sm text-gray-500">Pilih barang lalu ajukan permintaan pinjam. Menunggu approval admin.</p>
            </div>

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-24 h-24 flex-shrink-0">
                                @if($item->photo)
                                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-24 h-24 object-cover rounded-md">
                                @else
                                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center text-sm text-gray-500">No Image</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-[#53629E]">{{ $item->name }}</h3>
                                <p class="text-sm text-gray-500">Kategori: {{ $item->category->name }}</p>
                                <p class="text-sm text-gray-500">Stok: <span class="font-medium">{{ $item->stock }}</span></p>
                                <p class="text-sm mt-2 text-gray-600">{{ \Illuminate\Support\Str::limit($item->condition, 100) }}</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-end gap-3">
                            <x-primary-button x-data x-on:click="$dispatch('open-modal', 'request-item-{{ $item->id }}')" class="bg-[#53629E]">Ajukan</x-primary-button>
                        </div>
                    </div>

                    <!-- Request Modal -->
                    <x-modal name="request-item-{{ $item->id }}" :show="false">
                        <h2 class="text-white uppercase p-6 bg-[#53629E] text-xl font-semibold">Form Pengajuan | {{ $item->name }}</h2>
                        <div class="p-6">
                            <form action="{{ route('loans.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">

                                <div>
                                    <x-input-label class="mb-2" value="Quantity" />
                                    <x-text-input type="number" name="quantity" min="1" max="{{ $item->stock }}" class="w-full" value="1" required />
                                </div>

                                <div class="mt-3">
                                    <x-input-label class="mb-2" value="Tanggal Pinjam" />
                                    <x-text-input type="date" name="loan_date" class="w-full" value="{{ now()->toDateString() }}" required />
                                </div>

                                <div class="mt-3">
                                    <x-input-label class="mb-2" value="Tanggal Kembali" />
                                    <x-text-input type="date" name="return_date" class="w-full" value="{{ now()->addDays(1)->toDateString() }}" required />
                                </div>

                                <div class="flex justify-end mt-6">
                                    <x-secondary-button x-on:click="$dispatch('close-modal', 'request-item-{{ $item->id }}')">Batal</x-secondary-button>
                                    <x-primary-button class="ml-3 bg-[#53629E]">Kirim Permintaan</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </x-modal>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>