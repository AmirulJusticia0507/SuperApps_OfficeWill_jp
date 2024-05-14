@php
    $pageActive = function($pageName) {
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
        background: rgba(0, 0, 0, 0.5); /* Warna latar belakang dengan transparan */
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.3);
        border-radius: 50%;
        border-top: 4px solid #007bff; /* Warna utama */
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<!-- resources/views/includes/sidebar.blade.php -->
{{-- <aside class="bg-gray-400 h-screen w-64 fixed top-0 left-0 overflow-y-auto"> --}}
<aside class="bg-blue-900 h-screen w-64 fixed top-0 left-0 overflow-y-auto">
    <nav class="p-4 flex justify-between items-center">
        <div>
            <a href="{{ route('dashboard') }}" class="text-white text-lg font-semibold">
                <img src="img/officewill.png" alt="DEP SERVICE" class="w-32 mx-auto">
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
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 text-sm {{ request()->routeIs('dashboard') ? 'bg-gray-900' : '' }}"><i class="fas fa-home mr-2"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('company-information.index') }}" class="block py-2 px-4 text-sm {{ request()->routeIs('company-information.index') ? 'bg-gray-900' : '' }}"><i class="fas fa-building mr-2"></i> Company Information</a>
            </li>
            <li>
                <a href="#" class="block py-2 px-4 text-sm toggle-submenu"><i class="fas fa-book-open mr-2"></i> In-house Training</a>
                <ul class="treeview" style="display: none;">
                    <li>
                        <a href="{{ route('confirm-courses.index') }}" class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;Confirm and attend courses</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;Course Registration</a>
                        <ul class="treeview" style="display: none;">
                            <li><a href="{{ route('course-registration.index') }}" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;Course Registration</a></li>
                            <li><a href="{{ route('course-classification.index') }}" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;Course classification registration</a></li>
                            <li><a href="{{ route('course-classification-details.index') }}" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;Course classification details registration</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('course-settings') }}" class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;Course settings</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;Course Inquiries</a>
                        <ul class="treeview" style="display: none;">
                            <li><a href="{{ route('course-inquiry') }}" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;Course Specific Inquiry</a></li>
                            <li><a href="#" class="block py-2 px-4 text-sm sub-submenu-item">&emsp;&emsp;&emsp;&emsp;Employee-Specific Inquiry</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="block py-2 px-4 text-sm toggle-submenu"><i class="fas fa-users-cog mr-2"></i> Employee Management</a>
                <ul class="treeview" style="display: none;">
                    <li>
                        <a href="{{ route('member-registration.create') }}" class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;Member Registration</a>
                    </li>
                    <li>
                        <a href="{{ route('affiliation-information.index') }}" class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;Affiliation Master Registration</a>
                    </li>
                    <li>
                        <a href="{{ route('job-titles.index') }}" class="block py-2 px-4 text-sm submenu-item">&emsp;&emsp;Job Title Master Registration</a>
                    </li>
                </ul>
            </li><br><br><br><br><br><br><br>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block py-2 px-4 text-sm logout-link"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </li>
            <li>
                <span class="block py-2 px-4 text-sm">{{ auth()->user()->name }}</span>
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
                subsubmenu.style.display = subsubmenu.style.display === 'block' ? 'none' : 'block';
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const body = document.querySelector("body");
        const pageSpinner = document.getElementById("page-spinner");

        // Function to toggle the sidebar
        const toggleSidebar = () => {
            body.classList.toggle("sidebar-collapse");
            body.classList.toggle("sidebar-open");
        };

        // Add event listener to the sidebar button
        const sidebarButton = document.querySelector(".nav-link[data-widget='pushmenu']");
        sidebarButton.addEventListener("click", function (e) {
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
        navLinks.forEach(function (link) {
            link.addEventListener("click", function () {
                showSpinner();
            });
        });

        // Sembunyikan spinner saat halaman baru dimuat
        window.addEventListener("load", function () {
            hideSpinner();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
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
    logoutLink.addEventListener("click", function (e) {
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
        sidebarToggle.addEventListener("click", function () {
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

