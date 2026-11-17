<nav class="app-topbar bg-white shadow">
    <div class="container mx-auto px-6">
        <div class="flex min-h-16 items-center justify-between gap-4 py-2">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold tracking-wide text-slate-700">DEP Service</a>
            <div class="flex items-center gap-3">
                @if (auth()->guard('employee')->check())
                    <span class="hidden text-xs font-medium text-slate-500 sm:inline">{{ auth()->guard('employee')->user()->fullname }}</span>
                @elseif (auth()->check())
                    <span class="hidden text-xs font-medium text-slate-500 sm:inline">{{ auth()->user()->name }}</span>
                @endif
                <x-theme-toggle location="header" />
            </div>
        </div>
    </div>
</nav>
<div class="app-topbar-spacer" aria-hidden="true"></div>
