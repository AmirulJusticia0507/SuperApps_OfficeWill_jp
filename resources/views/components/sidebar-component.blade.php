@php
    $pageActive = function ($pageName) {
        return request()->is($pageName) ? 'active' : '';
    };
@endphp


<style>
    aside.app-sidebar { z-index: 1030; }
    body.sidebar-collapsed aside.app-sidebar { transform: translateX(-100%) !important; }
    body.sidebar-collapsed aside.app-sidebar .sidebar-label,
    body.sidebar-collapsed aside.app-sidebar .sidebar-logo { display: none; }
    body.sidebar-collapsed aside.app-sidebar .sidebar-link { justify-content: center; padding-left: .75rem; padding-right: .75rem; }
    body.sidebar-collapsed main.content-with-sidebar { margin-left: 4.5rem; }
    aside.app-sidebar { transition: transform .2s ease; }
    .sidebar-toggle-outside { position: fixed; top: 1rem; left: 16.5rem; z-index: 99999; width: 2.5rem; height: 2.5rem; border: 0; border-radius: .375rem; background: #1e3a8a; color: #fff; box-shadow: 0 .125rem .25rem rgba(0,0,0,.2); cursor: pointer; transition: left .2s ease, background-color .2s ease; }
    .sidebar-toggle-outside:hover { background: #172554; }
    body.sidebar-collapsed .sidebar-toggle-outside { left: 1rem; }
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
<button id="sidebarToggle" type="button" class="sidebar-toggle-outside" aria-label="Toggle sidebar" aria-expanded="true" title="Toggle sidebar"><i class="fas fa-bars"></i></button>

<aside class="app-sidebar bg-blue-900 h-screen w-64 fixed top-0 left-0 overflow-y-auto">
    <nav class="p-4 flex justify-between items-center">
        <div>
            <a href="{{ route('dashboard') }}" class="sidebar-logo text-white text-lg font-semibold">
                <img src="{{ isset($yourCompany->icon_storage_file_path) ? asset($yourCompany->icon_storage_file_path) : 'img/officewill.png' }}"
                    alt="DEP SERVICE" class="w-32 mx-auto">
            </a>
        </div>
        <!-- &emsp;&emsp;&emsp;<button id="sidebarToggle" class="text-white focus:outline-none"><i class="fas fa-bars fa-lg"></i></button> -->
    </nav>
    <div class="page-spinner" id="page-spinner">
        <div class="spinner"></div>
    </div>
    <nav class="text-white">
        <div class="d-flex justify-content-end gap-1 px-3 py-2 border-bottom border-primary">
            <a class="text-white small" href="{{ route('locale.switch', 'ja') }}">日本語</a>
            <span class="text-white-50">|</span>
            <a class="text-white small" href="{{ route('locale.switch', 'en') }}">English</a>
        </div>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" title="Dashboard"
                    class="sidebar-link block py-2 px-4 text-sm {{ request()->routeIs('dashboard') ? 'bg-gray-900' : '' }}"><i class="fas fa-home mr-2"></i><span class="sidebar-label">{{ app()->getLocale() === 'en' ? 'Dashboard' : 'ダッシュボード' }}</span></a>
            </li>
            @if ($isSysAdmin)
                <li>
                    <a href="{{ route('company-information.index') }}" title="Company Information"
                        class="block py-2 px-4 text-sm {{ request()->routeIs('company-information.index') ? 'bg-gray-900' : '' }}"><i
                            class="fas fa-building mr-2"></i> <span class="sidebar-label">{{ __('Company Information') }}</span></a>
                </li>
            @endif
            @if ($isSysAdmin || $isEmployeeRegis || $isCourseEnroll || $isAttendenceSetting)
                <li>
                    <a href="#" class="block py-2 px-4 text-sm toggle-submenu" title="In-house Training"><i
                            class="fas fa-book-open mr-2"></i> 社内研修</a>
                    <ul class="treeview" style="display: none;">
                        <li>
                            <a href="{{ route('confirm-courses.index') }}" title="Confirm and attend courses"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                    class="fas fa-book mr-2"></i>
                                <span class="sidebar-label">{{ __('Confirm and attend courses') }}</span></a>
                        </li>
                        @if ($isSysAdmin || $isCourseEnroll || $isEmployeeRegis)
                            <li>
                                <a href="#" title="Course Registration"
                                    class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;{{ __('Course Registration') }}</a>
                                <ul class="treeview" style="display: none;">
                                    <!-- <li><a href="{{ route('materials.index') }}" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i class="fas fa-book mr-2"></i>Course Material Registration</a></li> -->
                                    @if ($isSysAdmin || $isCourseEnroll)
                                        <li><a href="{{ route('course-list') }}" title="Course Information "
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>{{ __('Course List') }}</a></li>
                                        <li><a href="{{ route('course-registration.index') }}"
                                                title="Course Information Registration"
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>{{ __('Course Information Registration') }}</a></li>
                                    @endif
                                    @if ($isSysAdmin || $isEmployeeRegis)
                                        <li><a href="{{ route('course-classification.index') }}"
                                                title="Course classification registration"
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>{{ __('Course Classification Registration') }}</a></li>
                                        <li><a href="{{ route('course-classification-details.index') }}"
                                                title="Course classification details registration"
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>{{ __('Course Classification Details Registration') }}</a></li>
                                    @endif

                                </ul>
                            </li>
                        @endif

                        @if ($isSysAdmin || $isAttendenceSetting)
                            <li>
                                <a href="{{ route('course-settings') }}" title="Course settings"
                                    class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                        class="fas fa-cogs mr-2"></i>{{ __('Course Settings') }}</a>
                            </li>
                        @endif
                        @if ($isSysAdmin || $isAttendenceSetting)
                            <li>
                                <a href="#" title="Course Inquiries"
                                    class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;{{ __('Course Inquiries') }}</a>
                                <ul class="treeview" style="display: none;">
                                    <li><a href="{{ route('course-inquiry') }}" title="Course Specific Inquiry"
                                            class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                class="fas fa-envelope"></i>{{ __('Course-specific Inquiry') }}</a></li>
                                    <li><a href="{{ route('employee-inquiry') }}" title="Employee-Specific Inquiry"
                                            class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                class="fas fa-user mr-2"></i>{{ __('Employee-specific Inquiry') }}</a></li>
                                </ul>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif
            @if ($isSysAdmin)
                <li>
                    <a href="#" class="block py-2 px-4 text-sm toggle-submenu" title="Employee Management"><i
                            class="fas fa-users-cog mr-2"></i> {{ __('Employee Management') }}</a>
                    <ul class="treeview" style="display: none;">
                        <li>
                            <a href="{{ route('affiliation-information.index') }}"
                                title="Affiliation Master Registration"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                    class="fas fa-handshake"></i>
                                {{ __('Affiliation Master Registration') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('job-titles.index') }}" title="Job Title Master Registration"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i class="fas fa-user-tie"></i>
                                {{ __('Job Title Master Registration') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('employee-list') }}" title="Employee list screen"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                    class="fas fa-book mr-2"></i>{{ __('Employee List') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('member-registration.create') }}"
                                title="Employee information registration screen"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                    class="fas fa-book mr-2"></i>{{ __('Member Registration') }}</a>
                        </li>


                    </ul>
                </li>
            @endif

            <br><br><br><br><br><br><br>

            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    &emsp;&emsp;<button type="submit" title="Logout"><i class="fa-solid fa-right-from-bracket"></i>
                        {{ __('Logout') }}</button>
                </form>
            </li>
            <li>
                @if (auth()->guard('employee')->check())
                    <span class="block py-2 px-4 text-sm">{{ auth()->guard('employee')->user()->fullname }}</span>
                @elseif(auth()->check())
                    <span class="block py-2 px-4 text-sm">{{ auth()->user()->name }}</span>
                @endif
            </li>
        </ul>
    </nav>
</aside>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Skrip JavaScript untuk mengontrol pushmenu -->

<!-- Menambahkan script untuk mengontrol submenu -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.querySelector('.app-sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const collapsedKey = 'officewill.sidebar.collapsed';
        if (localStorage.getItem(collapsedKey) === '1') {
            document.body.classList.add('sidebar-collapsed');
        }
        sidebarToggle?.addEventListener('click', function() {
            const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
            sidebarToggle.setAttribute('aria-expanded', String(!isCollapsed));
            localStorage.setItem(collapsedKey, isCollapsed ? '1' : '0');
        });

        const toggleSubmenu = document.querySelectorAll('.toggle-submenu');
        const toggleSubSubmenu = document.querySelectorAll('.submenu-item, .sub-submenu-item');

        toggleSubmenu.forEach(item => {
            item.addEventListener('click', () => {
                const submenu = item.nextElementSibling;
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';

                // Sembunyikan semua sub-submenu saat submenu di-toggle
                const subsubmenus = submenu.querySelectorAll('.treeview');
                subsubmenus.forEach(subsubmenu => {
                    subsubmenu.style.display = 'none';
                });
            });
        });

        toggleSubSubmenu.forEach(item => {
            item.addEventListener('click', () => {
                const subsubmenu = item.nextElementSibling;
                subsubmenu.style.display = subsubmenu.style.display === 'block' ? 'none' :
                    'block';
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const body = document.querySelector("body");
        const pageSpinner = document.getElementById("page-spinner");

        // Function to toggle the sidebar
        const toggleSidebar = () => {
            body.classList.toggle("sidebar-collapse");
            body.classList.toggle("sidebar-open");
        };

        // Add event listener to the sidebar button
        const sidebarButton = document.querySelector(".nav-link[data-widget='pushmenu']");
        if (sidebarButton) {
            sidebarButton.addEventListener("click", function(e) {
                e.preventDefault();
                toggleSidebar();
            });
        }


        // Fungsi untuk menampilkan spinner
        function showSpinner() {
            pageSpinner.style.display = "flex";
        }

        // Fungsi untuk menyembunyikan spinner
        function hideSpinner() {
            pageSpinner.style.display = "none";
        }

        // Tambahkan event listener ke setiap tautan navigasi yang akan menampilkan spinner
        const navLinks = document.querySelectorAll(".nav-link");
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
                title: 'Konfirmasi Logout',
                text: 'Anda yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
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


