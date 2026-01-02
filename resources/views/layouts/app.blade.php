<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-sky-300/20 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">

            @role('admin|asisten')
                @include('layouts.sidebar')
            @endrole
            

            {{-- <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset --}}

            <!-- Page Content -->
            {{-- <main>
                {{ $slot }}
            </main>
             --}}
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    @if(session('success'))
                        Swal.fire({
                            icon: 'success',
                            title: {!! json_encode(session('success')) !!},
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    @endif

                    @if(session('error'))
                        Swal.fire({
                            icon: 'error',
                            title: {!! json_encode(session('error')) !!},
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    @endif

                    @if($errors->any())
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation error',
                            text: {!! json_encode($errors->first()) !!},
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                        });
                    @endif
                    
                    document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault()

                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'This data cannot be recovered!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit()
                            }
                        })
                    })
                })
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
            <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
        </div>
    </body>
</html>
