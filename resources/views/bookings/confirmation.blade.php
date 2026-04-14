<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réservation - {{ env('APP_NAME','GoVoyage') }}</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body>
    @include('partials.header')
    
    <div class="min-h-screen bg-gray-50 py-8 mt-20">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Success Message -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h2 class="text-2xl font-bold text-green-800">Réservation confirmée!</h2>
                        <p class="text-green-700">Votre réservation a été enregistrée avec succès.</p>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Détails de la réservation</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Informations de réservation</h4>
                        <div class="space-y-2">
                            <p><span class="text-gray-600">Référence:</span> <span class="font-mono font-bold">{{ $booking->booking_reference }}</span></p>
                            <p><span class="text-gray-600">Statut:</span> 
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                            <p><span class="text-gray-600">Date de réservation:</span> {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Informations du passager</h4>
                        <div class="space-y-2">
                            <p><span class="text-gray-600">Nom:</span> {{ $booking->first_name }} {{ $booking->last_name }}</p>
                            <p><span class="text-gray-600">Email:</span> {{ $booking->email }}</p>
                            <p><span class="text-gray-600">Téléphone:</span> {{ $booking->phone }}</p>
                            <p><span class="text-gray-600">Passagers:</span> {{ $booking->passengers }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flight Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Détails du vol</h3>
                
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-lg font-semibold">{{ $booking->flight->from_city }} → {{ $booking->flight->to_city }}</p>
                        <p class="text-gray-600">{{ $booking->flight->airline }}</p>
                        <p class="text-gray-500">Durée: {{ $booking->flight->duration }}</p>
                        <p class="text-gray-500">Date de voyage: {{ $booking->travel_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        @if($booking->flight->newprice)
                            <p class="text-gray-400 line-through">{{ number_format($booking->flight->oldprice, 2) }} MAD</p>
                            <p class="text-xl font-bold text-green-600">{{ number_format($booking->flight->newprice, 2) }} MAD</p>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">
                                -{{ $booking->flight->percentage }}%
                            </span>
                        @else
                            <p class="text-xl font-bold text-gray-800">{{ number_format($booking->flight->oldprice, 2) }} MAD</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    @if($booking->flight->has_wifi)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.44 12.44 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.52.52 0 0 0 .668.05A11.45 11.45 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049"/>
                            </svg>
                            WiFi disponible
                        </span>
                    @endif
                    @if($booking->flight->is_direct)
                        <span class="flex items-center">
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
                </div>
            </div>

            <!-- Price Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Récapitulatif des prix</h3>
                
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Prix par passager:</span>
                        <span>{{ $booking->flight->newprice ? number_format($booking->flight->newprice, 2) : number_format($booking->flight->oldprice, 2) }} MAD</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nombre de passagers:</span>
                        <span>{{ $booking->passengers }}</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Total payé:</span>
                            <span class="text-xl font-bold text-green-600">{{ number_format($booking->total_price, 2) }} MAD</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($booking->special_requests)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Demandes spéciales</h3>
                <p class="text-gray-600">{{ $booking->special_requests }}</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('offer') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Retour aux offres
                </a>
                <a href="{{ route('bookings.my') }}" 
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Mes réservations
                </a>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>
</html>
