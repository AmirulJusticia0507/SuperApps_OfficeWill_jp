@php
    $pageActive = function ($pageName) {
        return request()->is($pageName) ? 'active' : '';
    };
@endphp


<style>
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
<aside class="bg-blue-900 h-screen w-64 fixed top-0 left-0 overflow-y-auto">
    <nav class="p-4 flex justify-between items-center">
        <div>
            <a href="{{ route('dashboard') }}" class="text-white text-lg font-semibold">
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
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" title="Dashboard"
                    class="block py-2 px-4 text-sm {{ request()->routeIs('dashboard') ? 'bg-gray-900' : '' }}"><i
                        class="fas fa-home mr-2"></i> ダッシュボード</a>
            </li>
            @if ($isSysAdmin)
                <li>
                    <a href="{{ route('company-information.index') }}" title="Company Information"
                        class="block py-2 px-4 text-sm {{ request()->routeIs('company-information.index') ? 'bg-gray-900' : '' }}"><i
                            class="fas fa-building mr-2"></i> 企業情報</a>
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
                                コースの確認と受講</a>
                        </li>
                        @if ($isSysAdmin || $isCourseEnroll || $isEmployeeRegis)
                            <li>
                                <a href="#" title="Course Registration"
                                    class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;履修登録</a>
                                <ul class="treeview" style="display: none;">
                                    <!-- <li><a href="{{ route('materials.index') }}" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i class="fas fa-book mr-2"></i>Course Material Registration</a></li> -->
                                    @if ($isSysAdmin || $isCourseEnroll)
                                        <li><a href="{{ route('course-list') }}"
                                                title="Course Information "
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>コースリスト</a></li>
                                        <li><a href="{{ route('course-registration.index') }}"
                                                title="Course Information Registration"
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>コース情報登録</a></li>
                                    @endif
                                    @if ($isSysAdmin || $isEmployeeRegis)
                                        <li><a href="{{ route('course-classification.index') }}"
                                                title="Course classification registration"
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>コース分類登録</a></li>
                                        <li><a href="{{ route('course-classification-details.index') }}"
                                                title="Course classification details registration"
                                                class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                    class="fas fa-book mr-2"></i>コース分類詳細登録</a></li>
                                    @endif

                                </ul>
                            </li>
                        @endif

                        @if ($isSysAdmin || $isAttendenceSetting)
                            <li>
                                <a href="{{ route('course-settings') }}" title="Course settings"
                                    class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                        class="fas fa-cogs mr-2"></i>コース設定</a>
                            </li>
                        @endif
                        @if ($isSysAdmin || $isAttendenceSetting)
                            <li>
                                <a href="#" title="Course Inquiries"
                                    class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;コースに関するお問い合わせ</a>
                                <ul class="treeview" style="display: none;">
                                    <li><a href="{{ route('course-inquiry') }}" title="Course Specific Inquiry"
                                            class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                class="fas fa-envelope"></i>コース別のお問い合わせ</a></li>
                                    <li><a href="{{ route('employee-inquiry') }}" title="Employee-Specific Inquiry"
                                            class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;<i
                                                class="fas fa-user mr-2"></i>従業員固有のお問い合わせ</a></li>
                                </ul>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif
            @if ($isSysAdmin)
                <li>
                    <a href="#" class="block py-2 px-4 text-sm toggle-submenu" title="Employee Management"><i
                            class="fas fa-users-cog mr-2"></i> 従業員管理</a>
                    <ul class="treeview" style="display: none;">
                        <li>
                            <a href="{{ route('affiliation-information.index') }}"
                                title="Affiliation Master Registration"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                    class="fas fa-handshake"></i>
                                所属マスター登録</a>
                        </li>
                        <li>
                            <a href="{{ route('job-titles.index') }}" title="Job Title Master Registration"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i class="fas fa-user-tie"></i>
                                役職マスタ登録</a>
                        </li>
                        <li>
                            <a href="{{ route('employee-list') }}" title="Employee list screen"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                    class="fas fa-book mr-2"></i>従業員リスト</a>
                        </li>
                        <li>
                            <a href="{{ route('member-registration.create') }}"
                                title="Employee information registration screen"
                                class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;<i
                                    class="fas fa-book mr-2"></i>会員登録</a>
                        </li>


                    </ul>
                </li>
            @endif

            <br><br><br><br><br><br><br>

            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    &emsp;&emsp;<button type="submit" title="Logout"><i class="fa-solid fa-right-from-bracket"></i>
                        ログアウト</button>
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
        sidebarButton.addEventListener("click", function(e) {
            e.preventDefault();
            toggleSidebar();
        });

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
        logoutLink.addEventListener("click", function(e) {
            e.preventDefault();
            confirmLogout();
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarToggle = document.getElementById("sidebarToggle");
        const sidebar = document.querySelector(".sidebar");

        // Sembunyikan sidebar secara default
        sidebar.classList.add("hidden");

        // Tambahkan event listener untuk menangani klik pada tombol sidebar toggle
        sidebarToggle.addEventListener("click", function() {
            // Toggle class 'hidden' pada sidebar untuk menampilkan/menyembunyikan sidebar
            sidebar.classList.toggle("hidden");
        });

        // Tambahkan event listener untuk menangani klik pada tombol toggler untuk sidebar
        $('.navbar-toggler[aria-controls="sidebar"]').on('click', function() {
            // Toggle class 'show' pada elemen sidebar
            $('#sidebar').toggleClass('show');
        });
    });
</script>
