<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>try { const savedTheme = localStorage.getItem('officewill.theme'); if (savedTheme === 'dark' || (savedTheme !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches)) document.documentElement.classList.add('dark-mode'); } catch (_) {}</script>
    <meta name="theme-color" content="#0b1224">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/dep-service-logo.svg') }}">
    <title>{{ __('Register') }} · DEP Service</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen items-start justify-center overflow-x-auto overflow-y-auto bg-slate-950 px-4 py-10 text-slate-900 antialiased sm:items-center">
    <x-theme-toggle />
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden"><div class="absolute -left-32 -top-40 h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl"></div><div class="absolute -bottom-48 -right-24 h-[32rem] w-[32rem] rounded-full bg-blue-600/25 blur-3xl"></div><div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-800/70 via-slate-950 to-slate-950"></div></div>
    <main class="relative z-10 w-full max-w-md">
        <section class="rounded-3xl border border-white/15 bg-white/[0.96] p-6 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-9">
            <a href="{{ route('login') }}" class="mb-8 flex items-center gap-3"><img src="{{ asset('img/dep-service-logo.svg') }}" alt="DEP Service" class="h-11 w-11 rounded-xl object-contain"><div><p class="font-bold tracking-tight text-slate-900">DEP Service</p><p class="text-xs text-slate-500">Learning portal</p></div></a>
            <div class="mb-7"><div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700 ring-1 ring-cyan-100"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m14-14v6m3-3h-6"/><circle cx="10" cy="7" r="4"/></svg></div><h1 class="text-2xl font-bold tracking-tight text-slate-950">{{ __('Create your account') }}</h1><p class="mt-1 text-sm text-slate-500">{{ __('Join DEP Service to get started.') }}</p><p class="mt-2 text-xs leading-5 text-slate-500">{{ __('This creates a learner account. Employee records and course assignments are managed separately.') }}</p></div>
            @if ($errors->any())<div role="alert" class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-3.5 text-sm text-rose-700"><ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div><label for="photo" class="mb-2 block text-sm font-semibold text-slate-700">{{ __('Profile photo') }} <span class="font-normal text-slate-400">({{ __('Optional') }})</span></label><div class="flex items-center gap-4"><div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-100 text-xs font-semibold text-slate-400 ring-1 ring-slate-200"><img id="signup-photo-preview" src="" alt="{{ __('Profile photo preview') }}" class="hidden h-full w-full object-cover"><span id="signup-photo-placeholder">{{ __('Preview') }}</span></div><input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp" class="block min-w-0 flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-cyan-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-cyan-800 hover:border-slate-300"></div><p class="mt-1.5 text-xs text-slate-500">{{ __('JPG, PNG, or WebP. Maximum 2 MB.') }}</p>@error('photo')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="name" class="mb-2 block text-sm font-semibold text-slate-700">{{ __('Name') }}</label><input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus placeholder="{{ __('Your name') }}" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-cyan-500 focus:bg-white focus:ring-4 focus:ring-cyan-500/10">@error('name')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="email" class="mb-2 block text-sm font-semibold text-slate-700">{{ __('Email') }}</label><input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required placeholder="name@company.com" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-cyan-500 focus:bg-white focus:ring-4 focus:ring-cyan-500/10">@error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="password" class="mb-2 block text-sm font-semibold text-slate-700">{{ __('Password') }}</label><div class="relative"><input type="password" id="password" name="password" autocomplete="new-password" required placeholder="••••••••" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-cyan-500 focus:bg-white focus:ring-4 focus:ring-cyan-500/10"><button type="button" data-toggle-password="password" aria-label="{{ __('Show password') }}" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-cyan-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.4-6 9.5-6 9.5 6 9.5 6-3.4 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/></svg></button></div>@error('password')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">{{ __('Confirm Password') }}</label><div class="relative"><input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required placeholder="••••••••" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-cyan-500 focus:bg-white focus:ring-4 focus:ring-cyan-500/10"><button type="button" data-toggle-password="password_confirmation" aria-label="{{ __('Show password') }}" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-cyan-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.4-6 9.5-6 9.5 6 9.5 6-3.4 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/></svg></button></div></div>
                <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-slate-950 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition duration-200 hover:-translate-y-0.5 hover:bg-cyan-800 hover:shadow-cyan-900/20 focus:outline-none focus:ring-4 focus:ring-cyan-500/20">{{ __('Create account') }}<svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></button>
            </form>
            <p class="mt-7 text-center text-sm text-slate-500">{{ __('Already have an account?') }} <a href="{{ route('login') }}" class="font-semibold text-cyan-700 transition hover:text-cyan-900">{{ __('Log in') }}</a></p>
        </section>
    </main>
    <script>document.querySelectorAll('[data-toggle-password]').forEach((button) => button.addEventListener('click', () => { const input = document.getElementById(button.dataset.togglePassword); const visible = input.type === 'password'; input.type = visible ? 'text' : 'password'; button.setAttribute('aria-label', visible ? @json(__('Hide password')) : @json(__('Show password'))); }));</script>
    <script>
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('signup-photo-preview');
        const photoPlaceholder = document.getElementById('signup-photo-placeholder');
        photoInput.addEventListener('change', () => {
            const file = photoInput.files[0];
            if (!file) {
                photoPreview.src = '';
                photoPreview.classList.add('hidden');
                photoPlaceholder.classList.remove('hidden');
                return;
            }
            photoPreview.src = URL.createObjectURL(file);
            photoPreview.classList.remove('hidden');
            photoPlaceholder.classList.add('hidden');
        });
    </script>
</body>
</html>
