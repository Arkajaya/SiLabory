<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="nim" :value="__('NIM')" />
            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $user->nim)" />
            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
        </div>

        <div>
            <x-input-label for="study_program" :value="__('Study Program')" />
            <x-text-input id="study_program" name="study_program" type="text" class="mt-1 block w-full" :value="old('study_program', $user->study_program)" />
            <x-input-error class="mt-2" :messages="$errors->get('study_program')" />
        </div>

        <div>
            <x-input-label for="card_identity_photo" :value="__('Card Identity Photo')" />
            @if($user->card_identity_photo)
                <div class="mb-2 flex items-center gap-4">
                    <img id="card-preview-img" src="{{ asset('storage/cards/'.$user->card_identity_photo) }}" alt="Card" class="w-24 h-24 object-cover rounded-md border" />
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Preview size</label>
                        <select id="card-size-select" class="border rounded px-2 py-1 text-sm">
                            <option value="w-16 h-16 object-cover rounded-md border">Small</option>
                            <option value="w-24 h-24 object-cover rounded-md border" selected>Medium</option>
                            <option value="w-40 h-40 object-cover rounded-md border">Large</option>
                        </select>
                    </div>
                </div>
            @else
                <img id="card-preview-img" src="{{ asset('images/dummy1.png') }}" alt="Card" class="w-24 h-24 object-cover rounded-md border mb-2" />
            @endif

            <input id="card_identity_photo" name="card_identity_photo" type="file" class="block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('card_identity_photo')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    // simple size selector for card preview
    document.addEventListener('DOMContentLoaded', function(){
        const select = document.getElementById('card-size-select');
        const img = document.getElementById('card-preview-img');
        if(select && img){
            select.addEventListener('change', function(){
                img.className = this.value; // value contains tailwind classes
            });
        }
    });
</script>
