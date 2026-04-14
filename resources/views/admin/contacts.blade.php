<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME','GoVoyage') }} - Messages de Contact</title>
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
            <a href="{{ route('admin.statistics') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
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
            <a href="{{ route('admin.contacts') }}" class="block px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
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
                    📨 Messages de Contact
                </h1>
                <p class="text-gray-500 mt-1">
                    Gérez tous les messages envoyés par les utilisateurs.
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                    <span class="font-semibold">{{ $contacts->where('status', 'new')->count() }}</span> nouveaux
                </div>
                <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg">
                    <span class="font-semibold">{{ $contacts->where('status', 'read')->count() }}</span> lus
                </div>
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                    <span class="font-semibold">{{ $contacts->where('status', 'resolved')->count() }}</span> résolus
                </div>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par statut</label>
                    <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les messages</option>
                        <option value="new">Nouveaux</option>
                        <option value="read">Lus</option>
                        <option value="resolved">Résolus</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text" id="searchInput" placeholder="Nom, email, sujet..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <button onclick="clearFilters()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    🔄 Réinitialiser
                </button>
            </div>
        </div>

        <!-- CONTACTS LIST -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            @if($contacts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-600">Contact</th>
                            <th class="px-6 py-3 text-left text-gray-600">Sujet</th>
                            <th class="px-6 py-3 text-left text-gray-600">Message</th>
                            <th class="px-6 py-3 text-left text-gray-600">Date</th>
                            <th class="px-6 py-3 text-left text-gray-600">Statut</th>
                            <th class="px-6 py-3 text-left text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" id="contactsTableBody">
                        @foreach($contacts as $contact)
                        <tr class="hover:bg-gray-50 transition contact-row" 
                            data-status="{{ $contact->status }}"
                            data-name="{{ strtolower($contact->name) }}"
                            data-email="{{ strtolower($contact->email) }}"
                            data-subject="{{ strtolower($contact->subject) }}">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium">{{ $contact->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $contact->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $contact->subject }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 max-w-xs truncate">{{ $contact->message }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    @if($contact->status === 'new') bg-blue-100 text-blue-800
                                    @elseif($contact->status === 'read') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($contact->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    @if($contact->status !== 'read')
                                    <form action="{{ route('admin.contact.read', $contact->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-xs bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                                title="Marquer comme lu">
                                            ✓ Lu
                                        </button>
                                    </form>
                                    @endif
                                    @if($contact->status !== 'resolved')
                                    <form action="{{ route('admin.contact.resolved', $contact->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-xs bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                                                title="Marquer comme résolu">
                                            ✓ Résolu
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.contact.delete', $contact->id) }}" method="POST" class="inline" 
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-xs bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                                title="Supprimer">
                                            🗑️
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
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun message de contact</h3>
                <p class="text-gray-500">Les messages des utilisateurs apparaîtront ici.</p>
            </div>
            @endif
        </div>

    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    <script>
    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', filterContacts);
    document.getElementById('searchInput').addEventListener('input', filterContacts);

    function filterContacts() {
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.contact-row');

        rows.forEach(row => {
            const status = row.dataset.status;
            const name = row.dataset.name;
            const email = row.dataset.email;
            const subject = row.dataset.subject;

            const matchesStatus = !statusFilter || status === statusFilter;
            const matchesSearch = !searchInput || 
                name.includes(searchInput) || 
                email.includes(searchInput) || 
                subject.includes(searchInput);

            row.style.display = matchesStatus && matchesSearch ? '' : 'none';
        });
    }

    function clearFilters() {
        document.getElementById('statusFilter').value = '';
        document.getElementById('searchInput').value = '';
        filterContacts();
    }

    // Auto-hide success message
    setTimeout(() => {
        const successMsg = document.querySelector('.fixed.top-4.right-4');
        if (successMsg) {
            successMsg.style.display = 'none';
        }
    }, 3000);
    </script>

</body>
</html>
