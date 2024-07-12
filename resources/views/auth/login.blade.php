<x-app-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <x-form-input name="email" :currentValue="old('email')" :inputAttributes="[
            'required' => true,
            'autofocus' => true,
            'autocomplete' => 'username',
        ]" />

        <x-form-input name="password" type="password" :inputAttributes="[
            'required' => true,
            'autocomplete' => 'current-password',
        ]" />

        <x-form-input name="remember_me" type="checkbox" />

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="btn btn-primary">Log In</button>
        </div>
    </form>
</x-app-layout>
