@props(['location' => 'floating'])
<button id="themeToggle" type="button" class="theme-toggle {{ $location === 'header' ? 'theme-toggle--header' : '' }}" aria-pressed="false">
    <svg id="themeToggleMoon" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 13A8.5 8.5 0 0 1 11 3.2 8.5 8.5 0 1 0 20.8 13Z"/></svg>
    <svg id="themeToggleSun" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></svg>
    <span id="themeToggleLabel">{{ __('Dark mode') }}</span>
</button>
<script>
    (() => {
        const button = document.getElementById('themeToggle');
        const moon = document.getElementById('themeToggleMoon');
        const sun = document.getElementById('themeToggleSun');
        const label = document.getElementById('themeToggleLabel');
        if (!button) return;

        const darkLabel = @json(__('Dark mode'));
        const lightLabel = @json(__('Light mode'));
        const setTheme = (dark) => {
            document.documentElement.classList.toggle('dark-mode', dark);
            document.body.classList.toggle('dark-mode', dark);
            button.setAttribute('aria-pressed', String(dark));
            button.setAttribute('aria-label', dark ? @json(__('Switch to light mode')) : @json(__('Switch to dark mode')));
            button.title = dark ? @json(__('Switch to light mode')) : @json(__('Switch to dark mode'));
            moon.classList.toggle('hidden', dark);
            sun.classList.toggle('hidden', !dark);
            label.textContent = dark ? lightLabel : darkLabel;
        };

        let initialDark = document.documentElement.classList.contains('dark-mode');
        try {
            const savedTheme = localStorage.getItem('officewill.theme');
            initialDark = savedTheme === 'dark' || (savedTheme !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches);
        } catch (_) {}
        setTheme(initialDark);
        button.addEventListener('click', () => {
            const dark = !document.documentElement.classList.contains('dark-mode');
            setTheme(dark);
            try { localStorage.setItem('officewill.theme', dark ? 'dark' : 'light'); } catch (_) {}
        });
    })();
</script>
