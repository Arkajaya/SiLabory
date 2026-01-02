<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold text-[#473472] mb-2">{{ $blog->title }}</h1>
                <p class="text-sm text-gray-500 mb-4">By {{ $blog->author?->name ?? 'Admin' }} · {{ $blog->created_at->format('M d, Y') }}</p>
                <div class="prose dark:prose-invert max-w-none text-sm">
                    {!! $blog->content !!}
                </div>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
