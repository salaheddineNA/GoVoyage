<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME','GoVoyage') }}</title>
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
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
            📊 Dashboard
        </a>
        <a href="{{ route('admin.statistics') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
           📈 Statistiques
        </a>
        <a href="{{ route('admin.bookings') }}"
           class="block px-4 py-2 rounded-lg hover:bg-gray-100">
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
                Dashboard Admin
            </h1>
            <p class="text-gray-500 mt-1">
                Vue d'ensemble de votre activité.
            </p>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid md:grid-cols-5 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm">Total Flights</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $flights->count() }}
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm">Active Offers</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $flights->where('is_offer',1)->count() }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm">Direct Flights</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-2">
                        {{ $flights->where('is_direct',1)->count() }}
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm">Total Bookings</h3>
                    <p class="text-3xl font-bold text-orange-600 mt-2">
                        {{ \App\Models\Booking::count() }}
                    </p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm">Messages</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-2">
                        {{ \App\Models\Contact::count() }}
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT CONTACT MESSAGES -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">
                📨 Messages de contact récents
            </h2>
            <a href="{{ route('admin.contacts') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Voir tout →
            </a>
        </div>

        @if($contacts->count() > 0)
        <div class="space-y-3">
            @foreach($contacts->take(3) as $contact)
            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h4 class="font-semibold text-gray-800">{{ $contact->name }}</h4>
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($contact->status === 'new') bg-blue-100 text-blue-800
                                @elseif($contact->status === 'read') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($contact->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">{{ $contact->email }}</p>
                        <p class="text-sm font-medium text-gray-700 mb-2">{{ $contact->subject }}</p>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $contact->message }}</p>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-xs text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500">Aucun message de contact</p>
        </div>
        @endif
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    📋 Réservations récentes
                </h2>
                <a href="{{ route('admin.bookings') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout
                </a>
            </div>

            @if($bookings->count() > 0)
            <div class="space-y-3">
                @foreach($bookings->take(5) as $booking)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-sm">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->flight->from_city }} → {{ $booking->flight->to_city }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-green-600">{{ number_format($booking->total_price, 2) }} MAD</p>
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500">Aucune réservation</p>
            </div>
            @endif
        </div>

        <!-- Recent Flights -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    ✈️ Vols récents
                </h2>
                <a href="{{ route('admin.flights') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout
                </a>
            </div>

            @if($flights->count() > 0)
            <div class="space-y-3">
                @foreach($flights->take(5) as $flight)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-sm">{{ $flight->from_city }} → {{ $flight->to_city }}</p>
                        <p class="text-xs text-gray-500">{{ $flight->airline }}</p>
                    </div>
                    <div class="text-right">
                        @if($flight->newprice)
                            <p class="font-semibold text-green-600">{{ number_format($flight->newprice, 2) }} MAD</p>
                            <span class="text-xs text-red-600">-{{ $flight->percentage }}%</span>
                        @else
                            <p class="font-semibold text-gray-800">{{ number_format($flight->oldprice, 2) }} MAD</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <p class="text-gray-500">Aucun vol</p>
            </div>
            @endif
        </div>
    </div>

</div>

</body>
</html>
