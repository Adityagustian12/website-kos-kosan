<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        // Prevent admin from booking rooms
        if (Auth::user()->role === 'admin') {
            return redirect()->back()
                           ->withErrors(['booking' => 'Admin tidak dapat melakukan booking kamar.'])
                           ->withInput();
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'booking_fee' => 'required|numeric|min:0',
            'documents.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if room is available
        $room = Room::findOrFail($request->room_id);
        if (!$room->isAvailable()) {
            return redirect()->back()
                           ->withErrors(['room_id' => 'Kamar tidak tersedia untuk booking.'])
                           ->withInput();
        }

        $booking = new Booking([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'booking_fee' => $request->booking_fee,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Handle document uploads
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $document) {
                $path = $document->store('booking-documents', 'public');
                $documents[] = $path;
            }
            $booking->documents = $documents;
        }

        $booking->save();

        return redirect()->route('seeker.dashboard')
                        ->with('success', 'Booking berhasil dibuat. Silakan upload bukti pembayaran booking fee.');
    }

    /**
     * Upload payment proof for booking
     */
    public function uploadPaymentProof(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('booking-payments', 'public');
            $booking->update(['payment_proof' => $path]);
        }

        return redirect()->back()
                        ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }

    /**
     * Cancel booking
     */
    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return redirect()->back()
                           ->withErrors(['booking' => 'Booking tidak dapat dibatalkan.']);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->back()
                        ->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Display user's bookings
     */
    public function myBookings()
    {
        // Prevent admin from accessing bookings
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Admin tidak dapat mengakses halaman booking.');
        }

        $bookings = Booking::where('user_id', Auth::id())
                          ->with('room')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        return view('tenant.bookings', compact('bookings'));
    }

    /**
     * Display booking details
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        $booking->load(['room', 'user']);
        
        return view('tenant.booking-detail', compact('booking'));
    }
}
