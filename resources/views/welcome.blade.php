    <!DOCTYPE html>
    <html lang="">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inventaris Pro - Manajemen Stok Modern</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        {{-- Jika Anda menggunakan font custom seperti Poppins --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet">


        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="antialiased font-sans bg-white text-gray-800">
        <div class="min-h-screen">
            <header
                class="fixed p-10 bg-white flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full text-sm py-10 shadow-sm">
                <nav class="max-w-7xl w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between text-xl"
                    aria-label="Global">
                    <div class="flex items-center justify-between">
                        <img src="{{ asset('/images/logo.png') }}" alt="" width="100" height="80" class="bg-green-200 me-4">
                        <a class="flex-none text-3xl font-bold text-primary-600 tracking-widest border-l-2 border-primary-600 ps-4" href="#">SILABORY</a>
                    </div>
                    <div class="flex flex-row items-center gap-5 mt-5 sm:justify-end sm:mt-0 sm:ps-5">
                        @auth
                        <a class="font-medium text-gray-600 hover:text-gray-400" href="">Dashboard</a>
                        @else
                        <a class="font-medium text-gray-600 hover:text-gray-400" href="">Login</a>
                        <a class="font-medium text-blue-500 hover:text-sky-400" href="">Register</a>
                        @endauth
                    </div>
                </nav>
            </header>
            <main>
                <section class="px-10">
                    <div class="relative overflow-hidden">
                        <div class="mt-28 max-w-7xl mx-auto  py-24 sm:py-32 w-[60%] inline-block">
                            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800 tracking-tight ">
                                Kendalikan Inventaris Anda
                                <span class="block text-sky-400 mt-2 text-5xl">dengan Ringkas & Mudah</span>
                            </h1>

                            <p class="mt-6 max-w-2xl text-lg text-gray-600 ">
                                Aplikasi manajemen inventaris laboratory modern untuk <span
                                    class="font-semibold">tracking</span> setiap pergerakan barang, dari barang
                                masuk hingga keluar, lengkap dengan laporan analisis.
                            </p>

                            <div class="mt-8 ml-20">
                                <a class="inline-flex items-center gap-x-2 hover:scale-105 hover:bg-slate-400 bg-primary-600 text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-primary-700 transition bg-slate-500"
                                    href="">
                                    Mulai
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" /></svg>
                                </a>
                            </div>
                        </div>
                        <div class="w-[39%] bg-green-300 inline-block rounded-tl-full hover:border-2 hover:border-slate-200 hover:scale-105 duration-150 transition-all">
                            <div
                                class="bg-[url('{{ asset('images/logo.png') }}')] w-100 h-70 bg-contain bg-center bg-no-repeat ">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="area-button flex justify-center box-border border-t-8 border-amber-300  ">
                    <a href=""
                        class="text-xl hover:font-semibold bg-[#473472] p-20 px-26 text-white  w-[30rem] hover:w-[50rem] hover:bg-sky-500 transition-all duration-500 text-center uppercase">Peminjaman
                        Ruang</a>
                    <a href=""
                        class="text-xl hover:font-semibold bg-[#53629E] p-20 px-26 text-white  w-[30rem] hover:w-[50rem] hover:bg-sky-500 transition-all duration-500 text-center uppercase">Peminjaman
                        Alat / Barang</a>
                    <a href=""
                        class="text-xl hover:font-semibold bg-[#87BAC3] p-20 px-26 text-white  w-[30rem] hover:w-[50rem] hover:bg-sky-500 transition-all duration-500 text-center uppercase">Peminjaman
                        Barang</a>
                </div>
                <section id="features" class=" bg-gray-50">
                    <div class="bg-white py-20">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Fitur Unggulan <span
                                        class="text-purple-500">Kami</span></h2>
                                <p class="mt-4 text-lg leading-8 text-gray-600">Semua yang Anda butuhkan dalam satu
                                    platform.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                                <div class="p-6 border border-gray-200 rounded-lg">
                                    <div class="flex-shrink-0 bg-primary-500 rounded-md p-3 w-min mb-4">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Pelacakan Stok Real-time</h3>
                                    <p class="mt-2 text-gray-600">Monitor jumlah stok setiap produk secara akurat saat
                                        barang masuk dan keluar.</p>
                                </div>
                                <div class="p-6 border border-gray-200 rounded-lg">
                                    <div class="flex-shrink-0 bg-primary-500 rounded-md p-3 w-min mb-4">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Notifikasi Stok Menipis</h3>
                                    <p class="mt-2 text-gray-600">Dapatkan peringatan otomatis saat stok produk mencapai
                                        batas minimum, cegah kehabisan barang.</p>
                                </div>

                                <div class="p-6 border border-gray-200 rounded-lg">
                                    <div class="flex-shrink-0 bg-primary-500 rounded-md p-3 w-min mb-4">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.5 6a7.5 7.5 0 100 15 7.5 7.5 0 000-15zM21 21l-5.197-5.197" /></svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Laporan Analitis</h3>
                                    <p class="mt-2 text-gray-600">Akses laporan stok opname, riwayat produk, dan data
                                        penting lainnya untuk pengambilan keputusan.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

                <section id="staff" class="h-dvh bg-slate-400/40 px-10 shadow-2xl shadow-slate-600">
                    <h3 class="text-4xl text-right py-8">Our <span class="font-bold">Staff</span></h3>

                    <div class="flex justify-between">
                        <div class="">
                            <div class="">
                                <div id="indicators-carousel" class="relative w-[25%]" data-carousel="static">
                                    <!-- Carousel wrapper -->
                                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                        <!-- Item 1 -->
                                        <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                                            <img src="{{ asset('images/info1.png') }}"
                                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                                alt="...">
                                        </div>
                                        <!-- Item 2 -->
                                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                            <img src="{{ asset('images/info2.png') }}"
                                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                                alt="...">
                                        </div>
                                        <!-- Item 3 -->
                                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                            <img src="{{ asset('images/info3.png') }}"
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
                                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 6 10">
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
                                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 6 10">
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
            <footer class="bg-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} InventarisPro. Semua Hak Cipta Dilindungi.</p>
                </div>
            </footer>
        </div>
    </body>

    </html>
