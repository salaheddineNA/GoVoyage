<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoVoyage-Offres Spéciales</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>

<body>
    @include('partials.header')
    
    <!-- Hero Section with Search -->
    <div class="bg-center bg-no-repeat bg-[url('https://r4.wallpaperflare.com/wallpaper/101/866/548/airbus-a380-lufthansa-sunset-hd-white-lofttansa-passenger-plane-wallpaper-5980c80dd19a2dab26d708bf8071c6ed.jpg')] bg-blue-400 bg-blend-multiply text-white">
        <div class="max-w-8xl mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold m-6">
                    Offres Spéciales
                </h1>
                <p class="text-xl text-blue-100">
                    Vous trouverez ici des offres exceptionnelles pour de grandes escapades.
                </p>
            </div>
            
            <!-- Search Form -->
            <form action="{{ route('offer') }}" method="GET" class="bg-white rounded-2xl shadow-2xl p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Departure -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ✈️ Ville de départ
                        </label>
                        <input type="text" 
                               name="departure" 
                               value="{{ request()->query('departure') }}"
                               placeholder="Ex: Paris" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                    </div>
                    
                    <!-- Destination -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            🏝️ Destination de rêve
                        </label>
                        <input type="text" 
                               name="destination" 
                               value="{{ request()->query('destination') }}"
                               placeholder="Ex: Bali, Maldives" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                    </div>
                    
                    <!-- Max Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            💰 Prix maximum (MAD)
                        </label>
                        <input type="number" 
                               name="max_price" 
                               value="{{ request()->query('max_price') }}"
                               placeholder="Ex: 15000" 
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                    </div>
                    
                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            📅 Date de départ
                        </label>
                        <input type="date" 
                               name="travel_date" 
                               value="{{ request()->query('travel_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                    </div>
                </div>
                
                <!-- Options -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="direct" 
                               value="1"
                               {{ request()->query('direct') == '1' ? 'checked' : '' }}
                               class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="text-sm text-gray-700">Vol direct uniquement</span>
                    </label>
                    
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="wifi" 
                               value="1"
                               {{ request()->query('wifi') == '1' ? 'checked' : '' }}
                               class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="text-sm text-gray-700">WiFi disponible</span>
                    </label>
                    
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="honeymoon" 
                               value="1"
                               {{ request()->query('honeymoon') == '1' ? 'checked' : '' }}
                               class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="text-sm text-gray-700">Package lune de miel</span>
                    </label>
                </div>
                
                <!-- Search Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-[#0c47bc] to-blue-900 text-blue-50 font-semibold py-3 px-6 rounded-xl hover:scale-75 transition duration-300 shadow-lg">
                        🔍 Rechercher les offres 
                    </button>
                    
                    <a href="{{ route('offer') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        Effacer
                    </a>
                </div>
            </form>
        </div>
    </div>
    
       
    <section class="relative bg-[#0c47bc] pt-20 pb-32">
            <div class="relative z-10 flex flex-col items-center justify-center text-center px-4">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Préparez le voyage de vos rêves
                </h1>
                <p class="text-sm md:text-base text-white text-opacity-90 mb-8 max-w-md">
                    Contactez-nous pour des offres personnalisées pour votre lune de miel ou destination de mariage
                </p>
                <button class="px-8 py-3 border-2 border-white text-white font-semibold rounded hover:bg-white hover:text-red-500 transition-all duration-300">
                    NOUS CONTACTER
                </button>
            </div>

            <!-- Curved Wave Bottom -->
           <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,60 Q360,20 720,60 T1440,60 L1440,120 L0,120 Z
                        M0,80 Q360,40 720,80 T1440,80 L1440,120 L0,120 Z" fill="#f9fafb"/>
            </svg>
    </section>

    <!-- Results Section -->
    <div class="py-6 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Results Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ request()->query('departure') || request()->query('destination') || request()->query('max_price') || request()->query('direct') || request()->query('wifi') || request()->query('honeymoon') ? ' Offres de mariage trouvées' : ' Toutes nos offres spéciales mariage' }}
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ $flights->where('is_offer', 1)->count() }} vol{{ $flights->where('is_offer', 1)->count() > 1 ? 's' : '' }} trouvé{{ $flights->where('is_offer', 1)->count() > 1 ? 's' : '' }}
                    @if(request()->query('departure') || request()->query('destination') || request()->query('max_price') || request()->query('direct') || request()->query('wifi') || request()->query('honeymoon'))
                        <a href="{{ route('offer') }}" class="text-pink-600 hover:text-pink-800 ml-2">
                            ← Effacer les filtres
                        </a>
                    @endif
                </p>
            </div>

            <!-- Active Filters -->
            @if(request()->query('departure') || request()->query('destination') || request()->query('max_price') || request()->query('direct') || request()->query('wifi') || request()->query('honeymoon'))
            <div class="mb-6 flex flex-wrap gap-2">
                @if(request()->query('departure'))
                <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-sm">
                    Départ: {{ request()->query('departure') }}
                </span>
                @endif
                @if(request()->query('destination'))
                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                    Destination: {{ request()->query('destination') }}
                </span>
                @endif
                @if(request()->query('max_price'))
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                    Prix max: {{ request()->query('max_price') }} MAD
                </span>
                @endif
                @if(request()->query('direct') == '1')
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    Vol direct
                </span>
                @endif
                @if(request()->query('wifi') == '1')
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                    WiFi disponible
                </span>
                @endif
                @if(request()->query('honeymoon') == '1')
                <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-sm">
                    Package lune de miel
                </span>
                @endif
            </div>
            @endif

            <!-- Flights Grid -->
            @if($flights->where('is_offer', 1)->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($flights as $flight)
                @if ($flight->is_offer===1)
                <!-- Flight Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Card Header -->
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="{{ $flight->cityimg }}" alt="Destination">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-[#f1c933] backdrop-blur-sm px-3 py-1 rounded-md">
                            <span class="text-sm font-semibold text-white">{{ $flight->airline }}</span>
                        </div>
                        <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-lg">
                            -{{ $flight->percentage }}%
                        </div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-bold">{{ $flight->from_city }} → {{ $flight->to_city }}</h3>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <!-- Flight Info -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $flight->imageAirline }}" alt="Airline Logo" class="h-10 w-10 rounded-full object-cover">
                                <div>
                                    <p class="text-sm text-gray-500">Compagnie</p>
                                    <p class="font-medium">{{ $flight->airline }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Durée</p>
                                <p class="font-medium">{{ $flight->duration }}</p>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="flex items-center space-x-4 mb-4 text-sm">
                            @if($flight->has_wifi)
                            <span class="flex items-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="currentColor" class="bi bi-wifi" viewBox="0 0 16 16">
                                    <path d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.44 12.44 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.52.52 0 0 0 .668.05A11.45 11.45 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049"/>
                                    <path d="M13.229 8.271a.482.482 0 0 0-.063-.745A9.46 9.46 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.576 1.336c.206.132.48.108.653-.065m-2.183 2.183c.226-.226.185-.605-.1-.75A6.5 6.5 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.407.19.611.09A5.5 5.5 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.61-.091zM9.06 12.44c.196-.196.198-.52-.04-.66A2 2 0 0 0 8 11.5a2 2 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .707 0l.707-.707z"/>
                                </svg>
                                WiFi
                            </span>
                            @endif
                            @if($flight->is_direct)
                            <span class="flex items-center text-green-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                </svg>
                                Direct
                            </span>
                            @else
                            <span class="flex items-center text-orange-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                Escale
                            </span>
                            @endif
                        </div>

                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                @if($flight->newprice)
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg text-red-600 line-through">{{ number_format($flight->oldprice, 2) }} MAD</span>
                                    <span class="text-2xl font-bold text-green-600">{{ number_format($flight->newprice, 2) }} MAD</span>
                                </div>
                                <!-- <span class="text-sm text-red-600 font-medium">-{{ $flight->percentage }}%</span> -->
                                @else
                                <span class="text-2xl font-bold text-gray-900">{{ number_format($flight->oldprice, 2) }} MAD</span>
                                @endif
                            </div>
                        </div>

                        <!-- Booking Button -->
                        <a href="{{ route('bookings.create', $flight->id) }}" 
                           class="w-full block text-center bg-[#0c47bc] text-white py-3 px-4 rounded-xl hover:from-pink-600 hover:to-rose-700 transition font-medium transform hover:scale-105">
                            🎫Réserver cette offre romantique
                        </a>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @else
            <!-- No Results -->
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune offre de mariage trouvée</h3>
                <p class="text-gray-500 mb-6">Nous n'avons pas trouvé d'offres romantiques correspondant à vos critères. Essayez d'ajuster vos filtres.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('offer') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700">
                        💕 Voir toutes les offres
                    </a>
                    <a href="{{ route('flight') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 hover:bg-gray-50">
                        ✈️ Voir tous les vols
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    @include('components.calltoaction')
    @include('partials.footer')
</body>

</html>
