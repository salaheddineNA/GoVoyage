<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Réservations - {{ env('APP_NAME','GoVoyage') }}</title>
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
        <a href="{{ route('admin.statistics') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
           📈 Statistiques
        </a>
        <a href="{{ route('admin.bookings') }}" class="block px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
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
                📋 Réservations
            </h1>
            <p class="text-gray-500 mt-1">
                Gérez toutes les réservations des utilisateurs.
            </p>
        </div>
        <div class="flex space-x-3">
            <div class="bg-white px-4 py-2 rounded-lg shadow">
                <span class="text-sm text-gray-500">Total:</span>
                <span class="font-bold text-blue-600">{{ $bookings->count() }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- FILTERS -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('admin.bookings') }}" class="flex flex-wrap gap-4">
            <select name="status" id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Rechercher par nom, email, référence..." 
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                🔍 Rechercher
            </button>
            <a href="{{ route('admin.bookings') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                🔄 Réinitialiser
            </a>
        </form>
    </div>

    <!-- BOOKINGS TABLE -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Référence</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Client</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Vol</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Date voyage</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Passagers</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Total</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Statut</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition booking-row"
                        data-search-text="{{ strtolower($booking->first_name . ' ' . $booking->last_name . ' ' . $booking->email . ' ' . $booking->booking_reference . ' ' . $booking->flight->from_city . ' ' . $booking->flight->to_city . ' ' . $booking->flight->airline) }}"
                        data-status="{{ $booking->status }}">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">
                                {{ $booking->booking_reference }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->email }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->phone }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium">{{ $booking->flight->from_city }} → {{ $booking->flight->to_city }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->flight->airline }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->flight->duration }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium">{{ $booking->travel_date->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                {{ $booking->passengers }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-green-600">{{ number_format($booking->total_price, 2) }} MAD</p>
                            @if($booking->flight->newprice)
                                <p class="text-xs text-gray-500">{{ $booking->passengers }} × {{ number_format($booking->flight->newprice, 2) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    👁️ Voir
                                </a>
                                @if($booking->status === 'pending')
                                <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 font-medium text-sm">
                                        ✅ Confirmer
                                    </button>
                                </form>
                                @endif
                                @if($booking->status !== 'cancelled')
                                <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        ❌ Annuler
                                    </button>
                                </form>
                                @endif
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune réservation</h3>
            <p class="text-gray-500 mb-6">Les utilisateurs n'ont pas encore effectué de réservations.</p>
            <a href="{{ route('offer') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Voir les offres
            </a>
        </div>
        @endif
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const statusFilter = document.getElementById('statusFilter');
    const bookingRows = document.querySelectorAll('.booking-row');
    const resultsCount = document.querySelector('span.font-bold.text-blue-600');
    
    function filterBookings() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        let visibleCount = 0;
        
        bookingRows.forEach(row => {
            const searchText = row.getAttribute('data-search-text');
            const status = row.getAttribute('data-status');
            
            const matchesSearch = !searchTerm || searchText.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
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
        searchInput.addEventListener('input', filterBookings);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterBookings);
    }
    
    // Initial filter
    filterBookings();
});
</script>

</body>
</html>
