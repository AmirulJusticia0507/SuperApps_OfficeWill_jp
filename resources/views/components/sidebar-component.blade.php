@php
    $isActiveRoute = fn ($routes) => collect((array) $routes)->contains(fn ($route) => request()->routeIs($route));
@endphp


<style>
    aside.app-sidebar { z-index: 1030; width: 16rem; color: #e5e7eb; background: #172554; transition: width .2s ease, transform .2s ease; }
    aside.app-sidebar .sidebar-nav { padding: .75rem; }
    aside.app-sidebar .sidebar-list,
    aside.app-sidebar .sidebar-treeview { margin: 0; padding: 0; list-style: none; }
    aside.app-sidebar .sidebar-treeview { display: none; padding: .2rem 0 .35rem .75rem; }
    aside.app-sidebar .sidebar-treeview.is-open { display: block; }
    aside.app-sidebar .sidebar-link,
    aside.app-sidebar .sidebar-accordion { display: flex; width: 100%; min-height: 2.6rem; align-items: center; gap: .7rem; padding: .55rem .7rem; border: 0; border-radius: .4rem; background: transparent; color: inherit; font-size: .9rem; line-height: 1.25; text-align: left; text-decoration: none; }
    aside.app-sidebar .sidebar-link:hover,
    aside.app-sidebar .sidebar-accordion:hover { background: rgba(255,255,255,.1); color: #fff; text-decoration: none; }
    aside.app-sidebar .sidebar-link.is-active,
    aside.app-sidebar .sidebar-accordion.is-active { background: #2563eb; color: #fff; }
    aside.app-sidebar .sidebar-link > i:first-child,
    aside.app-sidebar .sidebar-accordion > i:first-child { width: 1.2rem; flex: 0 0 1.2rem; text-align: center; }
    aside.app-sidebar .sidebar-accordion__chevron { margin-left: auto; font-size: .75rem; transition: transform .15s ease; }
    aside.app-sidebar .sidebar-accordion[aria-expanded="true"] .sidebar-accordion__chevron { transform: rotate(90deg); }
    aside.app-sidebar .sidebar-sub-link { min-height: 2.35rem; padding-left: .65rem; font-size: .84rem; }
    aside.app-sidebar .sidebar-sub-link > i:first-child { font-size: .8rem; }
    aside.app-sidebar .sidebar-divider { margin: .8rem .5rem; border-color: rgba(255,255,255,.15); }
    aside.app-sidebar .sidebar-footer { margin-top: 1rem; padding-top: .5rem; border-top: 1px solid rgba(255,255,255,.15); }
    aside.app-sidebar .sidebar-user { overflow: hidden; padding: .6rem .7rem; color: #cbd5e1; font-size: .82rem; text-overflow: ellipsis; white-space: nowrap; }
    .sidebar-toggle-outside { position: fixed; top: 1rem; left: 16.5rem; z-index: 99999; display: grid; width: 2.5rem; height: 2.5rem; place-items: center; border: 0; border-radius: .4rem; background: #1e3a8a; color: #fff; box-shadow: 0 .125rem .25rem rgba(0,0,0,.2); cursor: pointer; transition: left .2s ease, background-color .2s ease; }
    .sidebar-toggle-outside:hover { background: #172554; }
    body.sidebar-collapsed aside.app-sidebar { width: 4.5rem; }
    body.sidebar-collapsed aside.app-sidebar .sidebar-label,
    body.sidebar-collapsed aside.app-sidebar .sidebar-logo,
    body.sidebar-collapsed aside.app-sidebar .sidebar-language,
    body.sidebar-collapsed aside.app-sidebar .sidebar-accordion__chevron,
    body.sidebar-collapsed aside.app-sidebar .sidebar-treeview,
    body.sidebar-collapsed aside.app-sidebar .sidebar-user { display: none !important; }
    body.sidebar-collapsed aside.app-sidebar .sidebar-link,
    body.sidebar-collapsed aside.app-sidebar .sidebar-accordion { justify-content: center; padding-right: .5rem; padding-left: .5rem; }
    body.sidebar-collapsed aside.app-sidebar .sidebar-link > i:first-child,
    body.sidebar-collapsed aside.app-sidebar .sidebar-accordion > i:first-child { margin: 0; }
    body.sidebar-collapsed .sidebar-toggle-outside { left: 5rem; }
    .floating-menu {
        position: fixed;
        top: 50%;
        right: .75rem;
        z-index: 1040;
        display: flex;
        width: 6.5rem;
        flex-direction: column;
        transform: translateY(-50%);
        border: 2px solid #6b7280;
        border-radius: .5rem;
        background: #fff;
        box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .25);
        overflow: hidden;
    }
    .floating-menu a {
        display: block;
        padding: .3rem .2rem;
        border-bottom: 1px solid #fff;
        background: #b8cbea;
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        line-height: 1.15;
        text-align: center;
        text-decoration: none;
        text-shadow: 0 1px 1px rgba(0, 0, 0, .35);
    }
    .floating-menu a:first-child,
    .floating-menu a:last-child { background: #17345f; }
    .floating-menu a:hover { filter: brightness(.92); }
    .floating-menu-label { display: none; }
    .floating-menu__handle { display: grid; width: 100%; min-height: 1.5rem; place-items: center; border: 0; background: #17345f; color: #fff; cursor: grab; touch-action: none; }
    .floating-menu__handle:active { cursor: grabbing; }
    .floating-menu__handle:focus-visible { outline: 3px solid #38bdf8; outline-offset: -3px; }
    @media (max-width: 575.98px) {
        aside.app-sidebar { transform: translateX(-100%); }
        body.sidebar-mobile-open aside.app-sidebar { transform: translateX(0); }
        body.sidebar-collapsed aside.app-sidebar { width: 16rem; }
        body.sidebar-collapsed aside.app-sidebar .sidebar-label,
        body.sidebar-collapsed aside.app-sidebar .sidebar-logo,
        body.sidebar-collapsed aside.app-sidebar .sidebar-language,
        body.sidebar-collapsed aside.app-sidebar .sidebar-user { display: revert !important; }
        body.sidebar-collapsed aside.app-sidebar .sidebar-accordion__chevron { display: inline-block !important; }
        body.sidebar-collapsed aside.app-sidebar .sidebar-treeview.is-open { display: block !important; }
        body.sidebar-collapsed aside.app-sidebar .sidebar-link,
        body.sidebar-collapsed aside.app-sidebar .sidebar-accordion { justify-content: flex-start; padding: .55rem .7rem; }
        body.sidebar-collapsed aside.app-sidebar .sidebar-link > i:first-child,
        body.sidebar-collapsed aside.app-sidebar .sidebar-accordion > i:first-child { margin-right: .7rem; }
        .sidebar-toggle-outside { left: 1rem; }
        body.sidebar-collapsed .sidebar-toggle-outside { left: 1rem; }
    }
    .sidebar-link { display: flex; align-items: center; }
    /* CSS untuk spinner */
    .page-spinner {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Warna latar belakang dengan transparan */
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.3);
        border-radius: 50%;
        border-top: 4px solid #007bff;
        /* Warna utama */
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<!-- resources/views/includes/sidebar.blade.php -->
{{-- <aside class="bg-gray-400 h-screen w-64 fixed top-0 left-0 overflow-y-auto"> --}}
<nav class="floating-menu" aria-label="Floating shortcut menu">
    @if ($isSysAdmin || $isEmployeeRegis)
        <button class="floating-menu__handle" type="button" aria-label="Move shortcut menu" title="Drag to move; use arrow keys to reposition"><i class="fas fa-grip-lines" aria-hidden="true"></i></button>
        <a href="{{ route('employee-list') }}">社員一覧</a>
        <a href="{{ route('member-registration.create') }}">社員登録トップ</a>
        <a href="{{ route('member-registration.create') }}#affiliation-information">所属情報</a>
        <a href="{{ route('member-registration.create') }}#basic-information">基本情報</a>
        <a href="{{ route('member-registration.create') }}#account-information">アカウント情報</a>
        <a href="{{ route('member-registration.create') }}#registration">登録</a>
    @endif
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menu = document.querySelector('.floating-menu');
        const handle = menu?.querySelector('.floating-menu__handle');
        if (!menu || !handle) return;

        const positionKey = 'officewill.floating-menu.position';
        let dragging = false;
        let pointerOffsetX = 0;
        let pointerOffsetY = 0;
        let hasCustomPosition = false;

        const clamp = (value, max) => Math.max(0, Math.min(value, max));
        const placeAt = (left, top, persist = false) => {
            const maxLeft = Math.max(0, window.innerWidth - menu.offsetWidth);
            const maxTop = Math.max(0, window.innerHeight - menu.offsetHeight);
            const x = clamp(left, maxLeft);
            const y = clamp(top, maxTop);
            menu.style.left = `${x}px`;
            menu.style.top = `${y}px`;
            menu.style.right = 'auto';
            menu.style.transform = 'none';
            hasCustomPosition = true;
            if (persist) {
                try { localStorage.setItem(positionKey, JSON.stringify({ left: x, top: y })); } catch (_) {}
            }
        };

        try {
            const savedPosition = JSON.parse(localStorage.getItem(positionKey) || 'null');
            if (savedPosition && Number.isFinite(savedPosition.left) && Number.isFinite(savedPosition.top)) {
                placeAt(savedPosition.left, savedPosition.top);
            }
        } catch (_) {}

        handle.addEventListener('pointerdown', function (event) {
            if (event.button !== undefined && event.button !== 0) return;
            const rect = menu.getBoundingClientRect();
            pointerOffsetX = event.clientX - rect.left;
            pointerOffsetY = event.clientY - rect.top;
            dragging = true;
            handle.setPointerCapture(event.pointerId);
            event.preventDefault();
        });

        handle.addEventListener('pointermove', function (event) {
            if (!dragging) return;
            placeAt(event.clientX - pointerOffsetX, event.clientY - pointerOffsetY);
        });

        const stopDragging = function () {
            if (!dragging) return;
            dragging = false;
            const rect = menu.getBoundingClientRect();
            try { localStorage.setItem(positionKey, JSON.stringify({ left: rect.left, top: rect.top })); } catch (_) {}
        };
        handle.addEventListener('pointerup', stopDragging);
        handle.addEventListener('pointercancel', stopDragging);

        handle.addEventListener('keydown', function (event) {
            const movement = { ArrowUp: [0, -12], ArrowDown: [0, 12], ArrowLeft: [-12, 0], ArrowRight: [12, 0] }[event.key];
            if (!movement) return;
            event.preventDefault();
            const rect = menu.getBoundingClientRect();
            placeAt(rect.left + movement[0], rect.top + movement[1], true);
        });

        window.addEventListener('resize', function () {
            if (!hasCustomPosition) return;
            const rect = menu.getBoundingClientRect();
            placeAt(rect.left, rect.top, true);
        });
    });
</script>
<button id="sidebarToggle" type="button" class="sidebar-toggle-outside" aria-label="Toggle sidebar" aria-expanded="true" title="Toggle sidebar"><i class="fas fa-bars"></i></button>

<aside class="app-sidebar bg-blue-900 h-screen w-64 fixed top-0 left-0 overflow-y-auto">
    <nav class="p-4 flex justify-between items-center">
        <div>
            <a href="{{ route('dashboard') }}" class="sidebar-logo text-white text-lg font-semibold">
                <img src="{{ asset('img/dep-service-logo.svg') }}"
                    alt="DEP Service" class="w-32 mx-auto">
            </a>
        </div>
        <!-- &emsp;&emsp;&emsp;<button id="sidebarToggle" class="text-white focus:outline-none"><i class="fas fa-bars fa-lg"></i></button> -->
    </nav>
    <div class="page-spinner" id="page-spinner">
        <div class="spinner"></div>
    </div>
    <nav class="text-white">
        <div class="sidebar-language d-flex justify-content-end gap-1 px-3 py-2 border-bottom border-primary">
            <a class="text-white small" href="{{ route('locale.switch', 'ja') }}">日本語</a>
            <span class="text-white-50">|</span>
            <a class="text-white small" href="{{ route('locale.switch', 'en') }}">English</a>
        </div>
        <div class="sidebar-nav">
        <ul class="sidebar-list">
            <li>
                <a href="{{ route('dashboard') }}" title="{{ __('Dashboard') }}"
                    class="sidebar-link {{ $isActiveRoute('dashboard') ? 'is-active' : '' }}"><i class="fas fa-home"></i><span class="sidebar-label">{{ __('Dashboard') }}</span></a>
            </li>
            @unless ($isLimitedUser)
                <li>
                    <a href="https://outlook.office.com/mail/" target="_blank" rel="noopener noreferrer" title="{{ __('Mail') }}"
                        class="sidebar-link"><i class="fas fa-envelope"></i><span class="sidebar-label">{{ __('Mail') }}</span><i class="fas fa-arrow-up-right-from-square ml-auto text-xs opacity-60" aria-hidden="true"></i></a>
                </li>
            @endunless
            @if ($isSysAdmin)
                <li>
                    <a href="{{ route('company-information.index') }}" title="{{ __('Company Information') }}"
                        class="sidebar-link {{ $isActiveRoute('company-information.*') ? 'is-active' : '' }}"><i class="fas fa-building"></i><span class="sidebar-label">{{ __('Company Information') }}</span></a>
                </li>
            @endif
            @if ($isSysAdmin || $isEmployeeRegis || $isCourseEnroll || $isAttendenceSetting || $isLimitedUser)
                <li>
                    <button type="button" class="sidebar-accordion" aria-expanded="false" title="{{ __('In-house Training') }}"><i class="fas fa-graduation-cap"></i><span class="sidebar-label">{{ __('In-house Training') }}</span><i class="fas fa-chevron-right sidebar-accordion__chevron"></i></button>
                    <ul class="sidebar-treeview">
                        <li>
                            <a href="{{ route('confirm-courses.index') }}" title="Confirm and attend courses"
                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('confirm-courses.*') ? 'is-active' : '' }}"><i class="fas fa-clipboard-check"></i><span class="sidebar-label">{{ __('Confirm and attend courses') }}</span></a>
                        </li>
                        @if ($isSysAdmin || $isCourseEnroll || $isEmployeeRegis || $isLimitedUser)
                            <li>
                                <button type="button" class="sidebar-accordion sidebar-sub-link" aria-expanded="false" title="{{ __('Course Registration') }}"><i class="fas fa-book-open"></i><span class="sidebar-label">{{ __('Course Registration') }}</span><i class="fas fa-chevron-right sidebar-accordion__chevron"></i></button>
                                <ul class="sidebar-treeview">
                                    <!-- <li><a href="{{ route('materials.index') }}" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i class="fas fa-book mr-2"></i>Course Material Registration</a></li> -->
                                    @if ($isSysAdmin || $isCourseEnroll || $isLimitedUser)
                                        <li><a href="{{ route('course-list') }}" title="{{ __('Course List') }}"
                                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute(['course-list', 'course-list.*']) ? 'is-active' : '' }}"><i class="fas fa-list"></i><span class="sidebar-label">{{ __('Course List') }}</span></a></li>
                                    @endif
                                    @if ($isSysAdmin || $isCourseEnroll)
                                        <li><a href="{{ route('course-registration.index') }}"
                                                title="Course Information Registration"
                                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('course-registration.*') ? 'is-active' : '' }}"><i class="fas fa-pen-to-square"></i><span class="sidebar-label">{{ __('Course Information Registration') }}</span></a></li>
                                    @endif
                                    @if ($isSysAdmin || $isEmployeeRegis)
                                        <li><a href="{{ route('course-classification.index') }}"
                                                title="Course classification registration"
                                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('course-classification.index') ? 'is-active' : '' }}"><i class="fas fa-tags"></i><span class="sidebar-label">{{ __('Course Classification Registration') }}</span></a></li>
                                        <li><a href="{{ route('course-classification-details.index') }}"
                                                title="Course classification details registration"
                                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('course-classification-details.*') ? 'is-active' : '' }}"><i class="fas fa-tag"></i><span class="sidebar-label">{{ __('Course Classification Details Registration') }}</span></a></li>
                                    @endif

                                </ul>
                            </li>
                        @endif

                        @if ($isSysAdmin || $isAttendenceSetting)
                            <li>
                                <a href="{{ route('course-settings') }}" title="{{ __('Course Settings') }}"
                                    class="sidebar-link sidebar-sub-link {{ $isActiveRoute('course-settings') ? 'is-active' : '' }}"><i class="fas fa-sliders"></i><span class="sidebar-label">{{ __('Course Settings') }}</span></a>
                            </li>
                        @endif
                        @if ($isSysAdmin || $isAttendenceSetting)
                            <li>
                                <button type="button" class="sidebar-accordion sidebar-sub-link" aria-expanded="false" title="{{ __('Course Inquiries') }}"><i class="fas fa-circle-question"></i><span class="sidebar-label">{{ __('Course Inquiries') }}</span><i class="fas fa-chevron-right sidebar-accordion__chevron"></i></button>
                                <ul class="sidebar-treeview">
                                    <li><a href="{{ route('course-inquiry') }}" title="Course Specific Inquiry"
                                            class="sidebar-link sidebar-sub-link {{ $isActiveRoute('course-inquiry') ? 'is-active' : '' }}"><i class="fas fa-envelope"></i><span class="sidebar-label">{{ __('Course-specific Inquiry') }}</span></a></li>
                                    <li><a href="{{ route('employee-inquiry') }}" title="Employee-Specific Inquiry"
                                            class="sidebar-link sidebar-sub-link {{ $isActiveRoute('employee-inquiry') ? 'is-active' : '' }}"><i class="fas fa-user"></i><span class="sidebar-label">{{ __('Employee-specific Inquiry') }}</span></a></li>
                                    <li><a href="{{ route('course-inquiry.results') }}" title="Course Result Inquiry"
                                            class="sidebar-link sidebar-sub-link {{ $isActiveRoute(['course-inquiry.results', 'course-inquiry.enrollments', 'course-inquiry.responses']) ? 'is-active' : '' }}"><i class="fas fa-square-poll-vertical"></i><span class="sidebar-label">{{ __('Course Result Inquiry') }}</span></a></li>
                                </ul>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif
            @if ($isSysAdmin)
                <li>
                    <button type="button" class="sidebar-accordion" aria-expanded="false" title="{{ __('Employee Management') }}"><i class="fas fa-users-gear"></i><span class="sidebar-label">{{ __('Employee Management') }}</span><i class="fas fa-chevron-right sidebar-accordion__chevron"></i></button>
                    <ul class="sidebar-treeview">
                        <li>
                            <a href="{{ route('affiliation-information.index') }}"
                                title="Affiliation Master Registration"
                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('affiliation-information.*') ? 'is-active' : '' }}"><i class="fas fa-handshake"></i><span class="sidebar-label">{{ __('Affiliation Master Registration') }}</span></a>
                        </li>
                        <li>
                            <a href="{{ route('job-titles.index') }}" title="Job Title Master Registration"
                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('job-titles.*') ? 'is-active' : '' }}"><i class="fas fa-user-tie"></i><span class="sidebar-label">{{ __('Job Title Master Registration') }}</span></a>
                        </li>
                        <li>
                            <a href="{{ route('employee-list') }}" title="Employee list screen"
                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('employee-list') ? 'is-active' : '' }}"><i class="fas fa-users"></i><span class="sidebar-label">{{ __('Employee List') }}</span></a>
                        </li>
                        <li>
                            <a href="{{ route('employee-access-settings.index') }}" title="{{ __('Access Rights Settings') }}"
                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('employee-access-settings.*') ? 'is-active' : '' }}"><i class="fas fa-user-shield"></i><span class="sidebar-label">{{ __('Access Rights Settings') }}</span></a>
                        </li>
                        <li>
                            <a href="{{ route('member-registration.create') }}"
                                title="Employee information registration screen"
                                class="sidebar-link sidebar-sub-link {{ $isActiveRoute('member-registration.*') ? 'is-active' : '' }}"><i class="fas fa-user-plus"></i><span class="sidebar-label">{{ __('Member Registration') }}</span></a>
                        </li>


                    </ul>
                </li>
            @endif

            <li class="sidebar-footer">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link" title="{{ __('Logout') }}"><i class="fas fa-right-from-bracket"></i><span class="sidebar-label">{{ __('Logout') }}</span></button>
                </form>
            </li>
            <li>
                @if (auth()->guard('employee')->check())
                    <span class="sidebar-user" title="{{ auth()->guard('employee')->user()->fullname }}"><i class="fas fa-user mr-2"></i>{{ auth()->guard('employee')->user()->fullname }}</span>
                @elseif(auth()->check())
                    <span class="sidebar-user" title="{{ auth()->user()->name }}"><i class="fas fa-user mr-2"></i>{{ auth()->user()->name }}</span>
                @endif
            </li>
        </ul>
        </div>
    </nav>
</aside>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Skrip JavaScript untuk mengontrol pushmenu -->

<!-- Menambahkan script untuk mengontrol submenu -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const collapsedKey = 'officewill.sidebar.collapsed';
        const setCollapsedState = (collapsed) => {
            document.body.classList.toggle('sidebar-collapsed', collapsed);
            sidebarToggle?.setAttribute('aria-expanded', String(!collapsed));
        };
        const isMobile = window.matchMedia('(max-width: 575.98px)').matches;
        setCollapsedState(!isMobile && localStorage.getItem(collapsedKey) === '1');
        sidebarToggle?.addEventListener('click', function() {
            if (window.matchMedia('(max-width: 575.98px)').matches) {
                const isOpen = document.body.classList.toggle('sidebar-mobile-open');
                sidebarToggle.setAttribute('aria-expanded', String(isOpen));
                return;
            }
            const isCollapsed = !document.body.classList.contains('sidebar-collapsed');
            setCollapsedState(isCollapsed);
            localStorage.setItem(collapsedKey, isCollapsed ? '1' : '0');
        });

        document.querySelectorAll('.sidebar-accordion').forEach(button => {
            const submenu = button.nextElementSibling;
            const containsActiveLink = submenu?.querySelector('.sidebar-link.is-active, .sidebar-accordion.is-active');
            if (containsActiveLink) {
                submenu.classList.add('is-open');
                button.setAttribute('aria-expanded', 'true');
                button.classList.add('is-active');
                const parentList = button.closest('.sidebar-treeview');
                if (parentList) {
                    parentList.classList.add('is-open');
                    const parentButton = parentList.previousElementSibling;
                    parentButton?.setAttribute('aria-expanded', 'true');
                    parentButton?.classList.add('is-active');
                }
            }

            button.addEventListener('click', () => {
                const isOpen = button.getAttribute('aria-expanded') === 'true';
                submenu?.classList.toggle('is-open', !isOpen);
                button.setAttribute('aria-expanded', String(!isOpen));
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const body = document.querySelector("body");
        const pageSpinner = document.getElementById("page-spinner");

        // Function to toggle the sidebar

        // Fungsi untuk menampilkan spinner
        function showSpinner() {
            pageSpinner.style.display = "flex";
        }

        // Fungsi untuk menyembunyikan spinner
        function hideSpinner() {
            pageSpinner.style.display = "none";
        }

        // Tambahkan event listener ke setiap tautan navigasi yang akan menampilkan spinner
        const navLinks = document.querySelectorAll(".sidebar-link[href]");
        navLinks.forEach(function(link) {
            link.addEventListener("click", function() {
                showSpinner();
            });
        });

        // Sembunyikan spinner saat halaman baru dimuat
        window.addEventListener("load", function() {
            hideSpinner();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk menampilkan SweetAlert konfirmasi logout
        function confirmLogout() {
            Swal.fire({
                title: @json(__('Confirm logout')),
                text: @json(__('Are you sure you want to log out?')),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: @json(__('Yes')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman logout.php jika pengguna menekan "Ya"
                    window.location.href = "{{ route('logout') }}";
                }
            });
        }

        // Tambahkan event listener ke tautan "Logout"
        const logoutLink = document.querySelector(".logout-link");
        if (logoutLink) {
            logoutLink.addEventListener("click", function(e) {
                e.preventDefault();
                confirmLogout();
            });
        }

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.navbar-toggler[aria-controls="sidebar"]').on('click', function() {
            $('#sidebar').toggleClass('show');
        });
    });
</script>


