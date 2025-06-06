<x-guest-layout>

    <!-- Logo Section -->
    <div class="flex justify-center mt-8">
        <img src="{{ asset('uploads/logo/logo_system.png') }}" alt="System Logo" class="h-24 w-auto drop-shadow-md">
    </div>

    <!-- Registration Card -->
    <div class="max-w-md mx-auto mt-6 bg-white p-8 rounded-2xl shadow-xl border border-gray-100 transition-transform hover:scale-[1.01] duration-200">

        <h2 class="text-center text-2xl font-bold text-gray-800">Welcome to UTHM Campus Event Management System👋</h2>
            <p class="text-center text-gray-500 text-sm">Create your account</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full rounded-lg shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full rounded-lg shadow-sm"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg shadow-sm"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Hidden Role -->
            <input type="hidden" name="role" value="student">

            <!-- Buttons -->
            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4 bg-blue-600 hover:bg-blue-700 transition duration-200">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-guest-layout>
