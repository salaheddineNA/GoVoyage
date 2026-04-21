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



<nav id="navbar" class="bg-white shadow-lg fixed w-full z-50 top-0 left-0 transition-all duration-300 backdrop-blur-lg bg-opacity-95">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      
      <!-- Logo -->
      <div class="flex-shrink-0">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
          <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto transition-transform duration-300 group-hover:scale-110" alt="GoVoyage Logo" />
        </a>
      </div>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center space-x-1">
        <!-- Main Navigation -->
        <div class="flex items-center space-x-1">
          <a href="{{ route('home') }}" 
             class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-[#0c47bc] hover:bg-blue-50 transition-all duration-200 font-medium">
            <i class="fas fa-home mr-2"></i>Accueil
          </a>
          
          <a href="{{ route('flight') }}" 
             class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-[#0c47bc] hover:bg-blue-50 transition-all duration-200 font-medium">
            <i class="fas fa-plane mr-2"></i>Vols
          </a>
          
          <a href="{{ route('offer') }}" 
             class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-[#0c47bc] hover:bg-blue-50 transition-all duration-200 font-medium">
            <i class="fas fa-tag mr-2"></i>Offres
          </a>
          
          <a href="{{ route('support') }}" 
             class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-[#0c47bc] hover:bg-blue-50 transition-all duration-200 font-medium">
            <i class="fas fa-headset mr-2"></i>Support
          </a>
        </div>

        <!-- User Menu -->
        <div class="ml-4 flex items-center space-x-2">
          @guest
            <a href="{{ route('login') }}" 
               class="px-4 py-2 text-[#0c47bc] border border-[#0c47bc] rounded-lg hover:bg-[#0c47bc] hover:text-white transition-all duration-200 font-medium">
              <i class="fas fa-sign-in-alt mr-2"></i>Connexion
            </a>
            <a href="{{ route('register') }}" 
               class="px-4 py-2 bg-[#0c47bc] text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
              <i class="fas fa-user-plus mr-2"></i>Inscription
            </a>
          @else
            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
              <button @click="open = !open" 
                      class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200">
                <div class="w-8 h-8 bg-[#0c47bc] rounded-full flex items-center justify-center text-white font-semibold">
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="hidden lg:block font-medium">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down text-xs"></i>
              </button>
              
              <div x-show="open" 
                   @click.away="open = false"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="opacity-0 transform scale-95"
                   x-transition:enter-end="opacity-100 transform scale-100"
                   x-transition:leave="transition ease-in duration-75"
                   x-transition:leave-start="opacity-100 transform scale-100"
                   x-transition:leave-end="opacity-0 transform scale-95"
                   class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                <a href="{{ route('profile') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                  <i class="fas fa-user mr-2"></i>Mon Profil
                </a>
                <a href="{{ route('bookings.my') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                  <i class="fas fa-ticket-alt mr-2"></i>Mes Réservations
                </a>
                <hr class="my-2 border-gray-200">
                <form action="{{ route('logout') }}" method="POST" class="block">
                  @csrf
                  <button type="submit" 
                          class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                  </button>
                </form>
              </div>
            </div>
          @endguest
        </div>
      </div>

      <!-- Mobile menu button -->
      <div class="md:hidden">
        <button @click="mobileMenuOpen = !mobileMenuOpen" 
                class="inline-flex items-center justify-center p-2 rounded-lg text-[#0c47bc] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#0c47bc] transition-colors duration-200">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden bg-white border-t border-gray-200 py-4 mt-2 rounded-lg shadow-lg"
         x-data="{ mobileMenuOpen: false }">
      
      <div class="px-2 space-y-1">
        <a href="{{ route('home') }}" 
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-[#0c47bc] transition-colors duration-200 font-medium">
          <i class="fas fa-home mr-3"></i>Accueil
        </a>
        
        <a href="{{ route('flight') }}" 
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-[#0c47bc] transition-colors duration-200 font-medium">
          <i class="fas fa-plane mr-3"></i>Vols
        </a>
        
        <a href="{{ route('offer') }}" 
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-[#0c47bc] transition-colors duration-200 font-medium">
          <i class="fas fa-tag mr-3"></i>Offres Spéciales
        </a>
        
        <a href="{{ route('support') }}" 
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-[#0c47bc] transition-colors duration-200 font-medium">
          <i class="fas fa-headset mr-3"></i>Support
        </a>
        
        @guest
          <div class="pt-4 border-t border-gray-200 space-y-2">
            <a href="{{ route('login') }}" 
               class="block px-4 py-2 text-center text-[#0c47bc] border border-[#0c47bc] rounded-lg hover:bg-[#0c47bc] hover:text-white transition-all duration-200 font-medium">
              <i class="fas fa-sign-in-alt mr-2"></i>Connexion
            </a>
            <a href="{{ route('register') }}" 
               class="block px-4 py-2 text-center bg-[#0c47bc] text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-medium shadow-md">
              <i class="fas fa-user-plus mr-2"></i>Inscription
            </a>
          </div>
        @else
          <div class="pt-4 border-t border-gray-200 space-y-1">
            <div class="px-4 py-2 border-b border-gray-200">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#0c47bc] rounded-full flex items-center justify-center text-white font-semibold">
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                  <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                  <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>
              </div>
            </div>
            
            <a href="{{ route('profile') }}" 
               class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
              <i class="fas fa-user mr-3"></i>Mon Profil
            </a>
            
            <a href="{{ route('bookings.my') }}" 
               class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
              <i class="fas fa-ticket-alt mr-3"></i>Mes Réservations
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="block">
              @csrf
              <button type="submit" 
                      class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors duration-200">
                <i class="fas fa-sign-out-alt mr-3"></i>Déconnexion
              </button>
            </form>
          </div>
        @endguest
      </div>
    </div>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    let lastScrollY = window.scrollY;

    // Enhanced scroll animation with backdrop blur effect
    window.addEventListener("scroll", () => {
      if (window.scrollY > lastScrollY && window.scrollY > 100) {
        navbar.style.transform = "translateY(-100%)";
      } else {
        navbar.style.transform = "translateY(0)";
      }
      
      // Add shadow when scrolled
      if (window.scrollY > 10) {
        navbar.classList.add('shadow-xl');
      } else {
        navbar.classList.remove('shadow-xl');
      }
      
      lastScrollY = window.scrollY;
    });

    // Active page highlighting
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPath || 
          (currentPath === '/' && link.textContent.includes('Accueil'))) {
        link.classList.add('bg-blue-50', 'text-[#0c47bc]');
      }
    });
  });
</script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">