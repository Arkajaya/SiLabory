<x-app-layout>
    <div class="py-6 h-dvh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-4xl font-semibold text-[#473472] tracking-wider underline underline-offset-4">Blogs</h1>
                <x-primary-button x-data x-on:click="$dispatch('open-modal','create-blog')">+ Add Blog</x-primary-button>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    <div class="overflow-x-auto">
                    <table class="min-w-full table-auto w-full text-sm text-left">
                        <thead>
                            <tr class="font-bold">
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $blogs->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $blog->title }}</td>
                                    <td class="px-4 py-2">{{ $blog->author?->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $blog->status }}</td>
                                    <td class="px-4 py-2 flex justify-start items-center">
                                        <x-primary-button x-data x-on:click="$dispatch('open-modal','edit-blog-{{ $blog->id }}')" class="py-1 px-2">Edit</x-primary-button>
                                        <span class="mx-2">|</span>
                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="ml-2 text-red-500">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="mt-4">{{ $blogs->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Blog Modal --}}
    <x-modal name="create-blog" :show="false">
        <h2 class="p-6  text-white bg-sky-400 font-bold uppercase tracking-wider">Form | Add Blog</h2>
        <div class="px-6 py-6">
                    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- author: current authenticated user --}} 
                <input type="hidden" name="user_id" value="{{ auth()->id() }}" />
                <div class="mb-2"><x-input-label class="mb-2" value="Title" /><x-text-input name="title" class="w-full" required /></div>
                <div class="mb-2"><x-input-label class="mb-2" value="Content" /><textarea class="rounded-md w-full border-slate-200 shadow-sm" name="content" class="w-full h-40"></textarea></div>
                <div class="mb-2"><x-input-label class="mb-2" value="Status" /><select class="rounded-md w-full border-slate-200 shadow-sm" name="status" class="w-full"><option value="draft">draft</option><option value="published">published</option></select></div>
                <div>
                    <x-input-label class="mb-2" value="Photo" id="photo" />
                    <input class="border border-slate-200 w-full rounded-md" type="file" name="photo" accept="image/*" class="w-full" />
                </div>
                <div class="flex justify-end mt-4"><x-secondary-button x-on:click="$dispatch('close-modal','create-blog')">Cancel</x-secondary-button><x-primary-button class="ml-2">Create</x-primary-button></div>
            </form>
        </div>
    </x-modal>

    {{-- Edit Blog Modals --}}
    @foreach($blogs as $blog)
        <x-modal name="edit-blog-{{ $blog->id }}" :show="false">
            <h2 class="p-4 font-semibold bg-orange-400 text-white">Edit Blog</h2>
            <div class="p-4">
                <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-2">
                        <x-input-label value="Author" />
                        <select name="user_id" class="w-full" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if(old('user_id', $blog->user_id)==$user->id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><x-input-label value="Title" /><x-text-input name="title" class="w-full" value="{{ old('title', $blog->title) }}" required /></div>
                    <div class="mb-2"><x-input-label value="Content" /><textarea name="content" class="w-full h-40">{{ old('content', $blog->content) }}</textarea></div>
                    <div class="mb-2"><x-input-label value="Status" /><select name="status" class="w-full"><option value="draft" @if(old('status', $blog->status)=='draft') selected @endif>draft</option><option value="published" @if(old('status', $blog->status)=='published') selected @endif>published</option></select></div>
                    <div>
                        <x-input-label class="mb-2" value="Photo" id="photo"
                            value="{{ old('photo', $blog->photo) }}" />
                        <input type="file" name="photo" accept="image/*" class="w-full" />
                    </div>
                    <div class="flex justify-end mt-4"><x-secondary-button x-on:click="$dispatch('close-modal','edit-blog-{{ $blog->id }}')">Cancel</x-secondary-button><x-primary-button class="ml-2">Update</x-primary-button></div>
                </form>
            </div>
        </x-modal>
    @endforeach
</x-app-layout>