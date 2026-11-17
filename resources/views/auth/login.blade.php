<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>try { const savedTheme = localStorage.getItem('officewill.theme'); if (savedTheme === 'dark' || (savedTheme !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches)) document.documentElement.classList.add('dark-mode'); } catch (_) {}</script>
    <meta name="theme-color" content="#102a56">
    <link rel="manifest" href="{{ route('pwa.manifest') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/dep-service-logo.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/dep-service-logo.svg') }}">
    <title>{{ __('Login') }}</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center px-4 py-12">
    <x-theme-toggle />
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Language Switcher -->
            <div class="flex justify-end gap-2 mb-6">
                <a class="px-3 py-1 text-sm rounded {{ app()->getLocale() === 'ja' ? 'bg-blue-700 text-white' : 'border border-blue-700 text-blue-700' }}"
                    href="{{ route('locale.switch', 'ja') }}">日本語</a>
                <a class="px-3 py-1 text-sm rounded {{ app()->getLocale() === 'en' ? 'bg-blue-700 text-white' : 'border border-blue-700 text-blue-700' }}"
                    href="{{ route('locale.switch', 'en') }}">English</a>
            </div>

            <!-- Logo / Title -->
            <div class="text-center mb-8">
                <img src="{{ asset('img/dep-service-logo.svg') }}" alt="DEP Service Logo" class="h-16 mx-auto mb-3">
                <h1 class="text-2xl font-bold text-blue-900">DEP Service</h1>
                <p class="text-gray-500 text-sm mt-1">{{ __('Login') }}</p>
            </div>

            <!-- Error Message -->
            @session('error')
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endsession
            @session('success')
                <div role="status" class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endsession

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1" title="{{ __('Email') }}">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1" title="{{ __('Password') }}">{{ __('Password') }}</label>
                    <div class="flex">
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <button class="px-3 border border-l-0 border-gray-300 rounded-r-lg bg-gray-50 hover:bg-gray-100 text-gray-600"
                            type="button" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                {{-- <div class="mb-4 flex items-center gap-2">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded" id="remember" name="remember">
                    <label class="text-sm text-gray-700" for="remember">Remember Me</label>
                </div> --}}

                <div class="text-center mt-6">
                    <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition"
                        title="Login">
                        <i class="fa fa-signin mr-1"></i> {{ __('Log in') }}
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-blue-700 hover:underline text-sm"><i class="fa fa-user-plus mr-1"></i>{{ __('Sign up') }}</a>
                <span class="mx-2 text-gray-300">|</span>
                <a href="{{ route('password.request') }}" title="{{ __('Change password') }}" class="text-blue-700 hover:underline text-sm">
                    <i class="fa fa-key mr-1"></i> {{ __('Change password') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => navigator.serviceWorker.register(@json(route('pwa.service-worker'))));
        }

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
