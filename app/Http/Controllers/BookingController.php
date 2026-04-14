<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function adminIndex()
    {
        $bookings = Booking::with('flight')->orderBy('created_at', 'desc')->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function create($flightId)
    {
        $flight = Flight::findOrFail($flightId);
        return view('bookings.create', compact('flight'));
    }

    public function store(Request $request, $flightId)
    {
        $flight = Flight::findOrFail($flightId);
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'travel_date' => 'required|date|after_or_equal:today',
            'passengers' => 'required|integer|min:1|max:10',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $pricePerPassenger = $flight->newprice ?: $flight->oldprice;
        $totalPrice = $pricePerPassenger * $request->passengers;

        $booking = Booking::create([
            'flight_id' => $flight->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'travel_date' => $request->travel_date,
            'passengers' => $request->passengers,
            'total_price' => $totalPrice,
            'booking_reference' => (new Booking())->generateBookingReference(),
            'status' => 'pending',
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->route('bookings.confirmation', $booking->id)
            ->with('success', 'Réservation effectuée avec succès!');
    }

    public function confirmation($bookingId)
    {
        $booking = Booking::with('flight')->findOrFail($bookingId);
        return view('bookings.confirmation', compact('booking'));
    }

    public function confirmBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'confirmed';
        $booking->save();
        
        return back()->with('success', 'Réservation confirmée avec succès.');
    }

    public function cancelBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'cancelled';
        $booking->save();
        
        return back()->with('success', 'Réservation annulée avec succès.');
    }

    public function showBooking($bookingId)
    {
        $booking = Booking::with('flight')->findOrFail($bookingId);
        return view('admin.booking-details', compact('booking'));
    }

    public function userCancelBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'cancelled';
        $booking->save();
        
        return back()->with('success', 'Réservation annulée avec succès.');
    }

    public function download($bookingId)
    {
        $booking = Booking::with('flight')->findOrFail($bookingId);
        
        // Check if booking is confirmed
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Seules les réservations confirmées peuvent être téléchargées.');
        }
        
        // Generate PDF content
        $pdfContent = $this->generateBookingPDF($booking);
        
        // Download PDF
        $filename = 'reservation_' . $booking->booking_reference . '.pdf';
        
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Length', strlen($pdfContent));
    }
    
    private function generateBookingPDF($booking)
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Réservation ' . $booking->booking_reference . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; border-bottom: 2px solid #0c47bc; padding-bottom: 20px; margin-bottom: 30px; }
                .section { margin-bottom: 25px; }
                .flight-info { background: #f8f9fa; padding: 15px; border-radius: 8px; }
                .passenger-info { background: #e9ecef; padding: 15px; border-radius: 8px; }
                .price-info { background: #d4edda; padding: 15px; border-radius: 8px; text-align: right; }
                .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
                .title { font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #0c47bc; }
                .label { font-weight: bold; color: #333; }
                .value { margin-bottom: 8px; }
                .status { padding: 5px 10px; border-radius: 4px; font-weight: bold; }
                .status-confirmed { background: #28a745; color: white; }
                .status-pending { background: #ffc107; color: #212529; }
                .status-cancelled { background: #dc3545; color: white; }
            </style>
        </head>
        <body>
            <div class="header">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="' . asset('images/logo.png') . '" class="h-10 w-auto object-contain" alt="GoVoyage Logo" />
                </a>
                <h1>Confirmation de Réservation</h1>
                <p>Référence: ' . $booking->booking_reference . '</p>
            </div>
            
            <div class="section">
                <div class="title">Informations du Vol</div>
                <div class="flight-info">
                    <div class="value"><strong>Compagnie:</strong> ' . $booking->flight->airline . '</div>
                    <div class="value"><strong>Vol:</strong> ' . $booking->flight->from_city . ' → ' . $booking->flight->to_city . '</div>
                    <div class="value"><strong>Date:</strong> ' . $booking->travel_date->format('d/m/Y') . '</div>
                    <div class="value"><strong>Durée:</strong> ' . $booking->flight->duration . '</div>
                    <div class="value"><strong>Passagers:</strong> ' . $booking->passengers . '</div>
                </div>
            </div>
            
            <div class="section">
                <div class="title">Informations du Passager</div>
                <div class="passenger-info">
                    <div class="value"><strong>Nom:</strong> ' . $booking->first_name . ' ' . $booking->last_name . '</div>
                    <div class="value"><strong>Email:</strong> ' . $booking->email . '</div>
                    <div class="value"><strong>Téléphone:</strong> ' . $booking->phone . '</div>
                    @if($booking->special_requests)
                        <div class="value"><strong>Demandes spéciales:</strong> ' . $booking->special_requests . '</div>
                    @endif
                </div>
            </div>
            
            <div class="section">
                <div class="title">Détails du Prix</div>
                <div class="price-info">
                    <div class="value"><strong>Prix par passager:</strong> ' . number_format($booking->flight->newprice ?: $booking->flight->oldprice, 2) . ' MAD</div>
                    <div class="value"><strong>Nombre de passagers:</strong> ' . $booking->passengers . '</div>
                    <div class="value" style="font-size: 20px; color: #28a745;"><strong>Total:</strong> ' . number_format($booking->total_price, 2) . ' MAD</div>
                </div>
            </div>
            
            <div class="section">
                <div class="title">Statut de la Réservation</div>
                <div class="status status-' . $booking->status . '">
                    ' . ucfirst($booking->status) . '
                </div>
            </div>
            
            <div class="footer">
                <p>Merci d\'avoir choisi GoVoyage pour votre voyage.</p>
                <p>Cette réservation a été générée le ' . $booking->created_at->format('d/m/Y à H:i') . '</p>
                <p>Pour toute question, contactez notre service client.</p>
            </div>
        </body>
        </html>';
        
        // Convert HTML to PDF using DomPDF or similar library
        // For now, we'll return the HTML as a simple implementation
        return $html;
    }

    public function myBookings()
    {
        $bookings = Booking::with('flight')->orderBy('created_at', 'desc')->get();
        return view('bookings.my-bookings', compact('bookings'));
    }
}
