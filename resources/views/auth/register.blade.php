<x-guest-layout class="">
    <div class="mx-16 flex *:w-[50%] gap-10 justify-center bg-gray-200/40 rounded-lg shadow-lg px-9 py-8 my-12">
    <div class=" flex justify-center items-center mb-4">
        <img src="{{ asset('logo.png') }}" alt="" class="w-72">
    </div>
    
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="w-full flex *:w[50%] gap-4">
        <!-- NIM -->
            <div class="mt-4">
                <x-input-label for="nim" :value="__('NIM*')" />
                <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" />
                <x-input-error :messages="$errors->get('nim')" class="mt-2" />
            </div>

            <!-- Study Program -->
            <div class="mt-4">
                <x-input-label for="study_program" :value="__('Study Program')" />
                <x-text-input id="study_program" class="block mt-1 w-full" type="text" name="study_program" :value="old('study_program')" required />
                <x-input-error :messages="$errors->get('study_program')" class="mt-2" />
            </div>
        </div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <!-- Card Identity Photo -->
        <div class="mt-4">
            <x-input-label for="card_identity_photo" :value="__('Card Identity Photo (optional)')" />
            <div>
                <x-input-label class="mb-2" value="Photo" id="photo" />
                <input type="file" name="photo" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
            </div>
            <x-input-error :messages="$errors->get('card_identity_photo')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    </div>
</x-guest-layout>

