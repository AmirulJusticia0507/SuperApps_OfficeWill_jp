<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Reset Password') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Language Switcher -->
            <div class="flex justify-end gap-2 mb-6">
                <a class="px-3 py-1 text-sm rounded border border-blue-700 text-blue-700 hover:bg-blue-50"
                    href="{{ route('locale.switch', 'ja') }}">日本語</a>
                <a class="px-3 py-1 text-sm rounded border border-blue-700 text-blue-700 hover:bg-blue-50"
                    href="{{ route('locale.switch', 'en') }}">English</a>
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center w-14 h-14 bg-blue-100 rounded-full mx-auto mb-3">
                    <i class="fas fa-lock text-blue-700 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-blue-900">{{ __('Reset Password') }}</h1>
            </div>

            <!-- Status / Error Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @error('email')
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ $message }}
                </div>
            @enderror

            <p class="text-gray-600 text-sm mb-6">{{ __('Enter your email address and choose a new password.') }}</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
