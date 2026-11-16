<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<nav class="bg-white shadow">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-left py-8">
            <div>
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
