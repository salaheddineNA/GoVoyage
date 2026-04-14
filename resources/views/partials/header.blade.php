{{-- <nav id="navbar" class="fixed top-0 left-0 w-full  z-50 transition-transform duration-500 h-20 bg-[#0c47bc] ">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="{{route('home')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="{{ asset('images/ChatGPT Image Feb 11, 2026, 12_06_17 AM.png') }}" class="h-8" alt="Flowbite Logo" />
    </a>
    <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600" aria-controls="navbar-dropdown" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
      <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
        <li>
          <a href="{{route('home')}}" class="block py-2 px-3 md:border-0 text-white md:hover:text-[#FC0000] hover:bg-gray-700  md:hover:bg-transparent">Home</a>
        </li>
        <li>
          <a href="{{route('flight')}}" class="block py-2 px-3 md:border-0 text-white md:hover:text-[#FC0000] hover:bg-gray-700  md:hover:bg-transparent">Flights</a>
        </li>
        <li>
          <a href="{{route('offer')}}" class="block py-2 px-3 md:border-0 text-white md:hover:text-[#FC0000] hover:bg-gray-700  md:hover:bg-transparent">Special offers</a>
        </li>
        <li>
          <a href="{{route('support')}}" class="block py-2 px-3 md:border-0 text-white md:hover:text-[#FC0000] hover:bg-gray-700  md:hover:bg-transparent">Support</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function () {
  const navbar = document.getElementById("navbar");
  let lastScrollY = window.scrollY;

  window.addEventListener("scroll", () => {
    if (window.scrollY > lastScrollY) {
      // Hide navbar on scroll down
      navbar.style.transform = "translateY(-100%)";
    } else {
      // Show navbar on scroll up
      navbar.style.transform = "translateY(0)";
    }
    lastScrollY = window.scrollY;
  });
});

</script> --}}



<nav id="navbar" class="bg-white fixed w-full z-20 top-0 left-0 border-b border-[#0c47bc] transition-transform duration-300">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto object-contain" alt="GoVoyage Logo" />
    </a>

    <!-- Mobile menu button -->
    <button data-collapse-toggle="navbar-default" type="button"
      class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-[#0c47bc] rounded-md md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#0c47bc]"
      aria-controls="navbar-default" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
           xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>

    <!-- Menu -->
    <div class="hidden w-full md:flex md:w-auto" id="navbar-default">
      <ul class="flex flex-col md:flex-row md:space-x-8 font-medium p-4 md:p-0 mt-4 md:mt-0 bg-gray-50 md:bg-white rounded-md md:rounded-none border border-gray-100 md:border-0">

        <li>
          <a href="{{ route('home') }}"
             
             class="block py-2 px-3 text-[#0c47bc] rounded  md:hover:bg-[#f1c933] md:hover:text-white hover:bg-[#f1c933] hover:text-white">
             Home
          </a>
        </li>

        <li>
          <a href="{{ route('flight') }}"
             class="block py-2 px-3 text-[#0c47bc] rounded  md:hover:bg-[#f1c933] md:hover:text-white hover:bg-[#f1c933] hover:text-white">
             Flights
          </a>
        </li>

        <li>
          <a href="{{ route('offer') }}"
             class="block py-2 px-3 text-[#0c47bc] rounded md:hover:bg-[#f1c933] md:hover:text-white hover:bg-[#f1c933] hover:text-white">
             Special Offers
          </a>
        </li>

        <li>
          <a href="{{ route('support') }}"
             class="block py-2 px-3 text-[#0c47bc] rounded md:hover:bg-[#f1c933] md:hover:text-white hover:bg-[#f1c933] hover:text-white">
             Support
          </a>
        </li>

        <li>
          <a href="{{ route('bookings.my') }}"
             class="block py-2 px-3 text-[#0c47bc] rounded md:hover:bg-[#f1c933] md:hover:text-white hover:bg-[#f1c933] hover:text-white">
            Mes Réservations
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>

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

    toggleButton.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });
  });
</script>