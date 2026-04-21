<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes réservations</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body>
    @include('partials.header')
    
    <div class="min-h-screen bg-gray-50 p-16">
        <div class="max-w-6xl mx-auto px-4">
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#fec501] pt-8">Mes réservations</h1>
                <p class="text-3xl text-blue-600 mt-2">Consultez et gérez toutes vos réservations de vol</p>
            </div>

            <!-- Search Section -->
            @if($bookings->count() > 0)
            <div class="mb-6 bg-[#fec501] rounded-lg shadow-sm p-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   id="searchInput" 
                                   placeholder="Rechercher par ville, compagnie aérienne, référence de réservation..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="confirmed">Confirmé</option>
                            <option value="pending">En attente</option>
                            <option value="cancelled">Annulé</option>
                        </select>
                        <button onclick="clearFilters()" class="px-4 py-2 bg-[#1c64f2] text-white rounded-lg hover:bg-blue-800 transition">
                            Effacer
                        </button>
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-900">
                    <span id="resultsCount">{{ $bookings->count() }}</span> réservation(s) trouvée(s)
                </div>
            </div>
            @endif

            @if($bookings->count() > 0)
                <div class="grid gap-6">
                    @foreach($bookings as $booking)
                    <div class="booking-card bg-white rounded-lg shadow-md overflow-hidden border-[#1c64f2] border-2" 
                         data-search-text="{{ strtolower($booking->flight->from_city . ' ' . $booking->flight->to_city . ' ' . $booking->flight->airline . ' ' . $booking->booking_reference . ' ' . $booking->first_name . ' ' . $booking->last_name) }}"
                         data-status="{{ $booking->status }}">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $booking->flight->from_city }} → {{ $booking->flight->to_city }}
                                    </h3>
                                    <p class="text-gray-600">{{ $booking->flight->airline }}</p>
                                    <p class="text-sm text-gray-500">Référence: {{ $booking->booking_reference }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Flight Details -->
                            <div class="grid md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Date de voyage</p>
                                    <p class="font-medium">{{ $booking->travel_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Passagers</p>
                                    <p class="font-medium">{{ $booking->passengers }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Durée</p>
                                    <p class="font-medium">{{ $booking->flight->duration }}</p>
                                </div>
                            </div>

                            <!-- Passenger Info -->
                            <div class="border-t pt-4 mb-4">
                                <p class="text-sm text-gray-500 mb-2">Informations du passager</p>
                                <p class="font-medium">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->email }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->phone }}</p>
                            </div>

                            <!-- Price and Actions -->
                            <div class="flex justify-between items-center border-t pt-4">
                                <div>
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ number_format($booking->total_price, 2) }} MAD
                                    </p>
                                    @if($booking->flight->newprice)
                                        <p class="text-sm text-gray-500">
                                            {{ $booking->passengers }} × {{ number_format($booking->flight->newprice, 2) }} MAD
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">
                                            {{ $booking->passengers }} × {{ number_format($booking->flight->oldprice, 2) }} MAD
                                        </p>
                                    @endif
                                </div>
                                <div class="flex space-x-3">
                                    @if($booking->status === 'confirmed')
                                    <a href="{{ route('bookings.download', $booking->id) }}" 
                                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Télécharger
                                    </a>
                                    @endif
                                    <a href="{{ route('bookings.confirmation', $booking->id) }}" 
                                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                        Voir détails
                                    </a>
                                    @if($booking->status !== 'cancelled')
                                    <form action="{{ route('bookings.user.cancel', $booking->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                            Annuler
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Flight Features -->
                            <div class="flex items-center space-x-4 mt-4 text-sm text-gray-600">
                                @if($booking->flight->has_wifi)
                                    <span class="flex items-center text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="currentColor" class="bi bi-wifi" viewBox="0 0 16 16">
                                            <path d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.44 12.44 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.52.52 0 0 0 .668.05A11.45 11.45 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049"/>
                                            <path d="M13.229 8.271a.482.482 0 0 0-.063-.745A9.46 9.46 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.576 1.336c.206.132.48.108.653-.065m-2.183 2.183c.226-.226.185-.605-.1-.75A6.5 6.5 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.407.19.611.09A5.5 5.5 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.61-.091zM9.06 12.44c.196-.196.198-.52-.04-.66A2 2 0 0 0 8 11.5a2 2 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .707 0l.707-.707z"/>
                                        </svg>
                                        WiFi
                                    </span>
                                @endif
                                @if($booking->flight->is_direct)
                                    <span class="flex items-center text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                        </svg>
                                        Vol direct
                                    </span>
                                @else
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                        Escale
                                    </span>
                                @endif
                                @if($booking->flight->is_offer)
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">
                                        -{{ $booking->flight->percentage }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune réservation</h3>
                    <p class="text-gray-500 mb-6">Vous n'avez pas encore de réservation. Réservez votre premier vol maintenant!</p>
                    <a href="{{ route('offer') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Voir les offres
                    </a>
                </div>
            @endif
        </div>
    </div>

    @include('partials.footer')
    
    <script>
        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const resultsCount = document.getElementById('resultsCount');
            const bookingCards = document.querySelectorAll('.booking-card');
            
            function filterBookings() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusTerm = statusFilter.value;
                let visibleCount = 0;
                
                bookingCards.forEach(card => {
                    const searchText = card.getAttribute('data-search-text');
                    const status = card.getAttribute('data-status');
                    
                    const matchesSearch = searchText.includes(searchTerm);
                    const matchesStatus = !statusTerm || status === statusTerm;
                    
                    if (matchesSearch && matchesStatus) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                resultsCount.textContent = visibleCount;
                
                // Show no results message if needed
                const gridContainer = document.querySelector('.grid');
                const existingNoResults = document.getElementById('noResults');
                
                if (visibleCount === 0 && !existingNoResults) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.id = 'noResults';
                    noResultsDiv.className = 'text-center py-12';
                    noResultsDiv.innerHTML = `
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune réservation trouvée</h3>
                        <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
                    `;
                    gridContainer.appendChild(noResultsDiv);
                } else if (visibleCount > 0 && existingNoResults) {
                    existingNoResults.remove();
                }
            }
            
            searchInput.addEventListener('input', filterBookings);
            statusFilter.addEventListener('change', filterBookings);
        });
        
        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            
            const event = new Event('input');
            document.getElementById('searchInput').dispatchEvent(event);
        }
    </script>
</body>
</html>
