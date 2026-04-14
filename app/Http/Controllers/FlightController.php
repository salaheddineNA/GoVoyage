<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Booking;
use App\Models\Contact;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function home()
    {
        $flights = Flight::all();
        return view("welcome",compact("flights"));
    }

    public function admin()
    {
        $flights = Flight::all();
        return view("admin");
    }

    public function dashboard()
    {
        $flights = Flight::orderBy('created_at', 'desc')->get();
        $bookings = Booking::with('flight')->orderBy('created_at', 'desc')->take(10)->get();
        $contacts = Contact::orderBy('created_at', 'desc')->take(5)->get();
        return view("admin.dashboard", compact("flights", "bookings", "contacts"));
    }

    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view("admin.contacts", compact("contacts"));
    }

    public function adminFlights()
    {
        $flights = Flight::orderBy('created_at', 'desc')->get();
        return view("admin.flights", compact("flights"));
    }

    public function adminCreateFlight()
    {
        return view("admin.flights-create");
    }
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'from_city' => 'required|string|max:255',
            'to_city' => 'required|string|max:255',
            'airline' => 'required|string|max:255',
            'imageAirline' => 'required|url',
            'cityimg' => 'required|url',
            'oldprice' => 'required|numeric',
            'newprice' => 'nullable|numeric',
            'percentage' => 'nullable|numeric',
            'departing_time' => 'required|date',
            'arriving_time' => 'required|date',
            'duration' => 'required|string|max:255',
            'has_wifi' => 'required|boolean',
            'is_direct' => 'required|boolean',
            'is_offer' => 'required|boolean',
            'showcase' => 'required|boolean',
        ]);

        // Create the flight with validated data
        Flight::create($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Flight added successfully!');
    }
    public function index(Request $request)
    {
        $query = Flight::query();
        
        // Search by departure city
        if ($request->filled('departure')) {
            $query->where('from_city', 'LIKE', '%' . $request->departure . '%');
        }
        
        // Search by arrival city
        if ($request->filled('arrival')) {
            $query->where('to_city', 'LIKE', '%' . $request->arrival . '%');
        }
        
        // Filter by direct flights only
        if ($request->filled('direct') && $request->direct == '1') {
            $query->where('is_direct', 1);
        }
        
        // Filter by WiFi availability
        if ($request->filled('wifi') && $request->wifi == '1') {
            $query->where('has_wifi', 1);
        }
        
        // Filter by price range
        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where('oldprice', '<=', $request->max_price)
                  ->orWhere('newprice', '<=', $request->max_price);
            });
        }
        
        $flights = $query->orderBy('created_at', 'desc')->get();
        
        // Debug: Log the query parameters
        \Log::info('Search parameters:', [
            'departure' => $request->departure,
            'arrival' => $request->arrival,
            'max_price' => $request->max_price,
            'direct' => $request->direct,
            'wifi' => $request->wifi,
            'results_count' => $flights->count()
        ]);
        
        return view('flights', compact('flights'));
    }
public function offer(Request $request)
{
    $query = Flight::query();
    
    // Search by departure city
    if ($request->filled('departure')) {
        $query->where('from_city', 'LIKE', '%' . $request->departure . '%');
    }
    
    // Search by destination city (using destination field from form)
    if ($request->filled('destination')) {
        $query->where('to_city', 'LIKE', '%' . $request->destination . '%');
    }
    
    // Filter by direct flights only
    if ($request->filled('direct') && $request->direct == '1') {
        $query->where('is_direct', 1);
    }
    
    // Filter by WiFi availability
    if ($request->filled('wifi') && $request->wifi == '1') {
        $query->where('has_wifi', 1);
    }
    
    // Filter by price range
    if ($request->filled('max_price')) {
        $query->where(function($q) use ($request) {
            $q->where('oldprice', '<=', $request->max_price)
              ->orWhere('newprice', '<=', $request->max_price);
        });
    }
    
    // Filter by travel date (using travel_date field from form)
    if ($request->filled('travel_date')) {
        $query->whereDate('departing_time', '>=', $request->travel_date);
    }
    
    // Only show offers
    $query->where('is_offer', 1);
    
    $flights = $query->orderBy('created_at', 'desc')->get();
    
    // Debug: Log the query parameters
    \Log::info('Offer search parameters:', [
        'departure' => $request->departure,
        'destination' => $request->destination,
        'max_price' => $request->max_price,
        'travel_date' => $request->travel_date,
        'direct' => $request->direct,
        'wifi' => $request->wifi,
        'honeymoon' => $request->honeymoon,
        'results_count' => $flights->count()
    ]);

    // Return the view with the compacted data
    return view('offers', compact('flights'));
}
public function supportpage()
{
    return view('support');
}

public function contactSubmit(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:1000'
    ]);

    Contact::create($validatedData);

    return redirect()->back()->with('success', 'Votre message a été envoyé avec succès!');
}

public function markContactAsRead($id)
{
    $contact = Contact::find($id);
    if ($contact) {
        $contact->status = 'read';
        $contact->save();
    }
    return redirect()->back();
}

public function markContactAsResolved($id)
{
    $contact = Contact::find($id);
    if ($contact) {
        $contact->status = 'resolved';
        $contact->save();
    }
    return redirect()->back();
}

public function deleteContact($id)
{
    $contact = Contact::find($id);
    if ($contact) {
        $contact->delete();
    }
    return redirect()->back()->with('success', 'Message supprimé avec succès!');
}

public function statistics()
{
    // Statistics data
    $totalFlights = Flight::count();
    $totalBookings = Booking::count();
    $totalContacts = Contact::count();
    
    // Flight statistics
    $totalOffers = Flight::where('is_offer', 1)->count();
    $directFlights = Flight::where('is_direct', 1)->count();
    $flightsWithWifi = Flight::where('has_wifi', 1)->count();
    
    // Booking statistics
    $confirmedBookings = Booking::where('status', 'confirmed')->count();
    $pendingBookings = Booking::where('status', 'pending')->count();
    $cancelledBookings = Booking::where('status', 'cancelled')->count();
    
    // Contact statistics
    $newContacts = Contact::where('status', 'new')->count();
    $readContacts = Contact::where('status', 'read')->count();
    $resolvedContacts = Contact::where('status', 'resolved')->count();
    
    // Revenue statistics
    $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
    $averageBookingValue = Booking::where('status', 'confirmed')->avg('total_price');
    
    // Recent activity (last 7 days)
    $recentBookings = Booking::where('created_at', '>=', now()->subDays(7))->count();
    $recentContacts = Contact::where('created_at', '>=', now()->subDays(7))->count();
    
    // Popular routes
    $popularRoutes = Booking::selectRaw('COUNT(*) as count, flights.from_city, flights.to_city')
        ->join('flights', 'bookings.flight_id', '=', 'flights.id')
        ->groupBy('flights.from_city', 'flights.to_city')
        ->orderByDesc('count')
        ->limit(5)
        ->get();
    
    // Monthly bookings trend
    $monthlyBookings = Booking::selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    
    return view('admin.statistics', compact(
        'totalFlights', 'totalBookings', 'totalContacts',
        'totalOffers', 'directFlights', 'flightsWithWifi',
        'confirmedBookings', 'pendingBookings', 'cancelledBookings',
        'newContacts', 'readContacts', 'resolvedContacts',
        'totalRevenue', 'averageBookingValue',
        'recentBookings', 'recentContacts',
        'popularRoutes', 'monthlyBookings'
    ));
}
// Update flight page
public function edit($id)
{
    $flight = Flight::find($id);
    return view('update', compact('flight'));
}
// Update a flight
public function update(Request $request, $id)
{
    // Find the flight by ID
    $flight = Flight::find($id);

    if (!$flight) {
        return redirect()->back()->with('error', 'Flight not found.');
    }

    // Validate the request
    $validatedData = $request->validate([
        'from_city' => 'required|string|max:255',
        'to_city' => 'required|string|max:255',
        'airline' => 'required|string|max:255',
        'imageAirline' => 'required|url',
        'cityimg' => 'required|url',
        'oldprice' => 'required|numeric',
        'newprice' => 'nullable|numeric',
        'percentage' => 'nullable|numeric',
        'departing_time' => 'required|date',
        'arriving_time' => 'required|date',
        'duration' => 'required|string|max:255',
        'has_wifi' => 'required|boolean',
        'is_direct' => 'required|boolean',
        'is_offer' => 'required|boolean',
        'showcase' => 'required|boolean',
    ]);

    // Update the flight
    $flight->update($validatedData);

     return to_route('offer')->with('success', 'Flight updated successfully!');
}

// Delete a flight
public function destroy($id)
{
    // Find the flight by ID
    $flight = Flight::find($id);

    if (!$flight) {
        return redirect()->back()->with('error', 'Flight not found.');
    }

    // Delete the flight
    $flight->delete();

    return redirect()->back()->with('success', 'Flight deleted successfully!');
}
}
