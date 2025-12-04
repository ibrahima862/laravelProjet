<x-guest-layout>
    <div class="main-container">
        <!-- Logo -->
        <div class="logo-container">
            <a href="/">
                <x-application-logo class="logo" />
            </a>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <h2 class="form-title">Register</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Submit -->
                <div class="form-footer">
                    <a href="{{ route('login') }}" class="login-link">Already registered?</a>
                    <x-primary-button class="submit-btn">{{ __('Register') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
