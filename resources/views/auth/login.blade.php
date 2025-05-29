<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-indigo-100 flex flex-col justify-center items-center py-10 px-4">
        
        <!-- Logo -->
        <div class="mb-6">
            <img src="{{ asset('uploads/logo/logo_system.png') }}" alt="System Logo" class="h-20 w-auto shadow-md rounded-full">
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-md bg-white shadow-xl rounded-lg p-8 space-y-6 animate-fade-in">
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-sm text-green-600" :status="session('status')" />

            <h2 class="text-center text-2xl font-bold text-gray-800">Welcome to UTHM Campus Event Management System👋</h2>
            <p class="text-center text-gray-500 text-sm">Login to access your dashboard</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:underline">
                            {{ __('Create an Account') }}
                        </a>
                    @endif

                    <x-primary-button class="w-full sm:w-auto justify-center">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Optional Tailwind animation -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
    </style>
</x-guest-layout>
