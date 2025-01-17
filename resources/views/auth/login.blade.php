<x-guest-layout>
    <x-auth-card>
        <title>Login</title>
        
        <!-- Judul Form -->
        <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-6 text-green-600" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-6 text-red-600" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                         type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                         type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mt-4">
                <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    {{ __('Remember me') }}
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <x-button class="ml-3 bg-indigo-600 hover:bg-indigo-700 text-white">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
