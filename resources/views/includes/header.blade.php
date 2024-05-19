<!-- AdminLTE CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            {{-- <a class="nav-link" data-widget="pushmenu" href="#" id="sidebarToggle" role="button"><i class="fas fa-bars"></i></a> --}}
        </li>
    </ul>


</nav>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarToggle = document.getElementById("sidebarToggle");
        const body = document.querySelector("body");
        const pageSpinner = document.getElementById("page-spinner");

        // Function to toggle the sidebar
        const toggleSidebar = () => {
            body.classList.toggle("sidebar-collapse");
        };

        // Add event listener to the sidebar button
        sidebarToggle.addEventListener("click", function (e) {
            e.preventDefault();
            toggleSidebar();
        });

        // Add event listener to all navigation links to show spinner
        const navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach(function (link) {
            link.addEventListener("click", function () {
                showSpinner();
            });
        });

        // Hide spinner when the page is fully loaded
        window.addEventListener("load", function () {
            hideSpinner();
        });
    });
</script>

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
@endsection
