<!-- <section class="bg-[#f1c933]">
    <div class="p-14">
        <div class="mb-6 rounded-lg overflow-hidden relative h-72 md:h-96 group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent z-10"></div>
            <img 
                src="{{ asset('images/img.avif') }}" 
                alt="" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            >
            <div class="absolute inset-0 flex flex-col justify-between p-6 md:p-8 z-20">
                <div>
                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                        Enjoy nature sustainable travel in the BMW iX
                    </h1>
                    <button class="border-2 border-white text-white px-6 py-2 rounded hover:bg-white hover:text-slate-900 transition-colors font-medium">
                        Show more
                    </button>
                </div>
            </div>
        </div> 

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="rounded-lg overflow-hidden relative h-80 group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900  to-transparent z-10"></div>
            <img 
            src="{{ asset('images/CathayPacific.jpg') }}"  
            alt="BMW iX Luxury" 
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            >
            <div class="absolute inset-0 flex flex-col justify-end p-6 z-20">
            <h2 class="text-2xl font-bold text-white mb-4">
                Enjoy nature sustainable travel in the BMW iX
            </h2>
            <button class="border-2 border-white text-white px-6 py-2 rounded hover:bg-white hover:text-slate-900 transition-colors font-medium w-fit">
                Show more
            </button>
            </div>
        </div>

        <div class="rounded-lg overflow-hidden relative h-80 group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900  to-transparent z-10"></div>
            <img 
            src="{{ asset('images/QatarAirways.jpg') }}" 
            alt="BMW iX Performance" 
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            >
            <div class="absolute inset-0 flex flex-col justify-end p-6 z-20">
            <h2 class="text-2xl font-bold text-white mb-4">
                Enjoy nature sustainable travel in the BMW iX
            </h2>
            <button class="border-2 border-white text-white px-6 py-2 rounded hover:bg-white hover:text-slate-900 transition-colors font-medium w-fit">
                Show more
            </button>
            </div>
        </div>
        </div>
    </div>
</section> -->

<section class="bg-[#f1c933] py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">

        <!-- Title -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0c47bc]">
                Découvrez des destinations d'exception
            </h2>
            <p class="mt-2 text-[#0c47bc]">
                Découvrez les compagnies aériennes de luxe et des voyages inoubliables.
            </p>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Card -->
            <div class="group relative h-80 rounded-2xl overflow-hidden shadow-xl cursor-pointer">

                <!-- Image -->
                <img src="{{ asset('images/CathayPacific.jpg') }}"
                     class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-110">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                <!-- Content -->
                <div class="absolute bottom-0 p-12 text-white">
                    <h3 class="text-2xl font-semibold mb-6 leading-snug">
                        Voyagez avec confort et élégance
                    </h3>

                    <a href="{{route('flight')}}"
                        class="bg-[#0c47bc] text-white px-6 py-2 rounded-full font-semibold
                               translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100
                               transition duration-300 shadow-lg hover:scale-105">
                        Afficher plus
                    </a>
                </div>
            </div>

            <!-- Card -->
            <div class="group relative h-80 rounded-2xl overflow-hidden shadow-xl cursor-pointer">

                <img src="{{ asset('images/QatarAirways.jpg') }}"
                     class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-110">

                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                <div class="absolute bottom-0 p-12 text-white">
                    <h3 class="text-2xl font-semibold mb-6 leading-snug">
                        Voyager au-delà des attentes
                    </h3>

                    <a href="{{route('offer')}}"
                        class="bg-[#0c47bc] text-white  px-6 py-2 rounded-full font-semibold
                               translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100
                               transition duration-300 shadow-lg hover:scale-105">
                        Afficher plus
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>