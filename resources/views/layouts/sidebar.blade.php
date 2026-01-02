<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base ms-3 mt-3 text-sm p-2 focus:outline-none inline-flex sm:hidden">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
        viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
    </svg>
</button>

<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0 bg-white"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default relative ">
            @php
                $submittedCount = \App\Models\Loan::where('status', 'submitted')->count();
            @endphp
        <ul
            class="space-y-2 font-medium [&>li:hover]:shadow-md [&>li:hover]:transition-all  [&>li:hover]:rounded-sm [&>li:hover]:duration-300">
            {{-- User --}}
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group shadow-sm {{ request()->routeIs('dashboard') ? 'bg-slate-100' : '' }}">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>

                <hr class="border-2 border-slate-200 my-2 rounded-md">

                @role('admin')
                <li>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('users.*') ? 'bg-slate-100' : '' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                    </a>
                </li>
            @endrole
             <li>
                <a href="{{ route('blogs.index') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('blogs.*') ? 'bg-slate-100' : '' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Blog</span>
                </a>
            </li>

            </li>
            
            <hr class="my-4">

            <li>
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('categories.*') ? 'bg-slate-100' : '' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Category</span>
                </a>
            </li>
            <li>
            
            <li>
                <a href="{{ route('items.index') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('items.*') ? 'bg-slate-100' : '' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Items</span>
                </a>
            </li>
           
            <li>
                <button type="button" class="flex items-center w-full justify-between px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/></svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Loans</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </button>
                <ul id="dropdown-example" class="@if(request()->routeIs('loans.*') || request()->routeIs('activities.*')) py-2 space-y-2 @else hidden py-2 space-y-2 @endif">
                    <li>
                            <a href="{{ route('loans.submited') }}" class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('loans.submited') ? 'bg-slate-100' : '' }}">
                                <span class="flex-1">Loans Submitted</span>
                                @if($submittedCount > 0)
                                    <span class="inline-flex items-center justify-center w-5 h-5 ms-2 text-xs font-medium text-white bg-red-600 rounded-full">{{ $submittedCount }}</span>
                                @endif
                            </a>
                    </li>
                    <li>
                        <a href="{{ route('loans.responded') }}" class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('loans.responded') ? 'bg-slate-100' : '' }}">Loans Responded</a>
                    </li>
                    <li>
                        <a href="{{ route('activities.index') }}" class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ request()->routeIs('activities.*') ? 'bg-slate-100' : '' }}">Activities</a>
                    </li>
                </ul>
            </li>
        </ul>
        @role('admin')
        <div
            class=" text-center font-medium text-base text-gray-800 dark:text-black-200 absolute bottom-0 left-0 right-0 border-t border-default py-2">
            Admin
        </div>
        @endrole
        @role('asisten')
        <div
            class=" text-center font-medium text-base text-gray-800 dark:text-black-200 absolute bottom-0 left-0 right-0 border-t border-default py-2">
            Asisten
        </div>
        @endrole

    </div>
</aside>

    <!-- Mobile account / logout (show only on small screens, when sidebar is used) -->
    @auth
        <div class="sm:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-default">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-700">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    @endauth

<div class="sm:ml-64 bg-white">
    @include('layouts.navigation')

    <main class="p-4">
        {{ $slot }}
    </main>
</div>
