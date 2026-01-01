<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl h-dvh mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-base">
                    Hai <span class="font-bold">{{ Auth::user()->name }}</span>, Selamat Datang di Sistem Manajemen Lab Inventory 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
