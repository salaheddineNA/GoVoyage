<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME','GoVoyage')}}</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/3239/3239945.png">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>

<body>
    @include('partials.header')

    <section class="bg-white">
        <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
            <aside class="relative block h-16 lg:order-last lg:col-span-5 lg:h-full xl:col-span-6">
                <img
                    alt=""
                    src="https://media.cntraveler.com/photos/607f3c487774091e06dd5d21/16:9/w_2560%2Cc_limit/Breeze%2520Airways_166655077_303814634409055_8038496796049085212_n.jpeg"
                    class="absolute inset-0 h-full w-full object-cover" />
            </aside>

            <main
                class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
                <div class="max-w-xl lg:max-w-3xl">
                    <a class="block text-blue-600" href="/">
                        <span class="sr-only">logo</span>
                        <img src="https://seeklogo.com/images/H/hong-kong-airlines-logo-B5E8D635C9-seeklogo.com.png" alt="logo" class=" w-16">
                    </a>

                    <h1 class="mt-6 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">
                        Modifier le Vol
                    </h1>

                    <div class="mt-4 flex items-center justify-between">
                        <p class="leading-relaxed text-gray-500">
                            if you have any probleme in system let us know by calling the <a href="{{route('support')}}" class=" underline hover:text-red-500 ">Support</a> staff
                        </p>
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 underline">
                            ← Retour au Dashboard
                        </a>
                    </div>

                    <form action="{{ route('flights.update', $flight->id) }}" method="POST" class="mt-8 grid grid-cols-1 gap-6">
                        @method('PUT')
                        @csrf

                        @if ($errors->any())
                        <div class="col-span-1 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Departure and Arrival -->
                        <div class="col-span-2">
                            <label for="from_city" class="block text-sm font-medium text-gray-700">From City</label>
                            <input type="text" id="from_city" name="from_city" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->from_city}}" required />
                        </div>

                        <div class="col-span-1">
                            <label for="to_city" class="block text-sm font-medium text-gray-700">To City</label>
                            <input type="text" id="to_city" name="to_city" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->to_city}}" required />
                        </div>

                        <!-- Airline Details -->
                        <div class="col-span-1">
                            <label for="airline" class="block text-sm font-medium text-gray-700">Airline Name</label>
                            <input type="text" id="airline" name="airline" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->airline}}" required />
                        </div>

                        <div class="col-span-1">
                            <label for="imageAirline" class="block text-sm font-medium text-gray-700">Airline Logo URL</label>
                            <input type="url" id="imageAirline" name="imageAirline" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->imageAirline}}" required />
                        </div>

                        <div class="col-span-1">
                            <label for="cityimg" class="block text-sm font-medium text-gray-700">City Image URL</label>
                            <input type="url" id="cityimg" name="cityimg" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->cityimg}}" required />
                        </div>

                        <!-- Timing -->
                        <div class="col-span-1">
                            <label for="departing_time" class="block text-sm font-medium text-gray-700">Departing Time</label>
                            <input type="datetime-local" id="departing_time" name="departing_time" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->departing_time}}" required />
                        </div>

                        <div class="col-span-1">
                            <label for="arriving_time" class="block text-sm font-medium text-gray-700">Arriving Time</label>
                            <input type="datetime-local" id="arriving_time" name="arriving_time" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->arriving_time}}" required />
                        </div>

                        <!-- Offer and Features -->
                        <div class="col-span-1">
                            <label for="is_offer" class="block text-sm font-medium text-gray-700">Is Offer</label>
                            <select id="is_offer" name="is_offer" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm">
                                <option value="0" {{ $flight->is_offer == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $flight->is_offer == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label for="has_wifi" class="block text-sm font-medium text-gray-700">Has WiFi</label>
                            <select id="has_wifi" name="has_wifi" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm">
                                <option value="0" {{$flight -> has_wifi == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{$flight -> has_wifi == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label for="is_direct" class="block text-sm font-medium text-gray-700">Is Direct</label>
                            <select id="is_direct" name="is_direct" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm">
                                <option value="0" {{$flight -> is_direct == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{$flight -> is_direct == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label for="showcase" class="block text-sm font-medium text-gray-700">Showcase</label>
                            <select id="showcase" name="showcase" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm">
                               <option value="0" {{$flight -> showcase == 0 ? 'selected' : ''}}>No</option>
                               <option value="1" {{$flight -> showcase == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>

                        <!-- Pricing Fields -->
                        <div class="col-span-1">
                            <label for="oldprice" class="block text-sm font-medium text-gray-700">Old Price</label>
                            <input type="number" step="0.01" id="oldprice" name="oldprice" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->oldprice}}" required />
                        </div>

                        <div class="col-span-1">
                            <label for="newprice" class="block text-sm font-medium text-gray-700">New Price (Optional)</label>
                            <input type="number" step="0.01" id="newprice" name="newprice" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"  value="{{$flight->newprice}}"/>
                        </div>

                        <div class="col-span-1">
                            <label for="offer_percentage" class="block text-sm font-medium text-gray-700">Offer Percentage</label>
                            <input type="text" id="offer_percentage" name="percentage" class="mt-1 w-full rounded-md border-gray-200 bg-gray-100 text-sm text-gray-700 shadow-sm" value="{{$flight->percentage}}" readonly />
                        </div>

                        <!-- Other Details -->
                        <div class="col-span-1">
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                            <input type="text" id="duration" name="duration" class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm" value="{{$flight->duration}}" required readonly />
                        </div>

                        <!-- Submit -->
                        <div class="col-span-1">
                            <button type="submit" class="inline-block rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500">
                                Mettre à jour le Vol
                            </button>
                        </div>
                    </form>


                </div>
            </main>
        </div>
    </section>
</body>

</html>


{{-- calculet diffMinutes (12:00) from inputs time --}}
<script>
    // Function to calculate the duration between departing and arriving times
    function calculateDuration() {
        const departingTime = document.getElementById('departing_time').value;
        const arrivingTime = document.getElementById('arriving_time').value;

        if (departingTime && arrivingTime) {
            // Parse ISO strings to Date objects
            const departDate = new Date(departingTime);
            const arriveDate = new Date(arrivingTime);

            // Calculate the difference in milliseconds
            let diffMs = arriveDate - departDate;

            // Handle cases where arriving time is the next day
            if (diffMs < 0) {
                diffMs += 24 * 60 * 60 * 1000; // Add 24 hours in ms
            }

            // Convert difference to hours and minutes
            const diffMinutes = Math.floor(diffMs / (1000 * 60));
            const hours = Math.floor(diffMinutes / 60);
            const minutes = diffMinutes % 60;

            // Display the result
            const durationInput = document.getElementById('duration');
            durationInput.value = `${hours}h ${minutes}m`;
        } else {
            // Clear the duration field if inputs are missing
            document.getElementById('duration').value = '';
        }
    }

    // Function to handle the "Is Offer" selection
    function togglePriceField() {
        const isOffer = document.getElementById('is_offer').value;
        const newPriceField = document.getElementById('newprice');
        if (isOffer === '1') { // Offer is "Yes"
            newPriceField.disabled = false;
        } else { // Offer is "No"
            newPriceField.disabled = true;
            newPriceField.value = ''; // Clear the field when disabled
        }
    }

    // Event listeners for duration calculation
    document.getElementById('departing_time').addEventListener('input', calculateDuration);
    document.getElementById('arriving_time').addEventListener('input', calculateDuration);

    // Event listener for "Is Offer" selection
    document.getElementById('is_offer').addEventListener('change', togglePriceField);

    // Initialize the state of the price field on page load
    document.addEventListener('DOMContentLoaded', togglePriceField);
</script>
<script>
    // Select input fields
    const oldPriceInput = document.getElementById('oldprice');
    const newPriceInput = document.getElementById('newprice');
    const offerPercentageInput = document.getElementById('offer_percentage');

    // Function to calculate percentage
    function calculatePercentage() {
        const oldPrice = parseFloat(oldPriceInput.value);
        const newPrice = parseFloat(newPriceInput.value);

        // Validate inputs
        if (!isNaN(oldPrice) && !isNaN(newPrice) && oldPrice > 0 && newPrice > 0 && newPrice <= oldPrice) {
            const percentage = ((oldPrice - newPrice) / oldPrice) * 100;
            offerPercentageInput.value = `${percentage.toFixed(2)}`;
        } else {
            offerPercentageInput.value = '';
        }
    }

    // Attach event listeners to inputs
    oldPriceInput.addEventListener('input', calculatePercentage);
    newPriceInput.addEventListener('input', calculatePercentage);
</script>
