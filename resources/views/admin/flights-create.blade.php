<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un vol - {{ env('APP_NAME','GoVoyage') }}</title>
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
        <a href="{{ route('admin.bookings') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            📋 Réservations
        </a>
        <a href="{{ route('admin.flights') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
            ✈️ Vols
        </a>
        <a href="{{ route('admin.flights.create') }}" class="block px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
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
                ➕ Ajouter un nouveau vol
            </h1>
            <p class="text-gray-500 mt-1">
                Remplissez les informations pour créer un nouveau vol.
            </p>
        </div>
        <a href="{{ route('admin.flights') }}" 
           class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            ← Retour aux vols
        </a>
    </div>

    <!-- FORM -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('flights.store') }}" method="POST" class="grid md:grid-cols-2 gap-6">
            @csrf

            <!-- Route Information -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">📍 Informations de trajet</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ville de départ</label>
                <input type="text" name="from_city" placeholder="Ex: Paris" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ville d'arrivée</label>
                <input type="text" name="to_city" placeholder="Ex: New York" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Airline Information -->
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">✈️ Informations compagnie</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la compagnie</label>
                <input type="text" name="airline" placeholder="Ex: GoVoyage" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo de la compagnie (URL)</label>
                <input type="url" name="imageAirline" placeholder="https://example.com/logo.png" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Image de la destination (URL)</label>
                <input type="url" name="cityimg" placeholder="https://example.com/city.jpg" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Schedule Information -->
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">⏰ Horaires et durée</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Heure de départ</label>
                <input type="datetime-local" id="departing_time" name="departing_time" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Heure d'arrivée</label>
                <input type="datetime-local" id="arriving_time" name="arriving_time" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Durée</label>
                <input type="text" id="duration" name="duration" readonly
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Durée calculée automatiquement</label>
                <div class="px-4 py-3 bg-blue-50 rounded-xl text-blue-700 text-sm">
                    ⏱️ Sera calculée selon les heures de départ/arrivée
                </div>
            </div>

            <!-- Features -->
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">🎯 Caractéristiques du vol</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type de vol</label>
                <select name="is_direct" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="1">✈️ Vol direct</option>
                    <option value="0">🔄 Vol avec escale</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">WiFi à bord</label>
                <select name="has_wifi" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="1">📶 WiFi disponible</option>
                    <option value="0">❌ Pas de WiFi</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut vedette</label>
                <select name="showcase" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="1">⭐ Vol vedette</option>
                    <option value="0">Vol normal</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Offre spéciale</label>
                <select id="is_offer" name="is_offer" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="0">❌ Pas d'offre</option>
                    <option value="1">🎉 Offre spéciale</option>
                </select>
            </div>

            <!-- Pricing -->
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">💰 Tarification</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prix normal (MAD)</label>
                <input type="number" step="0.01" id="oldprice" name="oldprice" placeholder="2500.00" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prix promotionnel (MAD)</label>
                <input type="number" step="0.01" id="newprice" name="newprice" placeholder="1999.00"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pourcentage de réduction</label>
                <input type="text" id="offer_percentage" name="percentage" readonly
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Réduction calculée</label>
                <div class="px-4 py-3 bg-green-50 rounded-xl text-green-700 text-sm">
                    💡 Sera calculée automatiquement
                </div>
            </div>

            <!-- Submit -->
            <div class="md:col-span-2 mt-8 flex justify-between">
                <a href="{{ route('admin.flights') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold">
                    🚀 Créer le vol
                </button>
            </div>
        </form>
    </div>

</div>

<!-- JavaScript -->
<script>
function calculateDuration() {
    const departingTime = document.getElementById('departing_time').value;
    const arrivingTime = document.getElementById('arriving_time').value;
    
    if (departingTime && arrivingTime) {
        const departDate = new Date(departingTime);
        const arriveDate = new Date(arrivingTime);
        let diffMs = arriveDate - departDate;
        
        if (diffMs < 0) diffMs += 24 * 60 * 60 * 1000;
        
        const diffMinutes = Math.floor(diffMs / (1000 * 60));
        const hours = Math.floor(diffMinutes / 60);
        const minutes = diffMinutes % 60;
        
        document.getElementById('duration').value = `${hours}h ${minutes}m`;
    } else {
        document.getElementById('duration').value = '';
    }
}

function calculatePercentage() {
    const oldPrice = parseFloat(document.getElementById('oldprice').value);
    const newPrice = parseFloat(document.getElementById('newprice').value);
    
    if (!isNaN(oldPrice) && !isNaN(newPrice) && oldPrice > 0 && newPrice > 0 && newPrice <= oldPrice) {
        const percentage = ((oldPrice - newPrice) / oldPrice) * 100;
        document.getElementById('offer_percentage').value = `${percentage.toFixed(2)}`;
    } else {
        document.getElementById('offer_percentage').value = '';
    }
}

function togglePriceField() {
    const isOffer = document.getElementById('is_offer').value;
    const newPriceField = document.getElementById('newprice');
    newPriceField.disabled = isOffer !== '1';
    if (isOffer !== '1') {
        newPriceField.value = '';
        document.getElementById('offer_percentage').value = '';
    }
}

// Event listeners
document.getElementById('departing_time').addEventListener('input', calculateDuration);
document.getElementById('arriving_time').addEventListener('input', calculateDuration);
document.getElementById('oldprice').addEventListener('input', calculatePercentage);
document.getElementById('newprice').addEventListener('input', calculatePercentage);
document.getElementById('is_offer').addEventListener('change', togglePriceField);
document.addEventListener('DOMContentLoaded', togglePriceField);
</script>

</body>
</html>
