<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<nav class="bg-white shadow">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-left py-8">
            <div>
                <button class="text-gray-800 focus:outline-none" id="sidebarToggle">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </div>
            <div class="flex items-center">
                @auth
                    <div class="relative">
                        <!-- Tambahkan menu atau ikon lain di sini -->
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarToggle = document.getElementById("sidebarToggle");
        const sidebar = document.querySelector(".sidebar");

        if (sidebar && sidebarToggle) {
            // Sembunyikan sidebar secara default
            sidebar.classList.add("hidden");

            // Tambahkan event listener untuk menangani klik pada tombol sidebar toggle
            sidebarToggle.addEventListener("click", function() {
                // Toggle class 'hidden' pada sidebar untuk menampilkan/menyembunyikan sidebar
                sidebar.classList.toggle("hidden");
            });
        }
    });
</script>
