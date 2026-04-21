<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vols - {{ env('APP_NAME','GoVoyage') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 bg-white shadow-xl hidden lg:flex flex-col">
    <div class="p-6 border-b">
        <h2 class="text-2xl font-bold text-blue-600">GoVoyage</h2>
        <p class="text-sm text-gray-400">Admin Panel</p>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            📊 Dashboard
        </a>
        <a href="{{ route('admin.statistics') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
           📈 Statistiques
        </a>
        <a href="{{ route('admin.bookings') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            📋 Réservations
        </a>
        <a href="{{ route('admin.flights') }}" class="block px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
            ✈️ Vols
        </a>
        <a href="{{ route('admin.flights.create') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            ➕ Ajouter un vol
        </a>
        <a href="{{ route('admin.profile') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            👤 Profile
        </a>
        <a href="{{ route('admin.contacts') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
           📨 Messages de Contact
        </a>
    </nav>

    <div class="p-4 border-t">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                ↩ Logout
            </button>
        </form>
    </div>
</aside>

<!-- MAIN CONTENT -->
<div class="flex-1 p-6 lg:p-10">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                ✈️ Vols existants
            </h1>
            <p class="text-gray-500 mt-1">
                Gérez tous les vols disponibles.
            </p>
        </div>
        <div class="flex space-x-3">
            <div class="bg-white px-4 py-2 rounded-lg shadow">
                <span class="text-sm text-gray-500">Total:</span>
                <span class="font-bold text-blue-600">{{ $flights->count() }}</span>
            </div>
            <a href="{{ route('admin.flights.create') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                ➕ Ajouter un vol
            </a>
        </div>
    </div>

    <!-- FILTERS -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('admin.flights') }}" class="flex flex-wrap gap-4">
            <select name="flight_type" id="flightTypeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous les vols</option>
                <option value="direct" {{ request('flight_type') == 'direct' ? 'selected' : '' }}>Vols directs</option>
                <option value="stopover" {{ request('flight_type') == 'stopover' ? 'selected' : '' }}>Vols avec escale</option>
                <option value="offer" {{ request('flight_type') == 'offer' ? 'selected' : '' }}>Offres spéciales</option>
            </select>
            <select name="airline" id="airlineFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Toutes les compagnies</option>
                <option value="ryanair" {{ request('airline') == 'ryanair' ? 'selected' : '' }}>ryanair</option>
                <option value="Air France" {{ request('airline') == 'Air France' ? 'selected' : '' }}>Air France</option>
                <option value="British Airways" {{ request('airline') == 'British Airways' ? 'selected' : '' }}>British Airways</option>
            </select>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Rechercher une ville..." 
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                🔍 Rechercher
            </button>
            <a href="{{ route('admin.flights') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                🔄 Réinitialiser
            </a>
        </form>
    </div>

    <!-- FLIGHTS TABLE -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($flights->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Vol</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Compagnie</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Prix</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Offre</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Caractéristiques</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($flights as $flight)
                    <tr class="hover:bg-gray-50 transition flight-row"
                        data-search-text="{{ strtolower($flight->from_city . ' ' . $flight->to_city . ' ' . $flight->airline) }}"
                        data-flight-type="{{ $flight->is_direct ? 'direct' : 'stopover' }}"
                        data-airline="{{ $flight->airline }}"
                        data-is-offer="{{ $flight->is_offer ? 'offer' : 'regular' }}">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-lg">{{ $flight->from_city }} → {{ $flight->to_city }}</p>
                                <p class="text-xs text-gray-500">Durée: {{ $flight->duration }}</p>
                                <p class="text-xs text-gray-500">Départ: {{ $flight->departing_time }} | Arrivée: {{ $flight->arriving_time }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $flight->imageAirline }}" alt="{{ $flight->airline }}" class="h-8 w-8 rounded-full object-cover">
                                <span class="font-medium">{{ $flight->airline }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($flight->newprice)
                                <div>
                                    <span class="text-gray-400 line-through text-sm">{{ number_format($flight->oldprice, 2) }} MAD</span>
                                    <p class="text-green-600 font-bold text-lg">{{ number_format($flight->newprice, 2) }} MAD</p>
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">
                                        -{{ $flight->percentage }}%
                                    </span>
                                </div>
                            @else
                                <p class="text-gray-800 font-bold text-lg">{{ number_format($flight->oldprice, 2) }} MAD</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($flight->is_offer)
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                    OUI ({{ $flight->percentage }}%)
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-200 text-gray-600">
                                    NON
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                @if($flight->has_wifi)
                                    <span class="flex items-center text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                        📶 WiFi
                                    </span>
                                @endif
                                @if($flight->is_direct)
                                    <span class="flex items-center text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">
                                        ✈️ Direct
                                    </span>
                                @else
                                    <span class="flex items-center text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded">
                                        🔄 Escale
                                    </span>
                                @endif
                                @if($flight->showcase)
                                    <span class="flex items-center text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">
                                        ⭐ Vedette
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('flights.edit', $flight->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    ✏️ Modifier
                                </a>
                                <form action="{{ route('flights.destroy', $flight->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 font-medium text-sm"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce vol ?')">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun vol</h3>
            <p class="text-gray-500 mb-6">Commencez par ajouter votre premier vol.</p>
            <a href="{{ route('admin.flights.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                ➕ Ajouter un vol
            </a>
        </div>
        @endif
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const flightTypeFilter = document.getElementById('flightTypeFilter');
    const airlineFilter = document.getElementById('airlineFilter');
    const flightRows = document.querySelectorAll('.flight-row');
    const resultsCount = document.querySelector('span.font-bold.text-blue-600');
    
    function filterFlights() {
        const searchTerm = searchInput.value.toLowerCase();
        const flightTypeValue = flightTypeFilter.value;
        const airlineValue = airlineFilter.value;
        let visibleCount = 0;
        
        flightRows.forEach(row => {
            const searchText = row.getAttribute('data-search-text');
            const flightType = row.getAttribute('data-flight-type');
            const airline = row.getAttribute('data-airline');
            const isOffer = row.getAttribute('data-is-offer');
            
            const matchesSearch = !searchTerm || searchText.includes(searchTerm);
            const matchesFlightType = !flightTypeValue || 
                (flightTypeValue === 'offer' && isOffer === 'offer') ||
                (flightTypeValue === 'direct' && flightType === 'direct') ||
                (flightTypeValue === 'stopover' && flightType === 'stopover');
            const matchesAirline = !airlineValue || airline.toLowerCase().includes(airlineValue.toLowerCase());
            
            if (matchesSearch && matchesFlightType && matchesAirline) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update results count
        if (resultsCount) {
            resultsCount.textContent = visibleCount;
        }
    }
    
    // Event listeners
    if (searchInput) {
        searchInput.addEventListener('input', filterFlights);
    }
    
    if (flightTypeFilter) {
        flightTypeFilter.addEventListener('change', filterFlights);
    }
    
    if (airlineFilter) {
        airlineFilter.addEventListener('change', filterFlights);
    }
    
    // Initial filter
    filterFlights();
});
</script>

</body>
</html>
