@extends('components.layout')

@section('main')
    <nav
        class="relative bg-gradient-to-r from-purple-500 to-white after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
        <div class="mx-auto max-w-7xl px-2 py-10 sm:px-6 lg:px-8">
            <div class="relative flex h-16 bg-sky-500 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" command="--toggle" commandfor="mobile-menu"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                            aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                            aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="flex sm:items-stretch sm:justify-start pl-10">
                    <div class="flex shrink-0 items-center bg-amber-400">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="silabory" width="100px" height="250px" />
                        <h2 class="ml-10 text-5xl font-bold">SI LABORY</h2>
                    </div>
                    <div class="hidden sm:ml-6 sm:block bg-gray-500">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                            <a href="#" aria-current="page"
                                class="rounded-md bg-gray-950/50 px-3 py-2 text-sm font-medium text-white">Dashboard</a>
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a>
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Projects</a>
                            <a href="#"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <button type="button"
                        class="relative rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View notifications</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                            aria-hidden="true" class="size-6">
                            <path
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <el-dropdown class="relative ml-3">
                        <button
                            class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt=""
                                class="size-8 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                        </button>

                        <el-menu anchor="bottom end" popover
                            class="w-48 origin-top-right rounded-md bg-gray-800 py-1 outline -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:outline-hidden">Your
                                profile</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:outline-hidden">Settings</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-300 focus:bg-white/5 focus:outline-hidden">Sign
                                out</a>
                        </el-menu>
                    </el-dropdown>
                </div>
            </div>
        </div>

        <el-disclosure id="mobile-menu" hidden class="block sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                <a href="#" aria-current="page"
                    class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">Dashboard</a>
                <a href="#"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a>
                <a href="#"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Projects</a>
                <a href="#"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
            </div>
        </el-disclosure>
    </nav>
    <main>
        <section id="welcome" class=" h-dvh  p-10 flex items-center">
            <div class="w-[60%]">
                <h1 class=" text-9xl font-bold text-shadow-2xs">SI LABORY</h1>
                <p class=" text-4xl ">Sistem Informasi <span class="underline font-semibold">Laboratory Inventory</span></p>
            </div>
        </section>

        <section id="tugas" class="h-dvh p-10 bg-sky-200/25 mb-3">
            <h1 class=" text-4xl font-light"><span class="underline underline-offset-4">Layanan</span> yang ditawarkan</h1>
            <ul class="mt-5 [&_*]:h-38 [&>li]:p-14">
                <li class="w-full h-20 bg-[url('/assets/images/tugas1.png')] text-4xl font-light "><span class="font-semibold">Praktikum</span> Mahasiswa</li>
                <li class="w-full h-20 bg-[url('/assets/images/tugas2.png')] text-4xl font-light  text-right">Peminjaman <span class="font-semibold">Alat</span></li>
                <li class="w-full h-20 bg-[url('/assets/images/tugas3.png')] text-4xl font-light ">Peminjaman <span class="font-semibold">Ruang</span></li>
            </ul>
        </section>

        <section id="news" class="h-[40rem] px-10 mb-5">
            <h3 class="text-4xl text-center py-8"><span class="font-bold">Berita</span> Terkini</h3>
            <div class="flex items-center justify-around [&_*]:shadow-2xl" id="area">
                <div
                    class="w-[25%] max-w-sm bg-white border border-gray-200 shadow-sky-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" src="{{ asset('assets/images/info1.png') }}" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy
                                technology acquisitions 2021</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise
                            technology acquisitions of 2021 so far, in reverse chronological order.</p>
                        <a href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="w-[25%] max-w-sm bg-white border border-gray-200 shadow-sky-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" src="{{ asset('assets/images/info2.png') }}" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy
                                technology acquisitions 2021</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise
                            technology acquisitions of 2021 so far, in reverse chronological order.</p>
                        <a href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="w-[25%] max-w-sm bg-white border border-gray-200 shadow-sky-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" src="{{ asset('assets/images/info3.png') }}" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy
                                technology acquisitions 2021</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise
                            technology acquisitions of 2021 so far, in reverse chronological order.</p>
                        <a href="#"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="staff" class="h-dvh bg-slate-400/40 px-10 shadow-2xl">
            <h3 class="text-4xl text-right py-8">Our <span class="font-bold">Staff</span></h3>

            <div class="flex justify-between">
                <div class="">
                    <div class="">
                        <div id="indicators-carousel" class="relative w-[25%]" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                <!-- Item 1 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                                    <img src="{{ asset('assets/images/info1.png') }}"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="...">
                                </div>
                                <!-- Item 2 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="{{ asset('assets/images/info2.png') }}"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="...">
                                </div>
                                <!-- Item 3 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="{{ asset('assets/images/info3.png') }}"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="...">
                                </div>
                            </div>
                            <!-- Slider indicators -->
                            <div
                                class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="true"
                                    aria-label="Slide 1" data-carousel-slide-to="0"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 2" data-carousel-slide-to="1"></button>
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                    aria-label="Slide 3" data-carousel-slide-to="2"></button>
                            </div>
                            <!-- Slider controls -->
                            <button type="button"
                                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-prev>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button"
                                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-next>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
