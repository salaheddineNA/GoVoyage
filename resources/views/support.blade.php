<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoVoyage</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <style>
        /* MOBILE ONLY */
        @media (max-width: 768px) {

            /* réduire padding section */
            .contact-section {
                padding: 24px !important;
                background-position: center !important;
                background-size: cover !important;
            }

            /* centrer le formulaire */
            .contact-wrapper {
                margin-left: 0 !important;
                margin-top: 60px !important;
                max-width: 100% !important;
            }

            /* padding form */
            .contact-form {
                padding: 20px !important;
            }

            /* grid formulaire en 1 colonne */
            .contact-grid {
                grid-template-columns: 1fr !important;
            }

            /* grid contact info */
            .contact-info {
                grid-template-columns: 1fr !important;
                gap: 24px !important;
            }

            /* bouton full width */
            .contact-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>


@include('partials.header')



<!-- Contact Form Section -->
<div class="contact-section  p-16 w-full  bg-top bg-no-repeat bg-[url('https://r4.wallpaperflare.com/wallpaper/101/866/548/airbus-a380-lufthansa-sunset-hd-white-lofttansa-passenger-plane-wallpaper-5980c80dd19a2dab26d708bf8071c6ed.jpg')] bg-blue-400 bg-blend-multiply ">
    <div class="contact-wrapper max-w-2xl ml-16 mt-16">
        <div class="contact-form bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Contactez-nous</h2>
            <p class="text-gray-600 mb-8">Nous sommes là pour vous aider. Envoyez-nous votre message et nous vous répondrons dans les plus brefs délais.</p>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="contact-grid grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Votre nom">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="votre@email.com">
                    </div>
                </div>
                
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                    <input type="text" id="subject" name="subject" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Sujet de votre message">
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Décrivez votre demande en détail..."></textarea>
                </div>
                
                <div class="text-center">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                        Envoyer le message
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Contact Information -->
        <div class="contact-info mt-12 grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-white mb-2">Email</h3>
                <p class="text-white">support@govoyage.com</p>
            </div>
            
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-white mb-2">Téléphone</h3>
                <p class="text-white">+212 5XX-XXX-XXX</p>
            </div>
            
            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-white mb-2">Disponibilité</h3>
                <p class="text-white">24/7 Support client</p>
            </div>
        </div>
    </div>
</div>
@include('components.calltoaction')
@include('partials.footer')
</body>
</html>