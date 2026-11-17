@extends('layouts.app')

@section('content')
<style>
    .profile-page { min-height: 100vh; background: #f1f5f9; }
    .profile-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .profile-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    html.dark-mode .profile-page { background: #0b1220; }
    html.dark-mode .profile-card { border-color: #273449; background: #172235; }
    html.dark-mode .profile-card h1, html.dark-mode .profile-card h2, html.dark-mode .profile-card label { color: #e2e8f0; }
    html.dark-mode .profile-card input { border-color: #475569; background: #111b2b; color: #e2e8f0; }
    .profile-photo-frame { width: 3.5rem; height: 3.5rem; flex: 0 0 3.5rem; }
    .profile-photo-frame img:not(.hidden) { display: block; width: 100%; height: 100%; max-width: 100%; object-fit: cover; }
    .profile-photo-frame img.hidden { display: none; }
    @media (max-width: 767.98px) {
        .profile-page__content, body.sidebar-collapsed .profile-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="profile-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="profile-page__content space-y-6">
        <nav aria-label="breadcrumb" class="text-sm text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-700">{{ __('Dashboard') }}</a>
            <span class="mx-2">/</span><span class="font-medium text-slate-700">{{ __('Profile') }}</span>
        </nav>

        @if (session('success'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        <section class="profile-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <header class="bg-blue-900 px-6 py-5 text-white">
                <h1 class="text-xl font-bold">{{ __('Profile') }}</h1>
                <p class="mt-1 text-sm text-blue-100">{{ __('Manage your profile photo and password.') }}</p>
            </header>

            <div class="grid gap-6 p-5 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)] lg:p-7">
                <section class="profile-card rounded-xl border border-slate-200 bg-white p-5">
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('Account information') }}</h2>
                    <div class="mt-5 flex items-center gap-4">
                        <div class="profile-photo-frame flex items-center justify-center overflow-hidden rounded-full bg-blue-100 text-xl font-bold text-blue-800 ring-4 ring-blue-50">
                            @if ($profilePhotoUrl)
                                <img id="profile-photo-preview" src="{{ $profilePhotoUrl }}" alt="{{ __('Profile photo') }}" class="h-full w-full object-cover">
                            @else
                                <img id="profile-photo-preview" src="" alt="{{ __('Profile photo preview') }}" class="hidden h-full w-full object-cover">
                                <span id="profile-photo-initial">{{ mb_strtoupper(mb_substr($displayName ?: '?', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-lg font-semibold text-slate-900">{{ $displayName }}</p>
                            <p class="truncate text-sm text-slate-500">{{ $account->email }}</p>
                            <span class="mt-2 inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-800">{{ $isEmployee ? __('Employee') : __('User') }}</span>
                            @if ($isEmployee)
                                <p class="mt-2 text-xs text-slate-500">{{ __('Employee Code') }}: {{ $account->employee_code }}</p>
                            @endif
                        </div>
                    </div>

                    <form id="profile-photo-form" method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="photo" class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('Profile photo') }}</label>
                            <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" data-current-photo="{{ $profilePhotoUrl ?? '' }}" class="block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:font-semibold file:text-blue-800 hover:file:bg-blue-100">
                            <p class="mt-1.5 text-xs text-slate-500">{{ __('JPG, PNG, or WebP. Maximum 2 MB.') }} {{ __('Photo saves automatically after selection.') }}</p>
                            @error('photo')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                            <p id="photo-upload-status" role="status" aria-live="polite" class="mt-2 hidden text-sm font-medium"></p>
                        </div>
                    </form>
                    @if ($profilePhotoUrl)
                        <button type="submit" form="remove-profile-photo" class="mt-3 inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">{{ __('Remove photo') }}</button>
                    @endif
                </section>

                <section class="profile-card rounded-xl border border-slate-200 bg-white p-5">
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('Change password') }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ __('Enter your current password, then choose a new password.') }}</p>

                    <form method="POST" action="{{ route('profile.password.update') }}" class="mt-5 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="current_password" class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('Current password') }}</label>
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password" required class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                            @error('current_password')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('New password') }}</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                            @error('password')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('Confirm new password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                        </div>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-800 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-900"><i class="fas fa-floppy-disk" aria-hidden="true"></i>{{ __('Save password') }}</button>
                    </form>
                </section>
            </div>
        </section>
        @if ($profilePhotoUrl)
            <form id="remove-profile-photo" method="POST" action="{{ route('profile.photo.destroy') }}" class="hidden">@csrf @method('DELETE')</form>
        @endif
    </main>
</div>

@include('includes.footer')

<script>
    (() => {
        const form = document.getElementById('profile-photo-form');
        const input = document.getElementById('photo');
        const preview = document.getElementById('profile-photo-preview');
        const previewInitial = document.getElementById('profile-photo-initial');
        const headerPhoto = document.getElementById('header-profile-photo');
        const headerInitial = document.getElementById('header-profile-initial');
        const status = document.getElementById('photo-upload-status');
        if (!form || !input || !preview || !status) return;

        let savedPhotoUrl = input.dataset.currentPhoto || '';
        const showImage = (image, initial, url) => {
            if (url) {
                image.src = url;
                image.classList.remove('hidden');
                initial?.classList.add('hidden');
            } else {
                image.removeAttribute('src');
                image.classList.add('hidden');
                initial?.classList.remove('hidden');
            }
        };
        const setStatus = (message, isError = false) => {
            status.textContent = message;
            status.classList.remove('hidden', 'text-emerald-700', 'text-rose-600');
            status.classList.add(isError ? 'text-rose-600' : 'text-emerald-700');
        };

        input.addEventListener('change', async () => {
            const file = input.files?.[0];
            if (!file) return;

            const localPreviewUrl = URL.createObjectURL(file);
            showImage(preview, previewInitial, localPreviewUrl);
            setStatus(@json(__('Uploading photo...')));

            const formData = new FormData(form);
            input.disabled = true;
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    },
                    body: formData,
                });
                const result = await response.json().catch(() => ({}));
                if (!response.ok) {
                    throw new Error(result.errors?.photo?.[0] || result.message || @json(__('The profile photo could not be saved.')));
                }

                savedPhotoUrl = result.photo_url;
                input.dataset.currentPhoto = savedPhotoUrl;
                showImage(preview, previewInitial, savedPhotoUrl);
                if (headerPhoto) showImage(headerPhoto, headerInitial, savedPhotoUrl);
                setStatus(result.message || @json(__('Your profile photo has been updated.')));
            } catch (error) {
                showImage(preview, previewInitial, savedPhotoUrl);
                setStatus(error.message || @json(__('The profile photo could not be saved.')), true);
            } finally {
                URL.revokeObjectURL(localPreviewUrl);
                input.disabled = false;
                input.value = '';
            }
        });
    })();
</script>
@endsection
