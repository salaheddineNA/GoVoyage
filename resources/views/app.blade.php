<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoVoyage') - Votre Agence de Voyage</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/images/favicon.ico') }}">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    @include('partials.header')

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4">
            {{ session('error') }}
        </div>
    @endif

    <main class="pt-24 pb-8">
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbar = document.getElementById("navbar");
            let lastScrollY = window.scrollY;

            // Scroll animation
            window.addEventListener("scroll", () => {
                if (window.scrollY > lastScrollY) {
                    navbar.style.transform = "translateY(-100%)";
                } else {
                    navbar.style.transform = "translateY(0)";
                }
                lastScrollY = window.scrollY;
            });

            // Mobile toggle
            const toggleButton = document.querySelector("[data-collapse-toggle]");
            const menu = document.getElementById("navbar-default");

            if (toggleButton && menu) {
                toggleButton.addEventListener("click", () => {
                    menu.classList.toggle("hidden");
                });
            }
        });
    </script>
</body>
</html>
