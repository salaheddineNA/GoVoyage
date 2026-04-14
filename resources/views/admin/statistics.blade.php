<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistiques - {{ env('APP_NAME','GoVoyage') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <a href="{{ route('admin.statistics') }}" class="block px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
            📈 Statistiques
        </a>
        <a href="{{ route('admin.bookings') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            📋 Réservations
        </a>
        <a href="{{ route('admin.flights') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
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
<div class="flex-1 p-6 lg:p-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
            📈 Statistiques du Site Web
        </h1>
        <p class="text-gray-500 mt-1">
            Vue d'ensemble complète des performances de votre plateforme.
        </p>
    </div>

    <!-- OVERVIEW CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-xl transition duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Vols</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalFlights }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-tr from-blue-500 to-indigo-500 text-white rounded-xl flex items-center justify-center text-xl shadow-md hover:scale-110 transition">
                    ✈️
                </div>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-xl transition duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Réservations</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBookings }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-tr from-green-500 to-emerald-500 text-white rounded-xl flex items-center justify-center text-xl shadow-md hover:scale-110 transition">
                    📋
                </div>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-xl transition duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Messages</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalContacts }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-tr from-purple-500 to-pink-500 text-white rounded-xl flex items-center justify-center text-xl shadow-md hover:scale-110 transition">
                    📨
                </div>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-xl transition duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Revenus Totaux</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ number_format($totalRevenue, 2) }} MAD</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-tr from-yellow-400 to-orange-500 text-white rounded-xl flex items-center justify-center text-xl shadow-md hover:scale-110 transition">
                    💰
                </div>
            </div>
        </div>

    </div>

    <!-- MONTHLY TREND -->
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gray-100 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">📈 Tendance des Réservations Mensuelles</h2>
        <div class="h-64">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- DETAILED STATISTICS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-6">📊 Statistiques des Vols</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                    <span class="text-gray-600">Offres Spéciales</span>
                    <span class="font-bold text-blue-600">{{ $totalOffers }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                    <span class="text-gray-600">Vols Directs</span>
                    <span class="font-bold text-green-600">{{ $directFlights }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                    <span class="text-gray-600">Vols avec WiFi</span>
                    <span class="font-bold text-purple-600">{{ $flightsWithWifi }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-6">📋 Statistiques des Réservations</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl">
                    <span class="text-gray-600">Confirmées</span>
                    <span class="font-bold text-green-600">{{ $confirmedBookings }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-xl">
                    <span class="text-gray-600">En Attente</span>
                    <span class="font-bold text-yellow-600">{{ $pendingBookings }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-red-50 rounded-xl">
                    <span class="text-gray-600">Annulées</span>
                    <span class="font-bold text-red-600">{{ $cancelledBookings }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- CONTACT STATISTICS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-6">📨 Statistiques des Messages</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-4 bg-blue-50 rounded-xl">
                    <span class="text-gray-600">Nouveaux</span>
                    <span class="font-bold text-blue-600">{{ $newContacts }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-xl">
                    <span class="text-gray-600">Lus</span>
                    <span class="font-bold text-yellow-600">{{ $readContacts }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl">
                    <span class="text-gray-600">Résolus</span>
                    <span class="font-bold text-green-600">{{ $resolvedContacts }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-6">💰 Analyse des Revenus</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl">
                    <span class="text-gray-600">Revenu Moyen</span>
                    <span class="font-bold text-green-600">{{ number_format($averageBookingValue, 2) }} MAD</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-blue-50 rounded-xl">
                    <span class="text-gray-600">Réservations (7 jours)</span>
                    <span class="font-bold text-blue-600">{{ $recentBookings }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-purple-50 rounded-xl">
                    <span class="text-gray-600">Messages (7 jours)</span>
                    <span class="font-bold text-purple-600">{{ $recentContacts }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- POPULAR ROUTES -->
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gray-100 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">🗺 Routes les Plus Populaires</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Route</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Réservations</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($popularRoutes as $route)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 font-semibold">{{ $route->from_city }} → {{ $route->to_city }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $route->count }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-gray-500">
                            Aucune donnée disponible
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
// Monthly trend chart
const ctx = document.getElementById('monthlyChart').getContext('2d');
const monthlyData = @json($monthlyBookings);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthlyData.map(item => {
            const [year, month] = item.month.split('-');
            const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            return monthNames[parseInt(month) - 1] + ' ' + year;
        }),
        datasets: [{
            label: 'Réservations',
            data: monthlyData.map(item => item.count),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

</body>
</html>
