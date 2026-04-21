<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un vol - {{ env('APP_NAME','GoVoyage') }}</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body>
    @include('partials.header')
    
    <div class="min-h-screen bg-gray-50 py-8 mt-20">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Flight Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Détails du vol</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg font-semibold">{{ $flight->from_city }} → {{ $flight->to_city }}</p>
                        <p class="text-gray-600">{{ $flight->airline }}</p>
                        <p class="text-gray-500">Durée: {{ $flight->duration }}</p>
                    </div>
                    <div class="text-right">
                        @if($flight->newprice)
                            <p class="text-gray-400 line-through">{{ number_format($flight->oldprice, 2) }} MAD</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($flight->newprice, 2) }} MAD</p>
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">
                                -{{ $flight->percentage }}%
                            </span>
                        @else
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($flight->oldprice, 2) }} MAD</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informations de réservation</h2>
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bookings.store', $flight->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                            <input type="text" name="first_name" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                            <input type="text" name="last_name" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" name="phone" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de voyage</label>
                            <input type="date" name="travel_date" required
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de passagers</label>
                            <select name="passengers" id="passengers" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="1">1 passager</option>
                                <option value="2">2 passagers</option>
                                <option value="3">3 passagers</option>
                                <option value="4">4 passagers</option>
                                <option value="5">5 passagers</option>
                                <option value="6">6 passagers</option>
                                <option value="7">7 passagers</option>
                                <option value="8">8 passagers</option>
                                <option value="9">9 passagers</option>
                                <option value="10">10 passagers</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Demandes spéciales (optionnel)</label>
                        <textarea name="special_requests" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Repas spéciaux, assistance, etc."></textarea>
                    </div>

                    <!-- Price Summary -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Prix par passager:</span>
                            <span id="price-per-passenger" class="font-semibold">
                                {{ $flight->newprice ? number_format($flight->newprice, 2) : number_format($flight->oldprice, 2) }} MAD
                            </span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Nombre de passagers:</span>
                            <span id="passengers-count" class="font-semibold">1</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">Total:</span>
                                <span id="total-price" class="text-xl font-bold text-green-600">
                                    {{ $flight->newprice ? number_format($flight->newprice, 2) : number_format($flight->oldprice, 2) }} MAD
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('offer') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Retour aux offres
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                            Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const pricePerPassenger = {{ $flight->newprice ?: $flight->oldprice }};
        const passengersSelect = document.getElementById('passengers');
        const passengersCount = document.getElementById('passengers-count');
        const totalPrice = document.getElementById('total-price');

        function updatePrice() {
            const passengers = parseInt(passengersSelect.value);
            passengersCount.textContent = passengers;
            const total = pricePerPassenger * passengers;
            totalPrice.textContent = total.toFixed(2) + ' MAD';
        }

        passengersSelect.addEventListener('change', updatePrice);
    </script>

    @include('partials.footer')
</body>
</html>
