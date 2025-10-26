<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $rooms = Room::where('status', 'available')
                    ->orderBy('room_number')
                    ->get();
        
        return view('public.home', compact('rooms'));
    }


    /**
     * Display room details
     */
    public function roomDetail(Room $room)
    {
        $room->load('bookings');
        
        return view('public.room-detail', compact('room'));
    }

    /**
     * Show booking form (requires authentication)
     */
    public function showBookingForm(Room $room)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu untuk melakukan booking.');
        }

        return view('public.booking-form', compact('room'));
    }
}
