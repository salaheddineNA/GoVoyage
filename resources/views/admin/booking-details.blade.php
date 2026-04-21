<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Détails Réservation - {{ env('APP_NAME','GoVoyage') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 bg-white shadow-xl hidden lg:flex flex-col">
    <div class="p-6 border-b">
        <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto object-contain" alt="GoVoyage Logo" />
        </a>
        <h2 class="text-xl text-center font-bold text-blue-600">Admin Panel</h2>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            📊 Dashboard
        </a>
        
        <a href="{{ route('admin.bookings') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            📋 Réservations
        </a>
        <a href="{{ route('admin.flights') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
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
        <a href="{{ route('support') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            🎧 Support
        </a>
    </nav>

    <div class="p-4 border-t">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                🚪 Logout
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
                📋 Détails de la réservation
            </h1>
            <p class="text-gray-500 mt-1">
                Informations complètes de la réservation.
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.bookings') }}" 
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                ← Retour
            </a>
            @if($booking->status === 'pending')
            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    ✅ Confirmer
                </button>
            </form>
            @endif
            @if($booking->status !== 'cancelled')
            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    ❌ Annuler
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- BOOKING DETAILS -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <!-- Booking Info -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">📋 Informations de réservation</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b">
                    <span class="text-gray-600">Référence:</span>
                    <span class="font-mono font-bold text-blue-600">{{ $booking->booking_reference }}</span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b">
                    <span class="text-gray-600">Statut:</span>
                    <span class="px-3 py-1 text-sm font-medium rounded-full 
                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b">
                    <span class="text-gray-600">Date réservation:</span>
                    <span class="font-medium">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-600">Date voyage:</span>
                    <span class="font-medium">{{ $booking->travel_date->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Passenger Info -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">👤 Informations du passager</h2>
            
            <div class="space-y-4">
                <div class="py-3 border-b">
                    <p class="text-gray-600 text-sm mb-1">Nom complet</p>
                    <p class="font-medium text-lg">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                </div>
                
                <div class="py-3 border-b">
                    <p class="text-gray-600 text-sm mb-1">Email</p>
                    <p class="font-medium">{{ $booking->email }}</p>
                </div>
                
                <div class="py-3 border-b">
                    <p class="text-gray-600 text-sm mb-1">Téléphone</p>
                    <p class="font-medium">{{ $booking->phone }}</p>
                </div>
                
                <div class="py-3">
                    <p class="text-gray-600 text-sm mb-1">Nombre de passagers</p>
                    <p class="font-medium text-lg">{{ $booking->passengers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FLIGHT DETAILS -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">✈️ Détails du vol</h2>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <div class="space-y-4">
                    <div class="py-3 border-b">
                        <p class="text-gray-600 text-sm mb-1">Trajet</p>
                        <p class="font-medium text-lg">{{ $booking->flight->from_city }} → {{ $booking->flight->to_city }}</p>
                    </div>
                    
                    <div class="py-3 border-b">
                        <p class="text-gray-600 text-sm mb-1">Compagnie</p>
                        <div class="flex items-center space-x-3">
                            <img src="{{ $booking->flight->imageAirline }}" alt="{{ $booking->flight->airline }}" 
                                 class="h-8 w-8 rounded-full object-cover">
                            <span class="font-medium">{{ $booking->flight->airline }}</span>
                        </div>
                    </div>
                    
                    <div class="py-3 border-b">
                        <p class="text-gray-600 text-sm mb-1">Durée</p>
                        <p class="font-medium">{{ $booking->flight->duration }}</p>
                    </div>
                    
                    <div class="py-3">
                        <p class="text-gray-600 text-sm mb-1">Caractéristiques</p>
                        <div class="flex flex-wrap gap-2">
                            @if($booking->flight->has_wifi)
                                <span class="flex items-center text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                    📶 WiFi
                                </span>
                            @endif
                            @if($booking->flight->is_direct)
                                <span class="flex items-center text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">
                                    ✈️ Direct
                                </span>
                            @else
                                <span class="flex items-center text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded">
                                    🔄 Escale
                                </span>
                            @endif
                            @if($booking->flight->is_offer)
                                <span class="flex items-center text-xs bg-red-100 text-red-800 px-2 py-1 rounded">
                                    🎉 Offre -{{ $booking->flight->percentage }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="space-y-4">
                    <div class="py-3 border-b">
                        <p class="text-gray-600 text-sm mb-1">Départ</p>
                        <p class="font-medium">{{ $booking->flight->departing_time }}</p>
                    </div>
                    
                    <div class="py-3 border-b">
                        <p class="text-gray-600 text-sm mb-1">Arrivée</p>
                        <p class="font-medium">{{ $booking->flight->arriving_time }}</p>
                    </div>
                    
                    <div class="py-3">
                        <p class="text-gray-600 text-sm mb-1">Images</p>
                        <div class="space-y-2">
                            <img src="{{ $booking->flight->imageAirline }}" alt="Logo compagnie" 
                                 class="h-16 w-auto object-contain rounded">
                            <img src="{{ $booking->flight->cityimg }}" alt="Destination" 
                                 class="h-24 w-auto object-cover rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PRICE SUMMARY -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">💰 Récapitulatif des prix</h2>
        
        <div class="space-y-3">
            <div class="flex justify-between items-center py-3 border-b">
                <span class="text-gray-600">Prix par passager:</span>
                <span class="font-medium">
                    {{ $booking->flight->newprice ? number_format($booking->flight->newprice, 2) : number_format($booking->flight->oldprice, 2) }} MAD
                </span>
            </div>
            
            <div class="flex justify-between items-center py-3 border-b">
                <span class="text-gray-600">Nombre de passagers:</span>
                <span class="font-medium">{{ $booking->passengers }}</span>
            </div>
            
            @if($booking->flight->newprice)
            <div class="flex justify-between items-center py-3 border-b">
                <span class="text-gray-600">Remise totale:</span>
                <span class="font-medium text-red-600">
                    -{{ number_format(($booking->flight->oldprice - $booking->flight->newprice) * $booking->passengers, 2) }} MAD
                </span>
            </div>
            @endif
            
            <div class="flex justify-between items-center pt-3">
                <span class="text-lg font-bold">Total payé:</span>
                <span class="text-2xl font-bold text-green-600">
                    {{ number_format($booking->total_price, 2) }} MAD
                </span>
            </div>
        </div>
    </div>

    @if($booking->special_requests)
    <!-- SPECIAL REQUESTS -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 Demandes spéciales</h2>
        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $booking->special_requests }}</p>
    </div>
    @endif

</div>

</body>
</html>
