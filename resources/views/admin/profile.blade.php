<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - {{env('APP_NAME','GoVoyage')}}</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

<!-- HEADER -->
<header class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" class="h-12">
                <h1 class="text-xl font-semibold text-[#0151cb]">
                    Profil Administrateur
                </h1>
            </div>

            <div class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('dashboard') }}" 
                   class="text-gray-600 hover:text-blue-600 transition">
                    Dashboard
                </a>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition shadow-sm">
                        Déconnexion
                    </button>
                </form>
            </div>

        </div>
    </div>
</header>

<!-- CONTENT -->
<main class="max-w-screen-2xl mx-auto py-10 px-6">

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- CARD 1 -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800 mb-6">
                Mettre à jour le profil
            </h2>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                @csrf

                <!-- Profile Photo Section -->
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        @if($currentAdmin && $currentAdmin->profile_photo)
                            <img class="h-16 w-16 object-cover rounded-full" 
                                 src="{{ asset('storage/' . $currentAdmin->profile_photo) }}" 
                                 alt="Photo de profil">
                        @else
                            <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A9.974 9.974 0 0 0 10.007 14C9.051 14 8 12.979 8 11.993c0-1.006.951-2.007 2.007-2.007 1.006 0 2.007.951 2.007 2.007v2.993h8v-2.993C20.007 12.979 19.051 14 18.007 14c-1.006 0-2.007-.951-2.007-2.007z"/>
                                    <path d="M12.007 0C5.374 0 0 5.374 0 12.007s5.374 12.007 12.007 12.007 12.007-5.374 12.007-12.007S18.64 0 12.007 0zm0 20.007c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Photo de profil
                        </label>
                        <input type="file" name="profile_photo" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF jusqu'à 2MB</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Mot de passe actuel
                    </label>
                    <input type="password" name="current_password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ $adminEmail }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Nouveau mot de passe
                    </label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Confirmer mot de passe
                    </label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition shadow-md">
                    Mettre à jour le profil
                </button>

            </form>
        </div>

        <!-- CARD 2 -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">

            <h2 class="text-lg font-semibold text-gray-800 mb-6">
                Gestion des administrateurs
            </h2>

            <!-- ADD ADMIN -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-600 mb-4 uppercase tracking-wide">
                    Ajouter un administrateur
                </h3>

                <form action="{{ route('admin.add') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                    @csrf

                    <div class="flex items-center space-x-6 mb-4">
                        <div class="shrink-0">
                            <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A9.974 9.974 0 0 0 10.007 14C9.051 14 8 12.979 8 11.993c0-1.006.951-2.007 2.007-2.007 1.006 0 2.007.951 2.007 2.007v2.993h8v-2.993C20.007 12.979 19.051 14 18.007 14c-1.006 0-2.007-.951-2.007-2.007z"/>
                                    <path d="M12.007 0C5.374 0 0 5.374 0 12.007s5.374 12.007 12.007 12.007 12.007-5.374 12.007-12.007S18.64 0 12.007 0zm0 20.007c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Photo de profil
                            </label>
                            <input type="file" name="profile_photo" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF jusqu'à 2MB</p>
                        </div>
                    </div>

                    <input type="text" name="name" placeholder="Nom"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">

                    <input type="email" name="email" placeholder="Email"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">

                    <input type="password" name="password" placeholder="Mot de passe"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">

                    <input type="password" name="password_confirmation" placeholder="Confirmer mot de passe"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">

                    <div class="flex items-center space-x-3">
                        <input type="checkbox" id="is_deletable" name="is_deletable" value="1" checked
                               class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <label for="is_deletable" class="text-sm text-gray-700">
                            Permettre la suppression de ce compte ultérieurement
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg shadow-md transition">
                        Ajouter Administrateur
                    </button>
                </form>
            </div>

            <!-- TABLE -->
            <div>
                <h3 class="text-sm font-semibold text-gray-600 mb-4 uppercase tracking-wide">
                    Liste des administrateurs
                </h3>

                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-500 uppercase tracking-wider">Photo</th>
                                <th class="px-6 py-3 text-left text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-gray-500 uppercase tracking-wider">Supprimable</th>
                                <th class="px-6 py-3 text-left text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">

                            @foreach($admins as $admin)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @if($admin->profile_photo)
                                        <img class="h-10 w-10 object-cover rounded-full" 
                                             src="{{ asset('storage/' . $admin->profile_photo) }}" 
                                             alt="{{ $admin->name }}">
                                    @else
                                        <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A9.974 9.974 0 0 0 10.007 14C9.051 14 8 12.979 8 11.993c0-1.006.951-2.007 2.007-2.007 1.006 0 2.007.951 2.007 2.007v2.993h8v-2.993C20.007 12.979 19.051 14 18.007 14c-1.006 0-2.007-.951-2.007-2.007z"/>
                                                <path d="M12.007 0C5.374 0 0 5.374 0 12.007s5.374 12.007 12.007 12.007 12.007-5.374 12.007-12.007S18.64 0 12.007 0zm0 20.007c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $admin->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $admin->email }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($admin->is_deletable)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Oui
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                            Non
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($admin->id === 1 || ($currentAdmin && $admin->id === $currentAdmin->id) || $admin->email === $adminEmail || !$admin->is_deletable)
                                        <span class="text-gray-400 text-sm">Non supprimable</span>
                                    @else
                                        <form action="{{ route('admin.delete', $admin->id) }}" method="POST"
                                              onsubmit="return confirm('Supprimer cet administrateur ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-800 font-medium text-sm">
                                                Supprimer
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

</main>

</body>
</html>