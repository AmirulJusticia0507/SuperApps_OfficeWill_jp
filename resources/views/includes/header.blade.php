<nav class="app-topbar bg-white shadow">
    @php
        $headerAccount = auth()->guard('employee')->user() ?? auth()->guard('web')->user();
        $headerAccountName = $headerAccount?->fullname ?? $headerAccount?->name;
    @endphp
    <div class="container mx-auto px-6">
        <div class="flex min-h-16 items-center justify-between gap-4 py-2">
            <a href="{{ route('dashboard') }}" class="app-topbar-brand text-sm font-semibold tracking-wide text-slate-700">DEP Service</a>
            <div class="flex items-center gap-3">
                @if ($headerAccount)
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-2 rounded-full text-xs font-medium text-slate-500 transition hover:text-blue-700" title="{{ __('Profile') }}">
                        @if ($headerAccount->profile_photo_path)
                            <img src="{{ asset('storage/' . $headerAccount->profile_photo_path) }}" alt="" class="h-8 w-8 rounded-full object-cover ring-1 ring-slate-200">
                        @else
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-800 ring-1 ring-blue-200">{{ mb_strtoupper(mb_substr($headerAccountName ?: '?', 0, 1)) }}</span>
                        @endif
                        <span class="hidden sm:inline">{{ $headerAccountName }}</span>
                    </a>
                @endif
                <x-theme-toggle location="header" />
            </div>
        </div>
    </div>
</nav>
<div class="app-topbar-spacer" aria-hidden="true"></div>
