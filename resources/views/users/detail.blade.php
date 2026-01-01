<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    <div class="flex items-start gap-6">
                        <div class="flex-1">
                            <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>

                            <div class="mt-4 space-y-2 text-xl">
                                <div><strong>Email:</strong> {{ $user->email }}</div>
                                <div><strong>NIM:</strong> {{ $user->nim ?? '-' }}</div>
                                <div><strong>Study Program:</strong> {{ $user->study_program ?? '-' }}</div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ url()->previous() }}" class="text-sm text-blue-600">&larr; Back</a>
                            </div>
                        </div>

                        <div class="w-48">
                            @if($user->card_identity_photo)
                                <a href="{{ asset('storage/'.$user->card_identity_photo) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$user->card_identity_photo) }}" alt="Card Photo" class="w-48 h-48 object-cover rounded" />
                                </a>
                            @else
                                <div class="w-48 h-48 bg-gray-100 flex items-center justify-center rounded text-sm text-gray-500">No Photo</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
