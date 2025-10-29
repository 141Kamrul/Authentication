<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-form-label for="first_name" :value="__('First Name')" required />
            <x-form-input 
                id="first_name" 
                class="block mt-1 w-full" 
                type="text" 
                name="first_name" 
                :value="old('first_name')" 
                required 
                autofocus 
                autocomplete="given-name"
                :error="$errors->has('first_name')"
            />
            <x-form-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-form-label for="last_name" :value="__('Last Name')" required />
            <x-form-input 
                id="last_name" 
                class="block mt-1 w-full" 
                type="text" 
                name="last_name" 
                :value="old('last_name')" 
                required 
                autocomplete="family-name"
                :error="$errors->has('last_name')"
            />
            <x-form-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-form-label for="email" :value="__('Email')" required />
            <x-form-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="email"
                :error="$errors->has('email')"
            />
            <x-form-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-form-label for="password" :value="__('Password')" required />
            <x-form-input 
                id="password" 
                class="block mt-1 w-full"
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                :error="$errors->has('password')"
            />
            <x-form-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-form-label for="password_confirmation" :value="__('Confirm Password')" required />
            <x-form-input 
                id="password_confirmation" 
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
            />
            <x-form-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>