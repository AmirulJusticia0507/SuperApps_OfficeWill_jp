@php
    $pageActive = function($pageName) {
        return request()->is($pageName) ? 'active' : '';
    };
@endphp

<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
{{-- <style>
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
</style> --}}

<!-- resources/views/includes/sidebar.blade.php -->
<aside class="main-sidebar sidebar-blue-900-primary elevation-4">
    <br>
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="img/officewill.png" alt="DEP SERVICE" class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>
    <br>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company-information.index') }}" class="nav-link {{ request()->routeIs('company-information.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Company Information</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->is('confirm-courses*', 'course-registration*', 'course-classification*', 'course-settings', 'course-inquiry', 'employee-inquiry') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('confirm-courses*', 'course-registration*', 'course-classification*', 'course-settings', 'course-inquiry', 'employee-inquiry') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            In-house Training
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('confirm-courses.index') }}" class="nav-link {{ request()->routeIs('confirm-courses.index') ? '' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Confirm and attend courses</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->is('course-registration*', 'course-classification*', 'course-classification-details*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('course-registration*', 'course-classification*', 'course-classification-details*') ? '  ' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Course Registration
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('course-registration.index') }}" class="nav-link {{ request()->routeIs('course-registration.index') ? ' ' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Course Information Registration</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('course-classification.index') }}" class="nav-link {{ request()->routeIs('course-classification.index') ? '  ' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Course classification registration</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('course-classification-details.index') }}" class="nav-link {{ request()->routeIs('course-classification-details.index') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Course classification details registration</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('course-settings') }}" class="nav-link {{ request()->routeIs('course-settings') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Course settings</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->is('course-inquiry', 'employee-inquiry') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('course-inquiry', 'employee-inquiry') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Course Inquiries
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('course-inquiry') }}" class="nav-link {{ request()->routeIs('course-inquiry') ? '  ' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Course Specific Inquiry</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('employee-inquiry') }}" class="nav-link {{ request()->routeIs('employee-inquiry') ? '  ' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Employee-Specific Inquiry</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('member-registration*', 'affiliation-information*', 'job-titles*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('member-registration*', 'affiliation-information*', 'job-titles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Employee Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('member-registration.create') }}" class="nav-link {{ request()->routeIs('member-registration.create') ? '  ' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Member Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('affiliation-information.index') }}" class="nav-link {{ request()->routeIs('affiliation-information.index') ? '  ' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Affiliation Master Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('job-titles.index') }}" class="nav-link {{ request()->routeIs('job-titles.index') ? '  ' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Job Title Master Registration</p>
                            </a>
                        </li>
                    </ul>
                    <br><br><br><br><br>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link"><i class="nav-icon fa-solid fa-right-from-bracket"></i> Logout</button>
                    </form>
                </li>
                <li class="nav-item">
                    @if(auth()->check())
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    @endif
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // // Fungsi untuk menampilkan spinner
        // function showSpinner() {
        //     document.querySelector(".page-spinner").style.display = "flex";
        // }

        // // Fungsi untuk menyembunyikan spinner
        // function hideSpinner() {
        //     document.querySelector(".page-spinner").style.display = "none";
        // }

        // // Tambahkan event listener ke setiap tautan navigasi yang akan menampilkan spinner
        // document.querySelectorAll(".nav-link").forEach(function (link) {
        //     link.addEventListener("click", function () {
        //         showSpinner();
        //     });
        // });

        // // Sembunyikan spinner saat halaman baru dimuat
        // window.addEventListener("load", function () {
        //     hideSpinner();
        // });

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
                    document.getElementById("logout-form").submit();
                }
            });
        }

        // Tambahkan event listener ke tautan "Logout"
        document.querySelector(".nav-link[data-widget='logout']").addEventListener("click", function (e) {
            e.preventDefault();
            confirmLogout();
        });
    });
</script>
