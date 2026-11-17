<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b1224">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/dep-service-logo.svg') }}">
    <title>{{ __('Forgot Password') }} · DEP Service</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-4 py-10 text-slate-900 antialiased">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden"><div class="absolute -left-32 -top-40 h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl"></div><div class="absolute -bottom-48 -right-24 h-[32rem] w-[32rem] rounded-full bg-blue-600/25 blur-3xl"></div><div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-800/70 via-slate-950 to-slate-950"></div></div>
    <main class="relative z-10 w-full max-w-md">
        <section class="rounded-3xl border border-white/15 bg-white/[0.96] p-6 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-9">
            <div class="mb-8 flex items-center justify-between"><a href="{{ route('login') }}" class="flex items-center gap-3"><img src="{{ asset('img/dep-service-logo.svg') }}" alt="DEP Service" class="h-11 w-11 rounded-xl object-contain"><div><p class="font-bold tracking-tight text-slate-900">DEP Service</p><p class="text-xs text-slate-500">Learning portal</p></div></a><nav aria-label="Language" class="flex rounded-full border border-slate-200 bg-slate-50 p-1 text-xs font-semibold"><a class="rounded-full px-3 py-1.5 transition {{ app()->getLocale() === 'ja' ? 'bg-slate-900 text-white shadow' : 'text-slate-500 hover:text-slate-900' }}" href="{{ route('locale.switch', 'ja') }}">日本語</a><a class="rounded-full px-3 py-1.5 transition {{ app()->getLocale() === 'en' ? 'bg-slate-900 text-white shadow' : 'text-slate-500 hover:text-slate-900' }}" href="{{ route('locale.switch', 'en') }}">EN</a></nav></div>
            <div class="mb-7"><div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700 ring-1 ring-cyan-100"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 11v5m0-8h.01"/></svg></div><h1 class="text-2xl font-bold tracking-tight text-slate-950">{{ __('Forgot Password') }}</h1><p class="mt-1 text-sm leading-6 text-slate-500">{{ __('Enter your email to receive a reset link') }}</p></div>
            @if (session('status'))<div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-3.5 text-sm text-emerald-800">{{ session('status') }}</div>@endif
            @if ($errors->any())<div role="alert" class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-3.5 text-sm text-rose-700"><ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div><label for="email" class="mb-2 block text-sm font-semibold text-slate-700">{{ __('Email') }}</label><input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="name@company.com" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-cyan-500 focus:bg-white focus:ring-4 focus:ring-cyan-500/10"></div>
                <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-slate-950 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition duration-200 hover:-translate-y-0.5 hover:bg-cyan-800 focus:outline-none focus:ring-4 focus:ring-cyan-500/20">{{ __('Send reset link') }}<svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></button>
            </form>
            <a href="{{ route('login') }}" class="mt-6 flex items-center justify-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-cyan-800"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h12"/></svg>{{ __('Back to Login') }}</a>
        </section>
    </main>
</body>
</html>
